@extends('frontend.layouts.master')
@section('title', 'Rider OTP Verification')
@push('css')
    <link rel="stylesheet" href="{{ asset('rider/css/login.css') }}">
@endpush
@section('content')
    <section class="rider-section py-5">
        <div class="container">
            <div class="row">
                <div class="rider-container">
                    <div class="row row-gap-4">
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="image-col">
                                <img src="{{ asset('rider/img/rider.png') }}" alt="rider login">
                            </div>
                        </div>
                        <div class="col-lg-7 col-12">
                            <div class="form h-100">
                                <div class="form-content d-flex justify-content-center align-items-center h-100">
                                    <div class="w-100">
                                        <form action="{{ route('rider.otp.verify', $rider_id) }}" method="POST">
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
                                                    href="{{ route('rider.forgot.send_otp') }}"
                                                    data-id="{{ $rider_id }}"
                                                    id="send_otp_again">{{ __('Sent Again') }}</a>
                                            </p>
                                            <button type="submit" class="btn btn-primary w-100 login-button"
                                                id="verifyOTP">{{ __('Verify OTP') }}</button>
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
