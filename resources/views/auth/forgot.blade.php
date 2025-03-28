@extends('frontend.layouts.master')
@section('title', 'User Forgot Password')

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
                            <h1 class="otp_title">{{ __('RESET YOUR PASSWORD') }}</h1>
                            <h3>{{ __('Enter your registered phone number to receive an OTP for resetting your password.') }}
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('user.forgot.password') }}" autocomplete="off">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{__('Phone')}}"
                                    class="phone" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])

                            <input class="forgot_button submit_button" type="submit" value="{{__('SEND OTP')}}">
                            <p class="get-otp">{{ __('Already have an account? ') }}<a class="otp_switch"
                                    href="{{ route('login') }}">{{ __('LOG IN') }}</a></p>
                        </form>
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
    <script>
        // Phone Validation
        $(document).ready(function() {
            $('.phone').on('input keyup', function() {

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
                        errorHtml =
                            '<span class="invalid-feedback d-block" role="alert">Phone number must be 11 digit</span>';
                        $(this).addClass('form-control is-invalid');
                    }
                } else {
                    errorHtml =
                        '<span class="invalid-feedback d-block" role="alert">Invalid phone number</span>';
                    $(this).addClass('form-control is-invalid');
                }
                $(this).parent('.input-box').after(errorHtml);

            });
        });
    </script>
@endpush
