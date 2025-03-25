@extends('frontend.layouts.master')
@section('title', 'Frequently Asked Question')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/faq.css') }}">
@endpush
@section('content')
    <section class="faq-section py-3 py-lg-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-center page-title">{{__('Frequently Asked Question') }}</h1>
                    <ul class="nav nav-pills py-3 py-lg-4 mb-3 mb-lg-5 justify-content-start column-gap-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-general-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-general" type="button" role="tab" aria-controls="pills-general"
                                aria-selected="true">{{ __('General') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-ordering-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-ordering" type="button" role="tab"
                                aria-controls="pills-ordering" aria-selected="false">{{ __('Login') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                            aria-labelledby="pills-general-tab" tabindex="0">
                            @include('frontend.faq.includes.general')
                        </div>
                        <div class="tab-pane fade" id="pills-ordering" role="tabpanel" aria-labelledby="pills-ordering-tab"
                            tabindex="0">
                            @include('frontend.faq.includes.login')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
