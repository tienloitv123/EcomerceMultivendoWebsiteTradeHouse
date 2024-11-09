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
use App\Models\VerificationToken;
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
}
