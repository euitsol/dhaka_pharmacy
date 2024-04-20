@extends('frontend.layouts.master')
@section('title', 'User Login')

@push('css')
    <link rel="stylesheet" href="{{asset('user_login/style.css')}}">
@endpush
@section('content')
<section class="log-with-pass">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="left-col">
                    <div class="form-title">
                        <h1 class="otp_title">LOGIN IN WITH OTP</h1>
                        <h1 class="login_title" style="display: none;">LOGIN WITH PASSWORD</h1>
                        <h3>Follow the instructions to make it easier to register and you will be able to explore
                            inside.</h3>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="phn input-box">
                            <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                            <input type="phone" name="phone" placeholder="Phone">
                        </div>
                        <div class="pass input-box password_input" style="display: none;">
                            <span class="icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" placeholder="Password" id="password">
                            <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                        </div>
                        <p class="get-otp" style="display: none;">Login With Phone? <a class="otp_switch" href="javascript:void(0)">GET OTP</a></p>
                        <p class="get-otp">Login With Password? <a class="login_switch" href="javascript:void(0)">Login</a></p>
                        <input class="login_button" type="submit" style="display: none;" value="LOGIN">
                        <input class="otp_button" type="submit" value="SEND OTP">
                    </form>
                    <p class="or-login">Or login With</p>
                    <div class="other-login">
                        <a href="{{route('login_with_google')}}" class="google">
                            <img src="{{asset('user_login/img/logos--google-icon.svg')}}" alt="">
                            <span>Google</span>
                        </a>
                        <a href="{{route('login_with_facebook')}}" class="facebook">
                            <img src="{{asset('user_login/img/logos--facebook.svg')}}" alt="">
                            <span>Facebook</span>
                        </a>
                        <a href="{{route('login_with_github')}}" class="apple">
                            <img src="{{asset('user_login/img/logos--apple.svg')}}" alt="">
                            <span>Apple</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="right-col">

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
    <script src="{{asset('user_login/app.js')}}"></script>
@endpush

