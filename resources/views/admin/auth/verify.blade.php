@extends('frontend.layouts.master')
@section('title', 'Admin Login')
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/login.css') }}">
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
                                            <p class="text-center">{{ __('Didn\'t receive a code?') }} <a
                                                    href="{{ route('admin.forgot.send_otp') }}"
                                                    data-id="{{ $admin_id }}"
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
