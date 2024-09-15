<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function login(Request $request){
        $data = [
            'pageTitle'=>'Seller Login'
        ];
        return view('back.page.seller.auth.login',$data);
    }

    public function createSeller(Request $request){
        //Validate Seller Registration Form
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:sellers',
            'password'=>'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password'=>'min:5'
        ]);

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->password = Hash::make($request->password);
        $saved = $seller->save();

        if( $saved ){
           //Generate token
           $token = base64_encode(Str::random(64));

           VerificationToken::create([
              'user_type'=>'seller',
              'email'=>$request->email,
              'token'=>$token
           ]);

           $actionLink = route('seller.verify',['token'=>$token]);
           $data['action_link'] = $actionLink;
           $data['seller_name'] = $request->name;
           $data['seller_email'] = $request->email;

        //    dd(env('MAIL_FROM_ADDRESS'));

           //Send Activation link to this seller email
           $mail_body = view('email-templates.seller-verify-template',$data)->render();

           $mailConfig = array(
              'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
              'mail_from_name'=>env('EMAIL_FROM_NAME'),
              'mail_recipient_email'=>$request->email,
              'mail_recipient_name'=>$request->name,
              'mail_subject'=>'Verify Seller Account',
              'mail_body'=>$mail_body
           );

           if( sendEmail($mailConfig) ){
              return redirect()->route('seller.register-success');
           }else{
             return redirect()->route('seller.register')->with('fail','Something went wrong while sending verification link.');
           }
        }else{
            return redirect()->route('seller.register')->with('fail','Something went wrong.');
        }
    }
    public function verifyAccount(Request $requet, $token){
        $verifyToken = VerificationToken::where('token',$token)->first();

        if( !is_null($verifyToken) ){
            $seller = Seller::where('email',$verifyToken->email)->first();

            if( !$seller->verified ){
                $seller->verified = 1;
                $seller->email_verified_at = Carbon::now();
                $seller->save();

                return redirect()->route('seller.login')->with('success','Good!, Your e-mail is verified. Login with your credentials and complete setup your seller account.');
            }else{
                return redirect()->route('seller.login')->with('info','Your e-mail is already verified. You can now login.');
            }
        }else{
            return redirect()->route('seller.register')->with('fail','Invalid Token.');
        }
    } //End Method

    public function registerSuccess(Request $request){
        return view('back.page.seller.register-success');
    }
    public function register(Request $request){
        $data =[
            'pageTitle'=>'Create seller account'
        ];
        return view('back.page.seller.auth.register',$data);
    }

    public function home(Request $request){
        $data = [
            'pageTitle'=>'Seller Dashboard'
        ];
        return view('back.page.seller.home',$data);
    }
}
