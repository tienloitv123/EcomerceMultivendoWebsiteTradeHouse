@extends('back.layout.auth-layout')
@section('pageTitle', 'Reset Password')
@section('content')

<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Reset Password</h2>
    </div>
    <p class="text-center">Enter your new password, confirm it, and submit.</p>
    <form action="{{ route('client.reset-password-handler') }}" method="POST">
        @csrf
        <x-arlet.form-arlet />
        <input type="hidden" name="token" value="{{ request()->token }}">
        <div class="input-group custom">
            <input type="password" class="form-control form-control-lg" placeholder="New Password" name="new_password" required>
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
            </div>
        </div>
        @error('new_password')
        <span class="text-danger" style="margin-top: -25px;margin-bottom:5px;">{{ $message }}</span>
        @enderror
        <div class="input-group custom">
            <input type="password" class="form-control form-control-lg" placeholder="Confirm New Password" name="confirm_new_password" required>
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
            </div>
        </div>
        @error('confirm_new_password')
        <span class="text-danger" style="margin-top: -25px;margin-bottom:5px;">{{ $message }}</span>
        @enderror
        <div class="row align-items-center">
            <div class="col-12">
                <div class="input-group mb-0">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
