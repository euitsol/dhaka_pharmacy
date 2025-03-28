@extends('frontend.layouts.master')
@section('title', 'User Login')

@push('css')
    <link rel="stylesheet" href="{{ asset('user/user_login/style.css') }}">
@endpush
@section('content')
    <section class="log-with-pass">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xxl-6 col-md-10 mx-auto">
                    <div class="left-col login_wrap">
                        <div class="form-title">
                            <h1 class="otp_title">{{ __('LOG IN OR REGISTER WITH OTP') }}</h1>
                            <h1 class="login_title" style="display: none;">{{ __('LOGIN WITH PASSWORD') }}</h1>
                            <h3 class="otp_title">
                                {{ __('If you are new, entering your phone number will automatically register you') }}
                            </h3>
                            <h3 class="login_title" style="display: none;">
                                {{ __('If you already have an account, you can login with your password') }}</h3>
                        </div>


                        <form class="otp_form" autocomplete="off" method="POST" action="{{ route('use.send_otp') }}">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{__('Phone')}}"
                                    class="phone" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])


                            <button class="otp_button submit_button">{{ __('SEND OTP') }}</button>
                            <p class="get-otp"><a class="login_switch"
                                    href="javascript:void(0)">{{ __('Login with password?') }}</a>
                            </p>

                        </form>

                        <form action="{{ route('login') }}" method="POST" class="login_form" style="display: none;"
                            autocomplete="off">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{__('Phone')}}"
                                    class="phone" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])
                            <div class="pass input-box password_input">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" placeholder="{{__('Password')}}" class="password"
                                    autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                            </div>
                            @include('alerts.feedback', ['field' => 'password'])

                            <p class="rfp text-end mb-2"><a class="forgot-password"
                                    href="{{ route('user.forgot.password') }}">{{ __('Lost your password?') }}</a></p>


                            <input class="login_button submit_button" type="submit" value="{{__('Login')}}">
                            <p class="get-otp"> <a class="otp_switch"
                                    href="javascript:void(0)">{{ __('Login with OTP?') }}</a></p>
                        </form>
                        @include('auth.login_with')
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-6 d-none d-lg-block">
                    <div class="right-col">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('user/user_login/app.js') }}"></script>
@endpush
