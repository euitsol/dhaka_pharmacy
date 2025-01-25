@extends('frontend.layouts.master')
@section('title', 'Local Area Manager OTP Verification')
@push('css')
    <link rel="stylesheet" href="{{ asset('lam/css/login.css') }}">
@endpush
@section('content')
    <section class="lam-section py-5">
        <div class="container">
            <div class="row">
                <div class="lam-container">
                    <div class="row row-gap-4">
                        <div class="col-md-5 ">
                            <div class="image-col pe-md-4 pe-0">
                                <img src="{{ asset('dm/image/distric.png') }}" alt="dsitrict login">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form ps-md-4 ps-0 h-100">
                                <div class="form-content d-flex justify-content-center align-items-center h-100">
                                    <div class="w-100">
                                        <form action="{{ route('local_area_manager.otp.verify', $lam_id) }}" method="POST">
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
                                            <p class="text-center">{{ __('Didn\'t receive a code?') }} <a
                                                    href="{{ route('local_area_manager.forgot.send_otp') }}"
                                                    data-id="{{ $lam_id }}"
                                                    id="send_otp_again">{{ __('Sent Again') }}</a>
                                            </p>
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
    <script src="{{ asset('frontend/asset/js/login.js') }}"></script>
@endpush
