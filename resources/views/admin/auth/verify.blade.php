@extends('frontend.layouts.master')
@section('title', 'Admin Login')
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/login.css') }}">
    <style>
        /* For most browsers */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* For Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
@section('content')
    <section class="adminlogin-section py-5">
        <div class="container">
            <div class="row">
                <div class="admin-container">
                    <div class="row row-gap-4">
                        <div class="col-md-4">
                            <div class="image-col d-flex align-items-center justify-content-between">
                                <img src="{{ asset('admin/image/adminlogin.png') }}" alt="adminloginimage">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form ps-md-4 ps-0 h-100">
                                <div class="form-content d-flex justify-content-center align-items-center h-100">
                                    <div class="w-100">
                                        <form action="{{ route('admin.otp.verify', $admin_id) }}" method="POST">
                                            @csrf
                                            <h2 class="text-center mb-2">{{ __('Enter OTP') }}</h2>
                                            <div class="otp-container d-flex justify-content-center column-gap-2">
                                                <input name=otp[] class="otp-input" type="number" />
                                                <input name=otp[] class="otp-input" type="number" disabled />
                                                <input name=otp[] class="otp-input" type="number" disabled />
                                                <input name=otp[] class="otp-input" type="number" disabled />
                                                <input name=otp[] class="otp-input" type="number" disabled />
                                                <input name=otp[] class="otp-input" type="number" disabled />
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 login-button"
                                                id="verifyOTP">{{ __('VERIFY OTP') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            const inputs = $(".otp-container > input");
            const button = $("#verifyOTP");

            inputs.eq(0).focus();
            button.prop("disabled", true);

            inputs.eq(0).on("paste", function(event) {
                event.preventDefault();

                const pastedValue = (
                    event.originalEvent.clipboardData || window.clipboardData
                ).getData("text");
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
            //  OTP Type
            inputs.each(function(index1) {
                $(this).on("keyup", function(e) {
                    const currentInput = $(this);
                    const nextInput = currentInput.next();
                    const prevInput = currentInput.prev();

                    if (currentInput.val().length > 1) {
                        currentInput.val("");
                        return;
                    }

                    if (
                        nextInput &&
                        nextInput.attr("disabled") &&
                        currentInput.val() !== ""
                    ) {
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
                    if (
                        !inputs.eq(inputsNo - 1).prop("disabled") &&
                        inputs.eq(inputsNo - 1).val() !== ""
                    ) {
                        button.prop("disabled", false);
                        return;
                    }
                });
            });
        });
    </script>
@endpush
