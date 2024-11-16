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

use App\Models\VerificationToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    public function login(Request $request){
        $data = [
            'pageTitle' => 'Client Login'
        ];
        return view('back.page.client.auth..login', $data);
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
        $featuredProducts = Product::where('visibility', 1)->latest()->take(10)->get(); // Lấy 10 sản phẩm mới nhất
        $data = [
            'pageTitle' => 'TradeHouse',
            'featuredProducts' => $featuredProducts
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
        $cart = Cart::where('client_id', auth('client')->id())->first();

        if (!$cart || $cart->cartDetails()->count() == 0) {
            return view('back.page.client.cart')->with('message', 'Your cart is empty.');
        }

        $cartDetails = $cart->cartDetails()
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'price', 'compare_price', 'product_image', 'seller_id');
            }])
            ->get()
            ->groupBy('product.seller_id');

        $cartShops = [];

        foreach ($cartDetails as $sellerId => $details) {
            $shop = Shop::where('seller_id', $sellerId)->first();

            $shopTotal = 0;

            foreach ($details as $detail) {
                $shopTotal += $detail->product->price * $detail->quantity;
            }

            $cartShops[] = [
                'shop_id' => $sellerId,  // Thêm shop_id ở đây
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

    // Tìm cartDetail và cập nhật số lượng
    $cartDetail = CartDetail::find($request->cart_detail_id);
    $cartDetail->quantity = $request->quantity;
    $cartDetail->save();

    // Tính tổng giá trị của sản phẩm
    $totalPrice = $cartDetail->quantity * $cartDetail->price;

    // Tính tổng giá của shop sau khi cập nhật số lượng cho tất cả các sản phẩm có cùng seller_id trong cart
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
    $cartDetail = $cart->cartDetails()->updateOrCreate(
        ['cart_id' => $cart->id, 'product_id' => $product_id],
        [
            'quantity' => DB::raw("quantity + $quantity"),
            'price' => $product->price,
            'seller_id' => $product->seller_id,
        ]
    );
    return redirect()->back()->with('success', 'Product added to cart successfully!');

}

// public function updateCartQuantity(Request $request)
// {
//     $request->validate([
//         'cart_detail_id' => 'required|integer|exists:cart_details,id',
//         'quantity' => 'required|integer|min:1',
//     ]);

//     $cartDetail = CartDetail::find($request->cart_detail_id);
//     $cartDetail->quantity = $request->quantity;
//     $cartDetail->save();

//     $shopTotal = $cartDetail->cart->cartDetails()
//                      ->where('seller_id', $cartDetail->seller_id)
//                      ->sum(DB::raw('quantity * price'));

//     return response()->json([
//         'success' => true,
//         'totalPrice' => number_format($cartDetail->quantity * $cartDetail->price, 2),
//         'shopTotal' => number_format($shopTotal, 2),
//         'shop_id' => $cartDetail->seller_id,
//         'message' => 'Quantity updated successfully!',
//     ]);
// }


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

}
