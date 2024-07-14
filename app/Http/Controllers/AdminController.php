<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginHandler(request $request ){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ?"email":"ussername";
        if($fieldType == 'email'){
            $request->validate([
            'login_id'=>' required|email|exists:admins,email',
                'password'=> 'required|min:5|max:45'
            ],[
                'login_id.required'=> 'Email or Username is required',
                'login_id.email'=>'Invalid email address',
                'login_id_exists'=> 'Emaill is not exist in system',
                'password.required'=> 'Passwords is reuquired'
            ]);
        }
        else{
            $request->validate([
                'login_id'=> 'required|exists:admins,username',
                'login_id.exist'=> 'required|min:5|max:45'

            ],[
                'login_id.required'=> 'Email or Username is required',
                'login_id_exists'=> 'Emaill is not exist in system',
                'password.required'=> 'Passwords is reuquired'
            ]
        );
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password'=> $request->password
        );

        if(Auth::guard('admin')->attempt($creds)){
            return redirect()->route('admin.home');
        }else{
            session()->flash('fail','Incorrect credential');
            return redirect()->route('admin.login');
        }

    }

    public function logoutHandler(Request $request){
        Auth::guard('admin')->logout();
        session()->flash('fail','You are logged out!');
        return redirect()->route('admin.login');
    }
}
