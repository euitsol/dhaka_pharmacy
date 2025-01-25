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
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="image-col d-flex align-items-center justify-content-between">
                                <img src="{{ asset('admin/image/adminlogin.png') }}" alt="adminloginimage">
                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="form ps-md-4 d-flex align-items-center justify-content-center h-100">
                                <div class="form-content w-100">
                                    <h2 class="text-center mb-0">{{ __('Forgot Your Password?') }}</h2>
                                    <p class="mb-4 text-center">
                                        {{ __('Please enter the account email for which you want to reset the password.') }}
                                    </p>
                                    <form action="{{ route('admin.forgot.send_otp') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                                <input type="email" id="email" value="{{ old('email') }}"
                                                    name="email" class="form-control" placeholder="Enter your email"
                                                    required>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary w-100 login-button">{{ __('SEND OTP') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
