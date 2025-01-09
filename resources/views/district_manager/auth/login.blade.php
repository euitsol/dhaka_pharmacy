@extends('frontend.layouts.master')
@section('title', 'District Manager Login')
@push('css')
    <link rel="stylesheet" href="{{ asset('dm/css/login.css') }}">
@endpush
@section('content')
    <section class="district-section py-5">
        <div class="container">
            <div class="row">
                <div class="district-container">
                    <div class="row row-gap-4">
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="image-col pe-lg-4 pe-0 ">
                                <img src="{{ asset('dm/image/distric.png') }}" alt="dsitrict login">
                            </div>
                        </div>
                        <div class="col-lg-7 col-12">
                            <div class="form">
                                <h2 class="text-center mb-3">{{ __('District Manager') }}</h2>
                                <p class="text-center mb-4">{{ __('Login to access your account') }}</p>
                                <form method="POST" action="{{ route('district_manager.login') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                            <input type="text" id="number" name="phone" class="form-control"
                                                placeholder="Enter your Phone Number" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="mb-4 form-check d-flex justify-content-between">
                                        <div>
                                            <input type="checkbox" id="rememberMe" class="form-check-input">
                                            <label for="rememberMe" class="form-check-label">{{ __('Remember Me') }}</label>
                                        </div>
                                        <a href="#" class="text-decoration-none">{{ __('Forgot Password?') }}</a>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 login-button border-0">{{ __('LOGIN') }}</button>
                                    {{-- <div class="mt-3 text-center">
                                        <p>{{ __('Not yet registered?') }} <a href="#"
                                                class="text-decoration-none">{{ __('Create an account') }}</a></p>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
