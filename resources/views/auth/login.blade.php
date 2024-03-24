@extends('frontend.layouts.master')
@section('title', 'User Login')

@push('css')
    <style>
        img {
            width: 100%;
        }

        .login_box {
            width: 1050px;
            height: 600px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 1px 4px 22px -8px #0004;
            display: flex;
            overflow: hidden;
        }

        .login_box .left {
            width: 41%;
            height: 100%;
            padding: 25px 25px;
            position: relative;

        }

        .login_box .right {
            width: 59%;
            height: 100%
        }

        .left .top_link a {
            color: #452A5A;
            font-weight: 400;
        }

        .left .top_link {
            height: 20px
        }

        .left .contact {
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: center;
            height: 100%;
            width: 73%;
            margin: auto;
        }

        .left h3 {
            text-align: center;
            margin-bottom: 40px;
        }

        .left input {
            border: none;
            width: 80%;
            margin: 15px 0px;
            border-bottom: 1px solid #4f30677d;
            padding: 7px 9px;
            width: 100%;
            overflow: hidden;
            background: transparent;
            font-weight: 600;
            font-size: 14px;
        }

        .left {
            background: linear-gradient(-45deg, #dcd7e0, #fff);
        }

        .submit {
            border: none;
            padding: 15px 70px;
            border-radius: 8px;
            display: block;
            margin: auto;
            margin-top: 120px;
            background: var(--secondary-bg);
            color: #fff;
            font-weight: bold;
            -webkit-box-shadow: 0px 9px 15px -11px rgba(88, 54, 114, 1);
            -moz-box-shadow: 0px 9px 15px -11px rgba(88, 54, 114, 1);
            box-shadow: 0px 9px 15px -11px rgba(88, 54, 114, 1);
        }



        .right {
            background: linear-gradient(212.38deg, rgba(133, 255, 190, 0.5) 0%, rgba(45, 152, 218, 0.5) 100%), url('../frontend/asset/img/user_login_img.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            color: #fff;
            position: relative;
        }

        .right .right-text {
            height: 100%;
            position: relative;
            transform: translate(0%, 45%);
        }

        .right-text h2 {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 50px;
            font-weight: 500;
        }

        .right-text h5 {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 19px;
            font-weight: 400;
        }

        .right .right-inductor {
            position: absolute;
            width: 70px;
            height: 7px;
            background: #fff0;
            left: 50%;
            bottom: 70px;
            transform: translate(-50%, 0%);
        }

        .top_link img {
            width: 28px;
            padding-right: 7px;
            margin-top: -3px;
        }
    </style>


    <style>
        .tabbed {
            width: 93%;
            min-width: 400px;
            overflow: hidden;
            transition: border 250ms ease;
            position: absolute;
            left: 13px;
            top: 35px;
            /* border-bottom: 4px solid var(--border-1); */
        }

        .tabbed ul {
            margin: 0px;
            padding: 0px;
            overflow: hidden;
            float: left;
            padding-left: 48px;
            list-style-type: none;
        }

        .tabbed ul * {
            margin: 0px;
            padding: 0px;
        }

        .tabbed ul li {
            display: block;
            float: right;
            padding: 10px 5px 8px;
            background-color: #FFF;
            margin-right: 40px;
            z-index: 2;
            position: relative;
            cursor: pointer;
            color: #777;
            text-transform: uppercase;
            font: 600 13px/20px roboto, "Open Sans", Helvetica, sans-serif;
            transition: all 250ms ease;
        }

        .tabbed ul li:before,
        .tabbed ul li:after {
            display: block;
            content: " ";
            position: absolute;
            top: 0;
            height: 100%;
            width: 35px;
            background-color: #FFF;
            transition: all 250ms ease;
            z-index: -1;
        }

        .tabbed ul li:before {
            right: -24px;
            transform: skew(30deg, 0deg);
            box-shadow: rgba(0, 0, 0, .1) 3px 2px 5px, inset rgba(255, 255, 255, .09) -1px 0;
        }

        .tabbed ul li:after {
            left: -24px;
            transform: skew(-30deg, 0deg);
            box-shadow: rgba(0, 0, 0, .1) -3px 2px 5px, inset rgba(255, 255, 255, .09) 1px 0;
        }

        .tabbed ul li:hover,
        .tabbed ul li:hover:before,
        .tabbed ul li:hover:after {
            background-color: #F4F7F9;
            color: #444;
        }

        .tabbed ul li.active {
            z-index: 3;
        }

        .tabbed ul li.active,
        .tabbed ul li.active:before,
        .tabbed ul li.active:after {
            background-color: var(--secondary-bg);
            color: #fff;
        }

        /* Round Tabs */
        .tabbed.round ul li {
            border-radius: 8px 8px 0 0;
        }

        .tabbed.round ul li:before {
            border-radius: 0 8px 0 0;
        }

        .tabbed.round ul li:after {
            border-radius: 8px 0 0 0;
        }
    </style>
@endpush

{{-- @section('content')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-header"><a href="{{ route('login_with_google') }}">{{ __('Login With Google') }}</a>
                    </div>
                    <div class="card-header"><a href="{{ route('login_with_github') }}">{{ __('Login With Github') }}</a>
                    </div>
                    <div class="card-header"><a href="{{ route('login_with_facebook') }}">{{ __('Login With Facebook') }}</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
@section('content')
    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-md-10 mx-auto">

                <div class="login_box mx-auto">

                    <div class="left">
                        {{-- <div class="top_link"><a href="{{ route('home') }}">{{ __('Return home') }}</a></div> --}}


                        <div class="tabbed round">
                            <ul>
                                <li>{{ __('Login With OTP') }}</li>
                                <li class="active">{{ __('Login With Password') }}</li>
                            </ul>
                        </div>
                        <div class="contact">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                {{-- <h3>{{ __('SIGN IN') }}</h3> --}}
                                <input type="phone" name="phone" placeholder="PHONE">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" name="password" placeholder="PASSWORD">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button class="submit">{{ __('LET\'S GO') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="right-text">
                            <h2>{{ __('Dhaka Pharmacy') }}</h2>
                            <h5>{{ __('User Login Portal') }}</h5>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
@push('js')
   <script>
    $(document).ready(function() {
        $('.tabbed li').click(function() {
            if ($(this).hasClass('active'))
            return;

            var parent = $(this).parent(),
                innerTabs = parent.find('li');

            innerTabs.removeClass('active');
            $(this).addClass('active');
        });
    });
</script> 
@endpush