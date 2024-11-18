<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;

use App\Models\VerificationToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    public function login(Request $request){
        $data = [
            'pageTitle' => 'Client Login'
        ];
        return view('back.page.client.auth.login', $data);
    }

    public function register(Request $request){
        $data = [
            'pageTitle' => 'Create Client Account'
        ];
        return view('back.page.client.auth.register', $data);
    }

    public function createClient(Request $request){
        // Validate registration form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:5'
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = Hash::make($request->password);
        $saved = $client->save();

        if ($saved) {
            // Generate token
            $token = base64_encode(Str::random(64));

            VerificationToken::create([
                'user_type' => 'client',
                'email' => $request->email,
                'token' => $token
            ]);

            $actionLink = route('client.verify', ['token' => $token]);
            $data['action_link'] = $actionLink;
            $data['client_name'] = $request->name;
            $data['client_email'] = $request->email;

            // Send Activation link to client's email
            $mail_body = view('email-templates.client-verify-template', $data)->render();

            $mailConfig = [
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $request->email,
                'mail_recipient_name' => $request->name,
                'mail_subject' => 'Verify Client Account',
                'mail_body' => $mail_body
            ];

            if (sendEmail($mailConfig)) {
                return redirect()->route('client.register-success');
            } else {
                return redirect()->route('client.register')->with('fail', 'Something went wrong while sending verification link.');
            }
        } else {
            return redirect()->route('client.register')->with('fail', 'Something went wrong.');
        }
    }

    public function verifyAccount(Request $request, $token){
        $verifyToken = VerificationToken::where('token', $token)->first();

        if (!is_null($verifyToken)) {
            $client = Client::where('email', $verifyToken->email)->first();

            if (!$client->email_verified_at) {
                $client->email_verified_at = Carbon::now();
                $client->save();

                return redirect()->route('client.login')->with('success', 'Your email is verified. Login with your credentials.');
            } else {
                return redirect()->route('client.login')->with('info', 'Your email is already verified.');
            }
        } else {
            return redirect()->route('client.register')->with('fail', 'Invalid Token.');
        }
    }

    public function registerSuccess(Request $request){
        return view('back.page.client.auth.register-success');
    }

    public function loginHandler(Request $request){
        $request->validate([
            'login_id' => 'required|email|exists:clients,email',
            'password' => 'required|min:5'
        ], [
            'login_id.required' => 'Email is required.',
            'login_id.email' => 'Invalid email address.',
            'login_id.exists' => 'Email is not registered.',
            'password.required' => 'Password is required'
        ]);

        $credentials = [
            'email' => $request->login_id,
            'password' => $request->password
        ];

        if (Auth::guard('client')->attempt($credentials)) {
            return redirect()->route('client.home');
        } else {
            return redirect()->route('client.login')->with('fail', 'Incorrect password.');
        }
    }
    public function home(Request $request)
    {
        $featuredProducts = Product::where('visibility', 1)
        ->inRandomOrder()
        ->take(9)
        ->get();
        
        $newestProducts = Product::where('visibility', 1)->orderBy('created_at', 'desc')->take(7)->get(); // Lấy 7 sản phẩm mới nhất
        $cartItemCount = 0;
        if (auth('client')->check()) {
            $cart = Cart::where('client_id', auth('client')->id())->first();
            $cartItemCount = $cart ? $cart->cartDetails()->sum('quantity') : 0;
        }
        $data = [
            'pageTitle' => 'TradeHouse',
            'featuredProducts' => $featuredProducts,
            'newestProducts' => $newestProducts,
            'cartItemCount' => $cartItemCount
        ];

        return view('front.page.home', $data);
    }

    public function logoutHandler(Request $request){
        Auth::guard('client')->logout();
        return redirect()->route('home')->with('fail', 'You are logged out!');

    }

    public function profileView()
    {
        $client = Client::findOrFail(Auth::id());
        return view('back.page.client.profile', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:5',
            'email' => 'required|email|unique:clients,email,' . Auth::id(),
        ]);

        $client = Client::findOrFail(Auth::id());
        $client->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('client.profile')->with('message', 'Profile updated successfully.');
    }

    public function changeProfilePicture(Request $request)
    {
        $client = Client::findOrFail(auth('client')->id());
        $path = 'images/users/clients/';
        $file = $request->file('clientProfilePictureFile');
        $old_picture = $client->getAttributes()['picture'];
        $file_path = $path . $old_picture;
        $filename = 'CLIENT_IMG_' . rand(2, 1000) . $client->id . time() . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $filename);
        if ($upload) {
            if ($old_picture != null && File::exists(public_path($file_path))) {
                File::delete(public_path($file_path));
            }
            $client->update(['picture' => $filename]);
            return response()->json(['status' => 1, 'msg' => 'Your profile picture has been successfully updated.']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
        }
    }

    public function showCart()
    {
        $cartShops = []; // Định nghĩa biến $cartShops mặc định là mảng rỗng

        $cart = Cart::where('client_id', auth('client')->id())->first();

        if (!$cart || $cart->cartDetails()->count() == 0) {
            return view('back.page.client.cart', compact('cartShops'))
                ->with('message', 'Your cart is empty. Add items to your cart to proceed.');
        }

        $cartDetails = $cart->cartDetails()
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'price', 'compare_price', 'product_image', 'seller_id');
            }])
            ->get()
            ->groupBy('product.seller_id');

        foreach ($cartDetails as $sellerId => $details) {
            $shop = Shop::where('seller_id', $sellerId)->first();

            $shopTotal = 0;

            foreach ($details as $detail) {
                $shopTotal += $detail->product->price * $detail->quantity;
            }

            $cartShops[] = [
                'shop_id' => $sellerId,
                'shop_name' => $shop->shop_name ?? 'Unknown Shop',
                'items' => $details,
                'total' => $shopTotal,
            ];
        }

        return view('back.page.client.cart', compact('cartShops'));
    }


    public function updateCartQuantity(Request $request)
{
    $request->validate([
        'cart_detail_id' => 'required|integer|exists:cart_details,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $cartDetail = CartDetail::find($request->cart_detail_id);
    $cartDetail->quantity = $request->quantity;
    $cartDetail->save();

    $totalPrice = $cartDetail->quantity * $cartDetail->price;

    $shopTotal = $cartDetail->cart->cartDetails()
                     ->where('seller_id', $cartDetail->seller_id)
                     ->sum(DB::raw('quantity * price'));

    return response()->json([
        'success' => true,
        'totalPrice' => number_format($totalPrice, 2),
        'shopTotal' => number_format($shopTotal, 2),
        'shop_id' => $cartDetail->seller_id,
        'message' => 'Quantity updated successfully!',
    ]);
}

public function addToCart(Request $request)
{
    if (!auth('client')->check()) {
        return redirect()->route('client.login')->with('fail', 'You need to log in to add products to the cart.');
    }

    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product_id = $request->product_id;
    $quantity = $request->quantity;
    $product = Product::findOrFail($product_id);

    $cart = Cart::firstOrCreate(
        ['client_id' => auth('client')->id()],
        ['created_at' => now()]
    );
    $cartDetail = $cart->cartDetails()->where('product_id', $product_id)->first();

    if ($cartDetail) {
        $cartDetail->quantity += $quantity;
        $cartDetail->save();
    } else {
        $cart->cartDetails()->create([
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $product->price,
            'seller_id' => $product->seller_id,
        ]);
    }
    return redirect()->back()->with('success', 'Product added to cart successfully!');
}

public function removeItem(Request $request)
{
    $request->validate([
        'cart_detail_id' => 'required|integer|exists:cart_details,id',
    ]);

    $cartDetail = CartDetail::find($request->cart_detail_id);
    $cartDetail->delete();

    return response()->json([
        'success' => true,
        'message' => 'Item removed from cart.'
    ]);
}


 public function createOrder(Request $request)
{
    $request->validate([
        'shipping_address' => 'required|min:5',
        'phone' => 'required|min:5',
        'payment_method' => 'required|in:COD,CreditCard,PayPal',
        'seller_id' => 'required|integer|exists:sellers,id',
    ]);

    $client = auth('client')->user();
    $sellerId = $request->input('seller_id');

    $cart = Cart::where('client_id', $client->id)->first();
    $cartDetails = $cart->cartDetails()->where('seller_id', $sellerId)->with('product')->get();

    $totalAmount = $cartDetails->sum(function ($detail) {
        return $detail->quantity * $detail->product->price;
    });

    $order = Order::create([
        'client_id' => $client->id,
        'order_number' => 'ORDER-' . time() . '-' . rand(1000, 9999),
        'total_amount' => $totalAmount,
        'status' => 'pending',
        'payment_method' => $request->payment_method,
        'payment_status' => 'unpaid',
        'shipping_address' => $request->shipping_address,
        'phone' => $request->phone,
    ]);

    foreach ($cartDetails as $detail) {
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $detail->product_id,
            'seller_id' => $detail->seller_id,
            'quantity' => $detail->quantity,
            'price' => $detail->product->price,
            'total' => $detail->quantity * $detail->product->price,
        ]);
    }

    $cart->cartDetails()->where('seller_id', $sellerId)->delete();

    // Gửi email cho client
    $clientMailData = [
        'order' => $order,
        'orderDetails' => $order->orderDetails,
    ];

    $clientMailBody = view('email-templates.order-confirmation-client', $clientMailData)->render();

    $clientMailConfig = [
        'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
        'mail_from_name' => env('EMAIL_FROM_NAME'),
        'mail_recipient_email' => $client->email,
        'mail_recipient_name' => $client->name,
        'mail_subject' => 'Order Confirmation',
        'mail_body' => $clientMailBody,
    ];

    sendEmail($clientMailConfig);

    return redirect()->route('client.cart')->with('success', 'Your order has been created successfully!');
}

public function previewOrder(Request $request)
{
    $client = auth('client')->user();
    $sellerId = $request->input('seller_id'); // get seller_id

    $cart = Cart::with(['cartDetails' => function ($query) use ($sellerId) {
        $query->where('seller_id', $sellerId)->with('product');
    }])->where('client_id', $client->id)->first();

    if (!$cart || $cart->cartDetails->isEmpty()) {
        return redirect()->route('client.cart')->with('fail', 'Không có sản phẩm nào trong giỏ hàng của seller này.');
    }

    $totalAmount = $cart->cartDetails->sum(function ($detail) {
        return $detail->quantity * $detail->product->price;
    });

    return view('back.page.client.order.preview', [
        'shipping_address' => $client->address,
        'phone' => $client->phone,
        'payment_method' => 'COD',
        'cartDetails' => $cart->cartDetails,
        'totalAmount' => $totalAmount,
        'seller_id' => $sellerId,
    ]);
}


public function manageOrders()
{
    $clientId = auth('client')->id();
    $orders = Order::where('client_id', $clientId)->with('orderDetails.product')->get();

    return view('back.page.client.manage-orders', compact('orders'));
}

public function updateOrderStatus(Request $request, $orderId)
{
    $order = Order::where('id', $orderId)
                  ->where('client_id', auth('client')->id())
                  ->first();

    if (!$order) {
        return redirect()->back()->with('fail', 'Order not found.');
    }

    $action = $request->input('action');

    if ($action === 'cancel' && $order->status === 'pending') {
        $order->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Order canceled successfully.');
    }

    if ($action === 'received' && $order->status === 'delivery') {
        $order->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Order marked as received.');
    }

    return redirect()->back()->with('fail', 'Invalid action or order status.');
}


public function forgotPassword(Request $request) {
    $data = ['pageTitle' => 'Forgot Password'];
    return view('back.page.client.auth.forgot', $data);
}

public function sendPasswordResetLink(Request $request) {
    $request->validate([
        'email' => 'required|email|exists:clients,email'
    ], [
        'email.required' => 'The email is required',
        'email.email' => 'Invalid email address',
        'email.exists' => 'The email does not exist in our system'
    ]);

    $client = Client::where('email', $request->email)->first();
    $token = base64_encode(Str::random(64));

    $oldToken = DB::table('password_reset_tokens')
                  ->where(['email' => $client->email, 'guard' => 'client'])
                  ->first();

    if ($oldToken) {
        DB::table('password_reset_tokens')
          ->where(['email' => $client->email, 'guard' => 'client'])
          ->update([
              'token' => $token,
              'created_at' => Carbon::now()
          ]);
    } else {
        DB::table('password_reset_tokens')
          ->insert([
              'email' => $client->email,
              'guard' => 'client',
              'token' => $token,
              'created_at' => Carbon::now()
          ]);
    }

    $actionLink = route('client.reset-password', ['token' => $token, 'email' => urlencode($client->email)]);
    $data['actionLink'] = $actionLink;
    $data['client'] = $client;
    $mailBody = view('email-templates.client-forgot-email-template', $data)->render();

    $mailConfig = [
        'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
        'mail_from_name' => env('EMAIL_FROM_NAME'),
        'mail_recipient_email' => $client->email,
        'mail_recipient_name' => $client->name,
        'mail_subject' => 'Reset Password',
        'mail_body' => $mailBody
    ];

    if (sendEmail($mailConfig)) {
        return redirect()->route('client.forgot-password')->with('success', 'We have e-mailed your password reset link.');
    } else {
        return redirect()->route('client.forgot-password')->with('fail', 'Something went wrong.');
    }
}

public function showResetForm(Request $request, $token = null) {
    $getToken = DB::table('password_reset_tokens')
                  ->where(['token' => $token, 'guard' => 'client'])
                  ->first();

    if ($getToken) {
        $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $getToken->created_at)->diffInMinutes(Carbon::now());

        if ($diffMins > 15) {
            return redirect()->route('client.forgot-password')->with('fail', 'Token expired!. Request another reset password link.');
        } else {
            return view('back.page.client.auth.reset')->with(['token' => $token]);
        }
    } else {
        return redirect()->route('client.forgot-password')->with('fail', 'Invalid token!, request another reset password link.');
    }
}


public function resetPasswordHandler(Request $request) {
    $request->validate([
        'new_password' => 'required|min:5|max:45|same:confirm_new_password',
        'confirm_new_password' => 'required'
    ]);

    $token = DB::table('password_reset_tokens')
               ->where(['token' => $request->token, 'guard' => 'client'])
               ->first();

    $client = Client::where('email', $token->email)->first();

    Client::where('email', $client->email)->update([
        'password' => Hash::make($request->new_password)
    ]);

    DB::table('password_reset_tokens')->where([
        'email' => $client->email,
        'token' => $request->token,
        'guard' => 'client'
    ])->delete();

    $data['client'] = $client;
    $data['new_password'] = $request->new_password;
    $mailBody = view('email-templates.client-reset-email-template', $data);

    $mailConfig = [
        'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
        'mail_from_name' => env('EMAIL_FROM_NAME'),
        'mail_recipient_email' => $client->email,
        'mail_recipient_name' => $client->name,
        'mail_subject' => 'Password Changed',
        'mail_body' => $mailBody
    ];

    sendEmail($mailConfig);
    return redirect()->route('client.login')->with('success', 'Done!, Your password has been changed. Use new password to login into system.');
}



}
