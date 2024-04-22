@extends('frontend.layouts.master')
@section('title', 'User Registration')

@push('css')
    <link rel="stylesheet" href="{{asset('user_login/style.css')}}">
@endpush
@section('content')
<section class="log-with-pass">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="left-col login_wrap" @if(isset($otp_verify)) style="display: none;" @endif>
                    <div class="form-title">
                        <h1 class="otp_title">CREATE A NEW ACCOUNT</h1>
                        <h3>Follow the instructions to make it easier to register and you will be able to explore
                            inside.</h3>
                    </div>
                    <form action="{{ route('use.register') }}" method="POST">
                        @csrf
                        <div class="phn input-box">
                            <span class="icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" placeholder="Name">
                        </div>
                        @include('alerts.feedback', ['field' => 'name'])
                        <div class="phn input-box">
                            <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                            <input type="text" name="phone" placeholder="Phone">
                        </div>
                        @include('alerts.feedback', ['field' => 'phone'])
                        <div class="phn input-box password_input">
                            <span class="icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" placeholder="Password" class="password">
                            <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                        </div>
                        @include('alerts.feedback', ['field' => 'password'])
                        <div class="pass input-box password_input">
                            <span class="icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="password">
                        </div>
                        <p class="get-otp">Already have an account? <a class="otp_switch" href="{{route('login')}}">Login</a></p>
                        <input class="login_button" type="submit" value="REGISTER">
                        
                    </form>
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

