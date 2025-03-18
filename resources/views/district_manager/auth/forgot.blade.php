@extends('frontend.layouts.master')
@section('title', 'District Manager Forgot Password')
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
                            <div class="image-col pe-md-4 pe-0">
                                <img src="{{ asset('dm/image/distric.png') }}" alt="dsitrict login">
                            </div>
                        </div>
                        <div class="col-lg-7 col-12">
                            <div class="form d-flex align-items-center justify-content-center h-100">
                                <div class="form-content w-100">
                                    <h2 class="text-center mb-4">{{ __('Forgot Your Password?') }}</h2>
                                    <p class="mb-4 text-center">
                                        {{ __('Please enter the account phone for which you want to reset the password.') }}
                                    </p>
                                    <form action="{{ route('district_manager.forgot.send_otp') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                                <input type="text" name="phone" value="{{ old('phone') }}"
                                                    id="number" class="form-control"
                                                    placeholder="{{ __('Enter your phone number') }}" required>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'phone'])
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
