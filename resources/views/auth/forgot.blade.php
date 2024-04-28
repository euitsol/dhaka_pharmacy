@extends('frontend.layouts.master')
@section('title', 'User Forgot Password')

@push('css')
    <link rel="stylesheet" href="{{asset('user/user_login/style.css')}}">
@endpush
@section('content')
<section class="log-with-pass">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="left-col login_wrap">
                    <div class="form-title">
                        <h1 class="otp_title">FORGOT PASSWORD</h1>
                        <h3>Follow the instructions to make it easier to reset password and you will be able to explore
                            inside.</h3>
                    </div>
                    <form method="POST" action="{{route('user.forgot.password')}}">
                        @csrf
                        <div class="phn input-box">
                            <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                            <input type="text" name="phone" placeholder="Phone" class="phone">
                        </div>
                        @include('alerts.feedback', ['field' => 'phone'])

                        <input class="forgot_button submit_button" type="submit" value="SEND OTP">
                        <p class="get-otp">Login With Phone? <a class="otp_switch" href="{{route('login')}}">GET OTP</a></p>
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
    <script src="{{asset('user/user_login/app.js')}}"></script>
    <script>
        // Phone Validation
        $(document).ready(function(){
            $('.phone').on('input keyup', function(){

                let phone = $(this).val();

                let digitRegex = /^\d{11}$/;
                let errorHtml = '';
                let submit_button = $('.submit_button');
                submit_button.addClass('disabled');
                
                $(this).parent('.input-box').next('.invalid-feedback').remove();
                $(this).removeClass('form-control is-invalid');
                // Check if the input is a number
                if (!isNaN(phone)) {
                    if (digitRegex.test(phone)) {
                        console.log('Valid');
                        submit_button.removeClass('disabled');
                    } else {
                        errorHtml = '<span class="invalid-feedback d-block" role="alert">Phone number must be 11 digit</span>';
                        $(this).addClass('form-control is-invalid');
                    }
                } else {
                    errorHtml = '<span class="invalid-feedback d-block" role="alert">Invalid phone number</span>';
                    $(this).addClass('form-control is-invalid');
                }
                $(this).parent('.input-box').after(errorHtml);
                
            });
        });
    </script>
@endpush

