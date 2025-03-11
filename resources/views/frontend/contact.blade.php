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
                    <div class="col-lg-6 col-12 mb-2 mb-lg-0 px-2 px-md-4">
                        <h2 class="mb-2">{{__('Get In Touch With Us')}}</h2>
                        <p class="mb-2 mb-lg-3">
                            {{__('We re here to help! Whether you have questions about your order, medication refills, or need assistance navigating our website, our friendly customer service team is happy to assist you.')}}
                        </p>
                        <img class="mt-2" src="{{ asset('frontend/asset/img/contact.png') }}" alt="Customer Support"
                            class="img-fluid">
                    </div>
                    <!-- Right Section (Form) -->
                    <div class="col-lg-6 col-12 mb-0 mb-lg-3 mb-lg-0 px-2 px-md-4">
                        <form action="{{ route('contact_us.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3 mb-md-3">
                                <label for="name" class="form-label">{{ __('Name') }}<span class="required">*</span></label>
                                <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name"
                                    placeholder="{{__('Enter your name')}}" required>
                            </div>
                            <div class="mb-3 mb-md-3">
                                <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                <input type="tel" class="form-control" value="{{ old('phone') }}" id="phone" name="phone"
                                    placeholder="{{__('Enter your phone number')}}">
                            </div>
                            <div class="mb-3 mb-md-3">
                                <label for="email" class="form-label">{{ __('E-Mail') }}<span class="required">*</span></label>
                                <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email"
                                    placeholder="{{__('Enter your e-mail')}}" required>
                            </div>
                            <div class="mb-3 mb-md-3">
                                <label for="message" class="form-label">{{ __('Message') }}<span class="required">*</span></label>
                                <textarea class="form-control" id="message" value="{{ old('message') }}" name="message" rows="4" placeholder="{{__('Write your message')}}" required></textarea>
                            </div>
                            <div class="btn w-100 p-0">
                                <button type="submit" class="btn btn-send send-button">{{ __('Contact Us') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
