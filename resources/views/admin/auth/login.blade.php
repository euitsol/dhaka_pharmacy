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
                            <div class="form">
                                <h2 class="text-center mb-3">{{ __('Admin Login') }}</h2>
                                <p class="text-center mb-4">{{ __('Login to access your account') }}</p>
                                <form method="POST" action="{{ route('admin.login') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                            <input type="email" value="{{ old('email') }}" id="email" name="email"
                                                class="form-control" placeholder="Enter your email" required>
                                        </div>
                                        @include('alerts.feedback', ['field' => 'email'])
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Enter your password" required>
                                        </div>
                                        @include('alerts.feedback', ['field' => 'password'])
                                    </div>
                                    <div class="mb-4 form-check d-flex justify-content-between">
                                        <div>
                                            <input type="checkbox" id="rememberMe" name="remember"
                                                {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                                            <label for="rememberMe" class="form-check-label">{{ __('Remember Me') }}</label>
                                        </div>
                                        <a href="{{ route('admin.forgot') }}"
                                            class="text-decoration-none">{{ __('Forgot Password?') }}</a>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 login-button border-0">{{ __('LOGIN') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
