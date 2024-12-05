<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Seller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use constGuards;
use constDefaults;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dailyRevenue = Order::whereDate('created_at', now())->sum('total_amount');
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)->sum('total_amount');
        $yearlyRevenue = Order::whereYear('created_at', now()->year)->sum('total_amount');
        $totalRevenue = $yearlyRevenue;
        $totalClients = Client::count();
        $totalSellers = Seller::count();
        $totalUsers = $totalClients + $totalSellers;

        $activeProducts = Product::where('visibility', '1')->count();

        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $processingOrders = Order::where('status', 'pending')->count();
        $canceledOrders = Order::where('status', 'rejected')->count();

        $revenueByDate = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueByCategory = OrderDetail::join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category', '=', 'categories.id')
            ->select('categories.category_name', DB::raw('SUM(order_details.total) as revenue'))
            ->groupBy('categories.category_name')
            ->orderBy('revenue', 'desc')
            ->get();

        $orderStats = [
            'completed' => $completedOrders,
            'processing' => $processingOrders,
            'canceled' => $canceledOrders,
        ];

        $userGrowth = Client::selectRaw('DATE(created_at) as date, COUNT(*) as total_clients')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $sellerGrowth = Seller::selectRaw('DATE(created_at) as date, COUNT(*) as total_sellers')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $recentOrders = Order::latest()->take(10)->get();
        $recentUsers = Client::latest()->take(5)->get()->merge(Seller::latest()->take(5)->get());

        return view('back.page.admin.home', compact(
            'dailyRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'totalUsers',
            'totalClients',
            'totalSellers',
            'totalRevenue',
            'activeProducts',
            'totalOrders',
            'orderStats',
            'revenueByDate',
            'revenueByCategory',
            'userGrowth',
            'sellerGrowth',
            'recentOrders',
            'recentUsers'
        ));
    }


    public function loginHandler(request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? "email" : "ussername";
        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => ' required|email|exists:admins,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required',
                'login_id.email' => 'Invalid email address',
                'login_id_exists' => 'Emaill is not exist in system',
                'password.required' => 'Passwords is reuquired'
            ]);
        } else {
            $request->validate(
                [
                    'login_id' => 'required|exists:admins,username',
                    'login_id.exist' => 'required|min:5|max:45'

                ],
                [
                    'login_id.required' => 'Email or Username is required',
                    'login_id_exists' => 'Emaill is not exist in system',
                    'password.required' => 'Passwords is reuquired'
                ]
            );
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        } else {
            session()->flash('fail', 'Incorrect credential');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request)
    {
        Auth::guard('admin')->logout();
        session()->flash('fail', 'You are logged out!');
        return redirect()->route('admin.login');
    }

    public function  sendPasswordResetLink(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The :attribute is not exists in system'
        ]);

        //Get admin details
        $admin = Admin::where('email', $request->email)->first();

        //Generate token
        $token = base64_encode(Str::random(64));

        //Check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
            ->first();
        if ($oldToken) {
            //Update token
            DB::table('password_reset_tokens')
                ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            //Add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }
        $actionLink = route('admin.reset-password', ['token' => $token, 'email' => $request->email]);

        $data = array(
            'actionLink' => $actionLink,
            'admin' => $admin
        );

        $mail_body = view('email-templates.admin-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Reset password',
            'mail_body' => $mail_body
        );

        if (sendEmail($mailConfig)) {
            session()->flash('success', 'We have e-mailed your password reset link.');
            return redirect()->route('admin.forgot-password');
        } else {
            session()->flash('fail', 'Something went wrong!');
            return redirect()->route('admin.forgot-password');
        }
    }

    public function resetPassword(Request $request, $token = null){
        $check_token = DB::table('password_reset_tokens')
                         ->where(['token'=>$token,'guard'=>constGuards::ADMIN])
                         ->first();

        if( $check_token ){
            //Check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if( $diffMins > constDefaults::tokenExpriredMinutes ){
               //If token expired
               session()->flash('fail','Token expired, request another reset password link.');
               return redirect()->route('admin.forgot-password',['token'=>$token]);
            }else{
                return view('back.page.admin.auth.reset-password')->with(['token'=>$token]);
            }
        }else{
            session()->flash('fail','Invalid token!, request another reset password link');
            return redirect()->route('admin.forgot-password',['token'=>$token]);
        }
    }

    public function resetPasswordHandler(Request $request){
        $request->validate([
            'new_password'=>'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation'=>'required'
        ]);

        $token = DB::table('password_reset_tokens')
                   ->where(['token'=>$request->token,'guard'=>constGuards::ADMIN])
                   ->first();

        //Get admin details
        $admin = Admin::where('email',$token->email)->first();

        //Update admin password
        Admin::where('email',$admin->email)->update([
            'password'=>Hash::make($request->new_password)
        ]);

        //Delete token record
        DB::table('password_reset_tokens')->where([
            'email'=>$admin->email,
            'token'=>$request->token,
            'guard'=>constGuards::ADMIN
        ])->delete();

        //Send email to notify admin
        $data = array(
            'admin'=>$admin,
            'new_password'=>$request->new_password
        );

        $mail_body = view('email-templates.admin-reset-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$admin->email,
            'mail_recipient_name'=>$admin->name,
            'mail_subject'=>'Password changed',
            'mail_body'=>$mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('admin.login')->with('success','Done!, Your password has been changed. Use new password to login into system.');
    }

    public function profileView(Request $request){
        $admin = null;
        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.page.admin.profile', compact('admin'));
    }

    public function changeProfilePicture(Request $request){
        $admin = Admin::findOrFail(auth('admin')->id());
        $path = 'images/users/admins/';
        $file = $request->file('adminProfilePictureFile');
        $old_picture = $admin->getAttributes()['picture'];
        $file_path = $path.$old_picture;
        $filename = 'ADMIN_IMG_'.rand(2,1000).$admin->id.time().uniqid().'.jpg';

        $upload = $file->move(public_path($path),$filename);

        if($upload){
            if( $old_picture != null && File::exists(public_path($path.$old_picture)) ){
                File::delete(public_path($path.$old_picture));
            }
            $admin->update(['picture'=>$filename]);
            return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
        }
    }

    public function changeLogo(Request $request){
        $path = 'images/site/';
        $file = $request->file('site_logo');
        $settings = new GeneralSetting();
        $old_logo = $settings->first()->site_logo;
        $file_path = $path.$old_logo;
        $filename = 'LOGO_'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(public_path($path),$filename);

        if( $upload ){
            if( $old_logo != null && File::exists(public_path($path.$old_logo)) ){
                File::delete(public_path($path.$old_logo));
            }
            $settings = $settings->first();
            $settings->site_logo = $filename;
            $update = $settings->save();

            return response()->json(['status'=>1,'msg'=>'Site logo has been updated successfully.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
        }
    }

    public function changeFavicon(Request $request){
        $path = 'images/site/';
        $file = $request->file('site_favicon');
        $settings = new GeneralSetting();
        $old_favicon = $settings->first()->site_favicon;
        $filename = 'FAV_'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if( $upload ){
           if( $old_favicon != null && File::exists(public_path($path.$old_favicon)) ){
             File::delete(public_path($path.$old_favicon));
           }
           $settings = $settings->first();
           $settings->site_favicon = $filename;
           $update = $settings->save();

           return response()->json(['status'=>1,'msg'=>'Done!, site favicon has been updated successfully.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
        }
    }

    public function manageClients()
    {
        $clients = Client::paginate(10); // Phân trang 10 client mỗi trang
        return view('back.page.admin.manage-client', compact('clients'));
    }

    public function manageSellers()
    {
        $sellers = Seller::paginate(10); // Phân trang 10 seller mỗi trang
        return view('back.page.admin.manage-seller', compact('sellers'));
    }

}
