@extends('frontend.layouts.master')
@section('title', 'Request Data Deletion')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/contact.css') }}">
@endpush
@section('content')
    <section class="contact-section py-3 py-lg-5">
        <div class="container p-0">
            <div class="contact-container">
                <div class="row row-gap-3">
                    <!-- Left Section (Image + Text) -->
                    <div class="col-lg-6 col-12 mb-2 mb-lg-0 px-2 px-md-4">
                        <h2 class="mb-2">Request Data Deletion</h2>
                        <p class="mb-2 mb-lg-3">
                            We respect your privacy rights. If you wish to have your personal data removed from our system,
                            please fill out this form. Our team will process your request in accordance with applicable
                            data protection laws.
                        </p>
                        <img class="mt-2" src="{{ asset('frontend/asset/img/contact.png') }}" alt="Data Privacy"
                            class="img-fluid">
                    </div>
                    <!-- Right Section (Form) -->
                    <div class="col-lg-6 col-12 mb-0 mb-lg-3 mb-lg-0 px-2 px-md-4">
                        <form action="{{ route('data_deletion.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3 mb-md-3">
                                <label for="name" class="form-label">{{ __('Name') }}<span class="required">*</span></label>
                                <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3 mb-md-3">
                                <label for="phone" class="form-label">{{ __('Phone') }}<span class="required">*</span></label>
                                <input type="tel" class="form-control" value="{{ old('phone') }}" id="phone" name="phone"
                                    placeholder="Enter your phone number" required>
                            </div>
                            <div class="mb-3 mb-md-3">
                                <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                                <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email"
                                    placeholder="Enter your e-mail">
                            </div>
                            <div class="mb-3 mb-md-3">
                                <label for="reason" class="form-label">{{ __('Reason for Deletion') }}</label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="Please explain why you want your data deleted">{{ old('reason') }}</textarea>
                            </div>
                            <div class="btn w-100 p-0">
                                <button type="submit" class="btn btn-send send-button">{{ __('SUBMIT REQUEST') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
