@extends('frontend.layouts.master')
@section('title', 'User Login')

@push('css')
    <link rel="stylesheet" href="{{ asset('user/user_login/style.css') }}">
@endpush
@section('content')
    <section class="log-with-pass">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="left-col login_wrap">
                        <div class="form-title">
                            <h1 class="otp_title">{{ __('LOGIN IN WITH OTP') }}</h1>
                            <h1 class="login_title" style="display: none;">{{ __('LOGIN WITH PASSWORD') }}</h1>
                            <h3>{{ __('Follow the instructions to make it easier to register and you will be able to explore inside.') }}
                            </h3>
                        </div>


                        {{-- Sent OTP --}}
                        <form class="otp_form" autocomplete="off" method="POST" action="{{ route('use.send_otp') }}">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" placeholder="Phone" class="phone" autocomplete="off"
                                    readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])


                            <button class="otp_button submit_button">{{ __('SEND OTP') }}</button>
                            <p class="get-otp"><a class="login_switch"
                                    href="javascript:void(0)">{{ __('Login with password?') }}</a>
                            </p>
                            {{-- <p class="get-otp">{{ __('Not yet registered? ') }}<a
                                    href="{{ route('use.register') }}">{{ __('Create an account') }}</a>
                            </p> --}}

                        </form>


                        {{-- login With Password --}}
                        <form action="{{ route('login') }}" method="POST" class="login_form" style="display: none;"
                            autocomplete="off">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" placeholder="Phone" class="phone" autocomplete="off"
                                    readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])
                            <div class="pass input-box password_input">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" placeholder="Password" class="password"
                                    autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                            </div>
                            @include('alerts.feedback', ['field' => 'password'])

                            <p class="rfp text-end mb-2"><a class="forgot-password"
                                    href="{{ route('user.forgot.password') }}">{{ __('Lost your password?') }}</a></p>


                            <input class="login_button submit_button" type="submit" value="LOGIN">
                            <p class="get-otp"> <a class="otp_switch"
                                    href="javascript:void(0)">{{ __('Login with phone?') }}</a></p>
                            {{-- <p class="get-otp">{{ __('Not yet registered? ') }}<a
                                    href="{{ route('use.register') }}">{{ __('Create an
                                                                                                                                                                                                                                                                                                                                                                                                                                                account') }}</a>
                            </p> --}}
                        </form>
                        {{-- login With Password --}}
                        @include('auth.login_with')
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
    <script src="{{ asset('user/user_login/app.js') }}"></script>
@endpush
