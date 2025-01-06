@extends('frontend.layouts.master')
@section('title', 'Frequently Asked Question')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/faq.css') }}">
@endpush
@section('content')
    <section class="faq-section py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-center page-title">{{ __('Frequently Asked Question') }}</h1>
                    <ul class="nav nav-pills mb-3 py-4 mb-5" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-general-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-general" type="button" role="tab" aria-controls="pills-general"
                                aria-selected="true">{{ __('General') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-ordering-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-ordering" type="button" role="tab"
                                aria-controls="pills-ordering" aria-selected="false">{{ __('Ordering') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-payments-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-payments" type="button" role="tab"
                                aria-controls="pills-payments" aria-selected="false">{{ __('Payments') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-prescriptions-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-prescriptions" type="button" role="tab"
                                aria-controls="pills-prescriptions" aria-selected="false">{{ __('Prescriptions') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-medications-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-medications" type="button" role="tab"
                                aria-controls="pills-medications" aria-selected="false">{{ __('Medications') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-policy-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-policy" type="button" role="tab" aria-controls="pills-policy"
                                aria-selected="false"> {{ __('Policy and Legal') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-shipping-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-shipping" type="button" role="tab"
                                aria-controls="pills-shipping" aria-selected="false">
                                {{ __('Shipping and Delivery') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                            aria-labelledby="pills-general-tab" tabindex="0">
                            @include('frontend.faq.includes.general')
                        </div>
                        <div class="tab-pane fade" id="pills-ordering" role="tabpanel" aria-labelledby="pills-ordering-tab"
                            tabindex="0">
                            @include('frontend.faq.includes.ordering')
                        </div>
                        <div class="tab-pane fade" id="pills-payments" role="tabpanel" aria-labelledby="pills-payments-tab"
                            tabindex="0">
                            @include('frontend.faq.includes.payment')
                        </div>
                        <div class="tab-pane fade" id="pills-prescriptions" role="tabpanel"
                            aria-labelledby="pills-prescriptions-tab" tabindex="0">
                            @include('frontend.faq.includes.prescription')
                        </div>
                        <div class="tab-pane fade" id="pills-medications" role="tabpanel"
                            aria-labelledby="pills-medications-tab" tabindex="0">
                            @include('frontend.faq.includes.medication')
                        </div>
                        <div class="tab-pane fade" id="pills-policy" role="tabpanel" aria-labelledby="pills-policy-tab"
                            tabindex="0">
                            @include('frontend.faq.includes.policy_and_legal')
                        </div>
                        <div class="tab-pane fade" id="pills-shipping" role="tabpanel"
                            aria-labelledby="pills-shipping-tab" tabindex="0">
                            @include('frontend.faq.includes.shipping_and_delivery')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
