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
use Illuminate\Support\Facades\File;

use constGuards;
use constDefaults;

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

    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if( $fieldType == 'email' ){
            $request->validate([
                'login_id'=>'required|email|exists:sellers,email',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required.',
                'login_id.email'=>'Invalid email address.',
                'login_id.exists'=>'Email is not exists in system.',
                'password.required'=>'Password is required'
            ]);
        }else{
            $request->validate([
                'login_id'=>'required|exists:sellers,username',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required.',
                'login_id.exists'=>'Username is not exists in system.',
                'password.required'=>'Password is required'
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if( Auth::guard('seller')->attempt($creds) ){
            // return redirect()->route('seller.home');
            if( !auth('seller')->user()->verified ){
                auth('seller')->logout();
                return redirect()->route('seller.login')->with('fail','Your account is not verified. Check in your email and click on the link we had sent in order to verify your email for seller account.');
            }else{
                return redirect()->route('seller.home');
            }
        }else{
            return redirect()->route('seller.login')->withInput()->with('fail','Incorrect password.');
        }
    }

    public function logoutHandler(Request $request){
        Auth::guard('seller')->logout();
        return redirect()->route('seller.login')->with('fail','You are logged out!');
    }

    public function forgotPassword(Request $request){
        $data = [
         'pageTitle' => 'Forgot Password'
        ];
        return view('back.page.seller.auth.forgot',$data);
     } //End Method

     public function sendPasswordResetLink(Request $request){
         //Validate the form
         $request->validate([
             'email'=>'required|email|exists:sellers,email'
         ],[
             'email.required'=>'The :attribute is required',
             'email.email'=>'Invalid email address',
             'email.exists'=>'The :attribute is not exists in our system'
         ]);

         //Get Seller details
         $seller = Seller::where('email',$request->email)->first();

         //Generate token
         $token = base64_encode(Str::random(64));

         //Check if there is an existing reset password token for this seller
         $oldToken = DB::table('password_reset_tokens')
                       ->where(['email'=>$seller->email,'guard'=>constGuards::SELLER])
                       ->first();

         if( $oldToken ){
             //UPDATE EXISTING TOKEN
             DB::table('password_reset_tokens')
               ->where(['email'=>$seller->email,'guard'=>constGuards::SELLER])
               ->update([
                 'token'=>$token,
                 'created_at'=>Carbon::now()
               ]);
         }else{
            //INSERT NEW RESET PASSWORD TOKEN
            DB::table('password_reset_tokens')
              ->insert([
                 'email'=>$seller->email,
                 'guard'=>constGuards::SELLER,
                 'token'=>$token,
                 'created_at'=>Carbon::now()
              ]);
         }

         $actionLink = route('seller.reset-password',['token'=>$token,'email'=>urlencode($seller->email)]);

         $data['actionLink'] = $actionLink;
         $data['seller'] = $seller;
         $mail_body = view('email-templates.seller-forgot-email-template',$data)->render();

         $mailConfig = array(
             'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
             'mail_from_name'=>env('EMAIL_FROM_NAME'),
             'mail_recipient_email'=>$seller->email,
             'mail_recipient_name'=>$seller->name,
             'mail_subject'=>'Reset Password',
             'mail_body'=>$mail_body
         );

         if( sendEmail($mailConfig) ){
             return redirect()->route('seller.forgot-password')->with('success','We have e-mailed your password reset link.');
         }else{
             return redirect()->route('seller.forgot-password')->with('fail','Something went wrong.');
         }

     } //End Method

     public function showResetForm(Request $request, $token = null){
        //Check if token exists
        $get_token = DB::table('password_reset_tokens')
                       ->where(['token'=>$token,'guard'=>constGuards::SELLER])
                       ->first();

        if( $get_token ){
           //Check if this token is not expired
           $diffMins = Carbon::createFromFormat('Y-m-d H:i:s',$get_token->created_at)->diffInMinutes(Carbon::now());

           if( $diffMins > constDefaults::tokenExpriredMinutes ){
             //When token is older that 15 minutes
             return redirect()->route('seller.forgot-password',['token'=>$token])->with('fail','Token expired!. Request another reset password link.');
           }else{
            return view('back.page.seller.auth.reset')->with(['token'=>$token]);
           }
        }else{
            return redirect()->route('seller.forgot-password',['token'=>$token])->with('fail','Invalid token!, request another reset password link.');
        }

    } //End Method

    public function resetPasswordHandler(Request $request){
        //Validate the form
        $request->validate([
           'new_password'=>'required|min:5|max:45|required_with:confirm_new_password|same:confirm_new_password',
           'confirm_new_password'=>'required'
        ]);

        $token = DB::table('password_reset_tokens')
                   ->where(['token'=>$request->token,'guard'=>constGuards::SELLER])
                   ->first();

        //Get seller details
        $seller = Seller::where('email',$token->email)->first();

        //Update seller password
        Seller::where('email',$seller->email)->update([
           'password'=>Hash::make($request->new_password)
        ]);

        //Delete token record
        DB::table('password_reset_tokens')->where([
           'email'=>$seller->email,
           'token'=>$request->token,
           'guard'=>constGuards::SELLER
        ])->delete();

        //Send email to notify seller for new password
        $data['seller'] = $seller;
        $data['new_password'] = $request->new_password;

        $mail_body = view('email-templates.seller-reset-email-template',$data);

        $mailConfig = array(
          'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
          'mail_from_name'=>env('EMAIL_FROM_NAME'),
          'mail_recipient_email'=>$seller->email,
          'mail_recipient_name'=>$seller->name,
          'mail_subject'=>'Password Changed',
          'mail_body'=>$mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('seller.login')->with('success','Done!, Your password has been changed. Use new password to login into system.');

      } //End Method

      public function profileView(Request $request){
        $data = [
            'pageTitle'=>'Profile'
        ];
        return view('back.page.seller.profile',$data);
    }// End Method

    public function changeProfilePicture(Request $request)
    {
        // Fetch the authenticated seller
        $seller = Seller::findOrFail(auth('seller')->id());

        // Define the path where seller profile pictures are stored
        $path = 'images/users/sellers/';

        // Get the uploaded file
        $file = $request->file('sellerProfilePictureFile');

        // Get the seller's current profile picture
        $old_picture = $seller->getAttributes()['picture'];
        $file_path = $path.$old_picture;

        // Generate a new filename for the uploaded image
        $filename = 'SELLER_IMG_'.rand(2,1000).$seller->id.time().uniqid().'.jpg';

        // Move the uploaded file to the designated directory
        $upload = $file->move(public_path($path), $filename);

        // If upload is successful
        if ($upload) {
            // Delete the old profile picture if it exists
            if ($old_picture != null && File::exists(public_path($path.$old_picture))) {
                File::delete(public_path($path.$old_picture));
            }

            // Update the seller's profile picture in the database
            $seller->update(['picture' => $filename]);

            // Return a success response
            return response()->json(['status' => 1, 'msg' => 'Your profile picture has been successfully updated.']);
        } else {
            // Return an error response
            return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
        }
    }
}
