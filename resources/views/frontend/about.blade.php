@extends('frontend.layouts.master')
@section('title', 'About Us')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/about.css') }}">
@endpush
@section('content')
    <div class="about-section mt-4">
        <div class="container">
            <div class="about-container">
                <div class="row my-0 my-lg-5 align-items-start align-items-xxl-end mt-4 mt-lg-0 col-gap-md-3 col-gap-0 row-gap-md-0 row-gap-4">
                    <div class="col-12 col-md-6 p-0 order-md-1 order-2">
                        <div class="content pe-0 pe-lg-4">
                            <h5 class="text-white d-inline-block py-2 px-3 mb-2 mb-lg-0">{{ __('WHO WE ARE') }}</h5>
                            <h1 class="mt-0 mt-xl-3 fw-bold">
                                {{ __('Dhaka Pharmacy-') }}<br>{{ __('Bangladesh\'s Largest Online Pharmacy') }}
                            </h1>


                            <p class="my-2 my-xl-4">
                                <strong>{{ __('Welcome to Dhaka Pharmacy, Bangladesh\'s leading online pharmacy!') }}</strong> <br>
                                {{ __('We are dedicated to providing you with convenient access to a wide range of genuine medications and healthcare essentials, all delivered directly to your doorstep.') }}
                            </p>

                            <ul class="feature-list p-0">
                                <li><i class="fa-solid fa-check"></i> {{ __('Great 24/7 customer services.') }}</li>
                                <li><i class="fa-solid fa-check"></i> {{ __('50+ Branches all over Dhaka City.') }}</li>
                                <li><i class="fa-solid fa-check"></i> {{ __('Over 1 Million Products.') }}</li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-center p-0 mt-2 mt-lg-0 order-md-2 order-1">
                        <img src="{{ asset('frontend/asset/img/about.png') }}" alt="Pharmacy Image" class="">
                    </div>
                </div>
            </div>
        </div>
        <!-- Trusted Pharmacy Section -->
        <div class="highlight-section text-left mt-3 mt-lg-0">
            <div class="container">
                <div class="row">
                    <div class="col p-0">
                        <div class="about-container">
                            <h2 class="fw-bold mb-3">{{__('Your trusted and')}} <br> {{__('reliable Pharmacy')}}</h2>
                            <p class="lead">
                                {{ __('Offering affordable healthcare! We believe everyone deserves access to quality medications. Get a wide range of genuine medications and healthcare essentials delivered directly to your doorstep, all at competitive prices.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact section -->
        <div class="contact-section">
            <div class="container">
                <div class="main-contact-section">
                    <div class="about-container">
                        <div class="row align-items-center">
                            <div class="col-xl-4 col-sm-6">
                                <div class="contact-info d-flex align-items-center justify-content-sm-start column-gap-2">
                                    <div class="icon">
                                        <i class="fa-solid fa-phone-volume"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h3>{{__('Call For More Information')}}</h3>
                                        <a class="text-decoration-none" href="tel:+8801901636068">+8801901636068</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-sm-6 px-xxl-1">
                                <div class="information px-0 px-xl-4">
                                    <h2>{{__('Trusted delivery of your essential')}}<br>
                                        {{__('Medications')}}</h2>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12 d-flex d-md-block mt-2 mt-lg-0">
                                <div class="information">
                                    <div class="button text-md-center text-xl-end text-start">
                                        <!-- <button class="btn">Contact Us <i class="fas fa-chevron-right"></i></button> -->
                                        <a class="btn" href="{{ route('contact_us') }}">{{__('Contact Us')}} <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
