@extends('frontend.layouts.master')
@section('title', 'Contact Us')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/contact.css') }}">
@endpush
@section('content')
    <section class="contact-section py-3 py-lg-5">
        <div class="container p-0">
            <div class="contact-container">
                <div class="row row-gap-3">
                    <!-- Left Section (Image + Text) -->
                    <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                        <h2 class="mb-4 text-center">Get In Touch With Us</h2>
                        <p class="mb-lg-4">
                            We're here to help! Whether you have questions about your order,
                            medication refills, or need assistance navigating our website, our
                            friendly customer service team is happy to assist you.
                        </p>
                        <img class="mt-4" src="{{ asset('frontend/asset/img/contact.png') }}" alt="Customer Support"
                            class="img-fluid">
                    </div>
                    <!-- Right Section (Form) -->
                    <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                        <form action="">
                            <div class="mb-4">
                                <label for="name" class="form-label">Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    placeholder="Enter your phone number">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">E-Mail<span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your e-mail" required>
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label">Message<span class="required">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message" required></textarea>
                            </div>
                            <div class="btn w-100">
                                <button type="submit" class="btn btn-send send-button">SEND</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection