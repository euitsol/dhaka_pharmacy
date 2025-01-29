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
                    {{-- <div class="left-col login_wrap" @if (isset($otp)) style="display: none;" @endif>
                        <div class="form-title">
                            <h1 class="otp_title">{{ __('LOGIN IN WITH OTP') }}</h1>
                            <h1 class="login_title" style="display: none;">{{ __('LOGIN WITH PASSWORD') }}</h1>
                            <h3>{{ __('Follow the instructions to make it easier to register and you will be able to explore inside.') }}
                            </h3>
                        </div>



                        <form class="otp_form" autocomplete="off">
                            @csrf
                            <div class="phn input-box">
                                <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="text" name="phone" placeholder="Phone" class="phone" autocomplete="off"
                                    readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                            @include('alerts.feedback', ['field' => 'phone'])


                            <a href="javascript:void(0)" class="otp_button submit_button">{{ __('SEND OTP') }}</a>
                            <p class="get-otp"><a class="login_switch"
                                    href="javascript:void(0)">{{ __('Login with password?') }}</a>
                            </p>
                            <p class="get-otp">{{ __('Not yet registered? ') }}<a
                                    href="{{ route('use.register') }}">{{ __('Create an account') }}</a>
                            </p>

                        </form>




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
                            <p class="get-otp">{{ __('Not yet registered? ') }}<a
                                    href="{{ route('use.register') }}">{{ __('Create an
                                                                                                                                                                                                                                                                                                                                                                                                                                                account') }}</a>
                            </p>
                        </form>
                        @include('auth.login_with')
                    </div> --}}

                    <div class="verification_wrap left-col">
                        <div class="form-title">
                            <h1 class="otp_title">
                                {{ __('VERIFY YOUR PHONE NUMBER') }}
                            </h1>
                            <h3>{{ __('We have sent a verification code to your phone number') }}</h3>
                        </div>
                        <form action="{{ route('use.otp.verify') }}" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <div class="field-set otp-field text-center">
                                <input name=otp[] type="number" />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                            </div>
                            <p class="get-otp">{{ __("Didn't receive a code? ") }}<a class="send_otp_again"
                                    href="{{ route('use.send_otp.again', $user_id) }}">{{ __('Send Again') }}</a></p>
                            <input type="submit" class="verify-btn submit_button" value="VERIFY">
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
    {{-- <script>
        // $(document).ready(function() {
        //     $('.otp_button').click(function() {
        //         var form = $('.otp_form');
        //         let login_wrap = $('.login_wrap');
        //         let verification_wrap = $('.verification_wrap');
        //         let _url = ("{{ route('use.send_otp') }}");
        //         removeInvalidFeedback();
        //         $.ajax({
        //             type: 'POST',
        //             url: _url,
        //             data: form.serialize(),
        //             success: function(response) {
        //                 if (response.success) {
        //                     toastr.success(response.message);
        //                     removeInvalidFeedback();
        //                     $('[name="phone"]').removeClass('form-control is-invalid');
        //                     login_wrap.hide();
        //                     verification_wrap.show();
        //                     window.history.pushState({
        //                         path: response.url
        //                     }, '', response.url);
        //                 } else {
        //                     toastr.error(response.message);
        //                     let errorHtml =
        //                         '<span class="invalid-feedback d-block mb-3" role="alert">' +
        //                         response.error + '</span>';
        //                     $('[name="phone"]').parent('.input-box').after(errorHtml);
        //                     $('[name="phone"]').addClass('form-control is-invalid');
        //                 }
        //             },
        //             error: function(xhr) {
        //                 if (xhr.status === 422) {
        //                     // Handle validation errors
        //                     var errors = xhr.responseJSON.errors;
        //                     toastr.error('Something is wrong!');
        //                     $.each(errors, function(field, messages) {
        //                         // Display validation errors
        //                         var errorHtml = '';
        //                         $.each(messages, function(index, message) {
        //                             errorHtml +=
        //                                 '<span class="invalid-feedback d-block mb-3" role="alert">' +
        //                                 message + '</span>';
        //                         });
        //                         $('[name="' + field + '"]').parent('.input-box').after(
        //                             errorHtml);
        //                         $('[name="' + field + '"]').addClass(
        //                             'form-control is-invalid');
        //                     });
        //                 } else {
        //                     // Handle other errors
        //                     console.log('An error occurred.');
        //                 }
        //             }
        //         });
        //     });
        // });





        // Phone Validation
        // $(document).ready(function() {
        //     $('.phone').on('input keyup', function() {

        //         let phone = $(this).val();

        //         let digitRegex = /^\d{11}$/;
        //         let errorHtml = '';
        //         let submit_button = $('.submit_button');
        //         submit_button.addClass('disabled');

        //         $(this).parent('.input-box').next('.invalid-feedback').remove();
        //         $(this).removeClass('form-control is-invalid');
        //         // Check if the input is a number
        //         if (!isNaN(phone)) {
        //             if (digitRegex.test(phone)) {
        //                 console.log('Valid');
        //                 submit_button.removeClass('disabled');
        //             } else {
        //                 errorHtml =
        //                     '<span class="invalid-feedback d-block" role="alert">Phone number must be 11 digit</span>';
        //                 $(this).addClass('form-control is-invalid');
        //             }
        //         } else {
        //             errorHtml =
        //                 '<span class="invalid-feedback d-block" role="alert">Invalid phone number</span>';
        //             $(this).addClass('form-control is-invalid');
        //         }
        //         $(this).parent('.input-box').after(errorHtml);

        //     });
        // });
    </script> --}}

    {{-- <script>
        let url = '{{ $url ?? '' }}';
        history.replaceState({}, '', url);
    </script> --}}
@endpush
