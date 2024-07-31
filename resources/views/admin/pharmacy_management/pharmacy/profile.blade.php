@extends('admin.layouts.master', ['pageSlug' => 'pharmacy'])
@section('title', 'Pharmacy Profile')
@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
@endpush
@push('css')
    <style>
        .map {
            height: 300px;
        }
    </style>
@endpush
@section('content')
    <div class="row profile">
        <div class="col-md-8">
            <div class="card h-100 mb-0">
                <div class="card-header px-4">
                    <nav>
                        <div class="nav nav-tabs row" id="nav-tab" role="tablist">
                            <button class="nav-link active col" id="details-tab" data-bs-toggle="tab"
                                data-bs-target="#details" type="button" role="tab" aria-controls="details"
                                aria-selected="true">{{ __('Details') }}</button>
                            <button class="nav-link col" id="kyc-tab" data-bs-toggle="tab" data-bs-target="#kyc"
                                type="button" role="tab" aria-controls="kyc"
                                aria-selected="false">{{ __('KYC') }}</button>
                            <button class="nav-link col" id="order-tab" data-bs-toggle="tab" data-bs-target="#order"
                                type="button" role="tab" aria-controls="order"
                                aria-selected="false">{{ __('Orders') }}</button>
                            <button class="nav-link col" id="earning-tab" data-bs-toggle="tab" data-bs-target="#earning"
                                type="button" role="tab" aria-controls="earning"
                                aria-selected="false">{{ __('Earnings') }}</button>
                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            @include('admin.pharmacy_management.pharmacy.includes.details')
                        </div>
                        <div class="tab-pane fade" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                            @include('admin.pharmacy_management.pharmacy.includes.kyc')
                        </div>
                        <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                            @include('admin.pharmacy_management.pharmacy.includes.order')
                        </div>
                        <div class="tab-pane fade" id="earning" role="tabpanel" aria-labelledby="earning-tab">
                            @include('admin.pharmacy_management.pharmacy.includes.earning')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user mb-0">
                <div class="card-body">
                    <p class="card-text">
                    <div class="author">
                        <img class="avatar" src="{{ auth_storage_url($pharmacy->image, $pharmacy->gender) }}"
                            alt="">
                        <h5 class="title mb-0">{{ $pharmacy->name }}</h5>
                        <p class="description">
                            {{ __($pharmacy->designation ?? 'Pharmaciest') }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description bio my-2 text-justify">
                        {!! $pharmacy->bio !!}
                    </div>
                    <div class="earning_info py-3">
                        <div class="row">
                            <div class="col">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Available Balance') }}</h5>
                                        <h5 class="m-0 amount">
                                            {{ number_format(getEarningEqAmounts($earnings), 2) }}{{ __(' BDT') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total Orders') }}</h5>
                                        <h5 class="m-0 amount">
                                            {{ number_format($ods->count()) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact_info py-3">
                        <ul class="m-0 px-3 list-unstyled">
                            <li>
                                <i class="fa-solid fa-phone-volume mr-2"></i>
                                <span class="title">{{ __('Mobile : ') }}</span>
                                <span class="content">{{ $pharmacy->phone ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-regular fa-envelope mr-2"></i>
                                <span class="title">{{ __('Email : ') }}</span>
                                <span class="content">{{ $pharmacy->email ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                <span class="title">{{ __('Address : ') }}</span>
                                <span class="content">{!! $pharmacy->address ? $pharmacy->address->address : '--' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card card-user mt-3 mb-0">
                <div class="card-header p-0">
                    <div class="map" id="map" data-lat="{{ optional($pharmacy->address)->latitude }}"
                        data-lng="{{ optional($pharmacy->address)->longitude }}"></div>
                </div>
                <div class="card-body contact_info"
                    style="border: 0;
                        border-radius: 0 0 5px 5px;">
                    <ul class="m-0 list-unstyled">
                        <li>
                            <i class="fa-solid fa-mountain-city mr-2"></i>
                            <span class="title">{{ __('City : ') }}</span>
                            <span class="content">{{ $pharmacy->address ? $pharmacy->address->city : '--' }}</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-road mr-2"></i>
                            <span class="title">{{ __('Street Name : ') }}</span>
                            <span
                                class="content">{{ $pharmacy->address ? $pharmacy->address->street_address : '--' }}</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-door-open mr-2"></i>
                            <span class="title">{{ __('Apartment Name : ') }}</span>
                            <span class="content">{{ $pharmacy->address ? $pharmacy->address->apartment : '--' }}</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-stairs mr-2"></i>
                            <span class="title">{{ __('Floor : ') }}</span>
                            <span class="content">{{ $pharmacy->address ? $pharmacy->address->floor : '--' }}</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-hand-point-right mr-2"></i>
                            <span class="title">{{ __('Delivery Man Instruction : ') }}</span>
                            <span class="content">{!! $pharmacy->address ? $pharmacy->address->delivery_instruction : '--' !!}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_link')
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
    <script src="{{ asset('pharmacy/js/mapbox.js') }}"></script>
@endpush
