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
                <div class="left-col login_wrap" @if(isset($otp_verify)) style="display: none;" @endif>
                    <div class="form-title">
                        <h1 class="otp_title">LOGIN IN WITH OTP</h1>
                        <h1 class="login_title" style="display: none;">LOGIN WITH PASSWORD</h1>
                        <h3>Follow the instructions to make it easier to register and you will be able to explore
                            inside.</h3>
                    </div>


                    {{-- Sent OTP --}}
                    <form class="otp_form">
                        @csrf
                        <div class="phn input-box">
                            <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                            <input type="text" name="phone" placeholder="Phone" class="phone">
                        </div>
                        @include('alerts.feedback', ['field' => 'phone'])

                        <p class="get-otp">Login With Password? <a class="login_switch" href="javascript:void(0)">Login</a></p>
                        <a href="javascript:void(0)" class="otp_button">SEND OTP</a>
                        <p class="get-otp">Not yet registered? <a href="{{route('use.register')}}">Create an account</a></p> 
                       
                    </form>

                    {{-- Sent OTP --}}



                    {{-- login With Password --}}
                    <form action="{{ route('login') }}" method="POST" class="login_form" style="display: none;">
                        @csrf
                        <div class="phn input-box">
                            <span class="icon"><i class="fa-solid fa-phone-volume"></i></span>
                            <input type="text" name="phone" placeholder="Phone" class="phone">
                        </div>
                        @include('alerts.feedback', ['field' => 'phone'])
                        <div class="pass input-box password_input">
                            <span class="icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" placeholder="Password" class="password">
                            <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                        </div>
                        @include('alerts.feedback', ['field' => 'password'])

                        <p class="rfp text-end mb-2"><a class="forgot-password" href="javascript:void(0)">Lost your password?</a></p>

                        <p class="get-otp">Login With Phone? <a class="otp_switch" href="javascript:void(0)">GET OTP</a></p>
                        <input class="login_button" type="submit" value="LOGIN">
                        <p class="get-otp">Not yet registered? <a href="{{route('use.register')}}">Create an account</a></p> 
                    </form>
                    {{-- login With Password --}}
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




                <div class="verification_wrap left-col" @if(isset($otp_verify)) style="display: block;"  @else style="display: none;" @endif>
                    <div class="form-title">
                        <h1 class="otp_title">VERIFICATION CODE</h1>
                        <h3>We have sent a verification code to your mobile number</h3>
                    </div>
                    <form action="{{ route('use.otp.verify') }}" method="POST">
                        @csrf
                        <input type="hidden" class="uid" name="uid" value="{{$uid ?? ''}}">
                        <div class="field-set otp-field text-center">
                            <input name=otp[] type="number" />
                            <input name=otp[] type="number" disabled />
                            <input name=otp[] type="number" disabled />
                            <input name=otp[] type="number" disabled />
                            <input name=otp[] type="number" disabled />
                            <input name=otp[] type="number" disabled />
                        </div>
                        <p class="get-otp">Didn't receive a code? <a class="send_otp_again" data-id="{{isset($uid) ? $uid : ''}}" href="javascript:void(0)">SEND AGAIN</a></p>
                        <input type="submit" class=" verify-btn" value="VERIFY">
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
    <script>
        $(document).ready(function() {
            const inputs = $(".otp-field > input");
            const button = $(".verify-btn");

            inputs.eq(0).focus();
            button.prop("disabled", true);

            inputs.eq(0).on("paste", function(event) {
                event.preventDefault();

                const pastedValue = (event.originalEvent.clipboardData || window.clipboardData).getData(
                    "text");
                const otpLength = inputs.length;

                for (let i = 0; i < otpLength; i++) {
                    if (i < pastedValue.length) {
                        inputs.eq(i).val(pastedValue[i]);
                        inputs.eq(i).removeAttr("disabled");
                        inputs.eq(i).focus();
                    } else {
                        inputs.eq(i).val(""); // Clear any remaining inputs
                        inputs.eq(i).focus();
                    }
                }
            });

            inputs.each(function(index1) {
                $(this).on("keyup", function(e) {
                    const currentInput = $(this);
                    const nextInput = currentInput.next();
                    const prevInput = currentInput.prev();

                    if (currentInput.val().length > 1) {
                        currentInput.val("");
                        return;
                    }

                    if (nextInput && nextInput.attr("disabled") && currentInput.val() !== "") {
                        nextInput.removeAttr("disabled");
                        nextInput.focus();
                    }

                    if (e.key === "Backspace") {
                        inputs.each(function(index2) {
                            if (index1 <= index2 && prevInput) {
                                $(this).attr("disabled", true);
                                $(this).val("");
                                prevInput.focus();
                            }
                        });
                    }

                    button.prop("disabled", true);

                    const inputsNo = inputs.length;
                    if (!inputs.eq(inputsNo - 1).prop("disabled") && inputs.eq(inputsNo - 1)
                        .val() !== "") {
                        button.prop("disabled",false);
                        return;
                    }
                });
            });
        });



        $(document).ready(function () {
            $('.otp_button').click(function () {
                var form = $('.otp_form');
                let login_wrap = $('.login_wrap');
                let verification_wrap = $('.verification_wrap');
                let send_otp_again = $('.send_otp_again');
                let uid = $('.uid');
                let _url = ("{{ route('use.send_otp') }}");
                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: form.serialize(),
                    success: function (response) {
                        if(response.success){
                            toastr.success(response.message);
                            form.find('.invalid-feedback').addClass('d-none');
                            login_wrap.hide();
                            verification_wrap.show();
                            send_otp_again.attr('data-id',response.user.id);
                            uid.val(response.user.id);
                            window.history.pushState({path: response.url}, '', response.url);
                        }else{
                            toastr.error(response.message);
                            let errorHtml = '<span class="invalid-feedback d-block mb-3" role="alert">' + response.error + '</span>';
                            $('[name="phone"]').parent('.phn').addClass('mb-0');
                            $('[name="phone"]').parent('.phn').after(errorHtml);
                        } 
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Handle validation errors
                            var errors = xhr.responseJSON.errors;
                            toastr.error('Something is wrong!');
                            $.each(errors, function (field, messages) {
                                // Display validation errors
                                var errorHtml = '';
                                $.each(messages, function (index, message) {
                                    errorHtml += '<span class="invalid-feedback d-block mb-3" role="alert">' + message + '</span>';
                                });
                                $('[name="' + field + '"]').parent('.phn').addClass('mb-0');
                                $('[name="' + field + '"]').parent('.phn').after(errorHtml);
                            });
                        } else {
                            // Handle other errors
                            console.log('An error occurred.');
                        }
                    }
                });
            });
        });

        $(document).ready(function () {
            $('.send_otp_again').click(function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let _url = ("{{ route('use.send_otp.again', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    url: __url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        toastr.success(data.message);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching member data:', error);
                        toastr.error('Something is wrong!');
                    }
                });
            });
        });



        // Phone Validation
        $(document).ready(function(){
            $('.phone').on('input keyup', function(){

                let phone = $(this).val();

                let digitRegex = /^\d{11}$/;
                let errorHtml = '';
                
                $(this).parent('.phn').next('.invalid-feedback').remove();
                // Check if the input is a number
                if (!isNaN(phone)) {
                    if (digitRegex.test(phone)) {
                        console.log('Valid');
                    } else {
                        errorHtml = '<span class="invalid-feedback d-block" role="alert">Phone number must be 11 digit</span>';
                    }
                } else {
                    errorHtml = '<span class="invalid-feedback d-block" role="alert">Invalid phone number</span>';
                }
                $(this).parent('.phn').after(errorHtml);
            });
        });
    </script>

    <script>
        let url = '{{ $url ?? '' }}';
         history.replaceState({}, '', url);
    </script>
@endpush

