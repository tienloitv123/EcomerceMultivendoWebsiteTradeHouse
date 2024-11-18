@extends('back.layout.auth-layout')
@section('pageTitle', 'Forgot Password')
@section('content')

<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Forgot Password</h2>
    </div>
    <p class="text-center">Enter your email address to reset your password</p>
    <form action="{{ route('client.send-password-reset-link') }}" method="POST">
        @csrf
        <x-arlet.form-arlet />
        <div class="input-group custom">
            <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required>
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
            </div>
        </div>
        @error('email')
        <span class="text-danger d-block" style="margin-top: -25px;margin-bottom:5px;">{{ $message }}</span>
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
