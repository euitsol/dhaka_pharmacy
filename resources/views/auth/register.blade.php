@extends('frontend.layouts.master')
@section('title', 'User Registration')

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
                            <h1 class="otp_title">{{ __('CREATE A NEW ACCOUNT') }}</h1>
                            <h3>{{ __('Follow the instructions to make it easier to register and you will be able to explore inside.') }}
                            </h3>
                        </div>
                        <form action="{{ route('use.register') }}" method="POST">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="name" placeholder="Name" class="name">
                            </div>
                            @include('alerts.feedback', ['field' => 'name'])
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" placeholder="Phone" class="phone">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])
                            <div class="phn input-box password_input">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" placeholder="Password" class="password pass-n">
                                <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                            </div>
                            @include('alerts.feedback', ['field' => 'password'])
                            <div class="pass input-box password_input">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                    class="password pass-c">
                            </div>
                            <p class="get-otp">{{ __('Already have an account? ') }}<a class="otp_switch"
                                    href="{{ route('login') }}">{{ __('Login') }}</a></p>
                            <input class="register_button submit_button" type="submit" value="REGISTER">
                            @include('auth.login_with')
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
    <script src="{{ asset('user/user_login/app.js') }}"></script>
    <script>
        $('.name').on('input', function() {
            nameValid();
        });
        $('.phone').parent('.input-box').next('.invalid-feedback').next('.invalid-feedback').remove();
        $(document).ready(function() {
            $('.phone').on('input keyup', function() {

                nameValid();
                let phone = $(this).val();

                let digitRegex = /^\d{11}$/;
                let errorHtml = '';
                $(this).parent('.input-box').next('.invalid-feedback').remove();
                $(this).removeClass('form-control is-invalid');
                // Check if the input is a number
                if (!isNaN(phone)) {
                    if (digitRegex.test(phone)) {
                        let _url = ("{{ route('use.register.phone.validation', ['_phone']) }}");
                        let __url = _url.replace('_phone', phone);
                        $.ajax({
                            url: __url,
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('.phone').parent('.input-box').next('.invalid-feedback')
                                    .remove();
                                $('.phone').removeClass('form-control is-invalid');
                                if (data.success) {
                                    errorHtml =
                                        `<span class="invalid-feedback d-block" role="alert">Number already has an account.</span>`;
                                    $('.phone').parent('.input-box').after(errorHtml);
                                    $('.phone').addClass('form-control is-invalid');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching member data:', error);
                                toastr.error('Something is wrong!');
                            }
                        });
                    } else {
                        errorHtml =
                            '<span class="invalid-feedback d-block" role="alert">Phone number must be 11 digit</span>';
                    }
                } else {
                    errorHtml =
                        '<span class="invalid-feedback d-block" role="alert">Invalid phone number</span>';
                }
                $(this).parent('.input-box').after(errorHtml);
                $(this).addClass('form-control is-invalid');
            });
        });
    </script>
@endpush
