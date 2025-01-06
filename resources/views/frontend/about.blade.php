@extends('frontend.layouts.master')
@section('title', 'About Us')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/about.css') }}">
@endpush
@section('content')
    <div class="about-section my-5">
        <div class="container">
            <div class="about-container">
                <div class="row my-5 align-items-end">
                    <div class="col-lg-6 col-12">
                        <div class="content pe-4">
                            <h5 class="text-white d-inline-block py-2 px-3">WHO WE ARE</h5>
                            <h1 class="mt-3 fw-bold">Dhaka Pharmacy-<br>Bangladesh's Largest Online Pharmacy</h1>
                            <p class="my-4"> <strong>Welcome to Dhaka Pharmacy, Bangladesh’s leading online
                                    pharmacy!</strong> <br>We are dedicated to providing you with convenient access
                                to a wide range of genuine medications and healthcare essentials, all delivered
                                directly to your doorstep.</p>
                            <ul class="feature-list p-0">
                                <li><i class="fa-solid fa-check"></i> Great 24/7 customer services.</li>
                                <li><i class="fa-solid fa-check"></i> 600+ Dedicated Riders.</li>
                                <li><i class="fa-solid fa-check"></i> 50+ Branches all over the Dhaka City.</li>
                                <li><i class="fa-solid fa-check"></i> Over 1 Million Products.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 text-center">
                        <img src="{{ asset('frontend/asset/img/about.png') }}" alt="Pharmacy Image" class="">
                    </div>
                </div>
            </div>
        </div>
        <!-- Trusted Pharmacy Section -->
        <div class="highlight-section text-left">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="about-container">
                            <h2 class="fw-bold mb-3">Your trusted and <br> reliable Pharmacy</h2>
                            <p class="lead ">
                                Offering affordable healthcare! We believe everyone deserves access to quality medications.
                                Get a wide range of genuine medications and healthcare essentials delivered directly to your
                                doorstep, all at competitive prices.
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
                            <div class="col-xl-4 col-md-6">
                                <div class="contact-info d-flex align-items-center justify-content-sm-start column-gap-2">
                                    <div class="icon">
                                        <i class="fa-solid fa-phone-volume"></i>
                                    </div>
                                    <div class="contact-info-content">
                                        <h3>Call For More Information</h3>
                                        <a class="text-decoration-none" href="tel:+8801506-0000">+8801506-0000</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-6 px-xxl-5">
                                <div class="information px-xl-4">
                                    <h2>Trusted delivery of your essential <br>
                                        medications</h2>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12 ">
                                <div class="information">
                                    <div class="button text-md-center text-xl-end text-start">
                                        <button class="btn ">Contact Us <i class="fas fa-chevron-right"></i></button>
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
