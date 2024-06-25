@extends('user.layouts.master', ['pageSlug' => 'dashboard'])

@section('title', 'Dashboard')

@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="col-left d-flex flex-column">
                    <div class="single-box current-order">
                        <div class="processing d-flex align-items-center justify-content-between">
                            <div class="title">
                                <h3>{{ __('Processing') }}</h3>
                                {{-- <h4>{{ __('Est. Delivery 01 apr 23') }}</h4> --}}
                            </div>
                            <div class="btn">
                                <a
                                    href="{{ route('u.order.list', ['status' => 'current-orders']) }}">{{ __('Details') }}</a>
                            </div>
                        </div>
                        <div class="progress-box">
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar w-25"></div>
                            </div>
                        </div>
                        <div class="title">
                            <h2>{{ __('Current Orders') }}</h2>
                        </div>
                    </div>
                    <a href="{{ route('u.order.list', ['status' => 'previous-orders']) }}"
                        style="text-decoration: none; color:#212529;">
                        <div class="single-box previous-order">
                            <div class="count">
                                <span>{{ $total_previous_orders }}</span>
                            </div>
                            <div class="title">
                                <h2>{{ __('Previous Orders') }}</h2>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('u.order.list', ['status' => 'cancel-orders']) }}"
                        style="text-decoration: none; color:#212529;">
                        <div class="single-box cancel-order">
                            <div class="count">
                                <span>{{ $total_cancel_orders }}</span>
                            </div>
                            <div class="title">
                                <h2>{{ __('Cancel Orders') }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="col-mid">
                    <div class="tips">
                        <h2>{{ __('Our Latest Offers') }}</h2>
                        <div class="single-tips d-flex align-items-center justify-content-between">
                            <img src="{{ asset('user/asset/img/tips-img.png') }}" alt="">
                            <p>Helps you <span>track if you have missed any medication and aboid taking them too
                                    many times</span> accidentally.</p>
                            <h2>Chek of a <br>
                                <span>Calender</span>
                            </h2>
                        </div>
                        <div class="single-tips d-flex align-items-center justify-content-between">
                            <img src="{{ asset('user/asset/img/tips-img.png') }}" alt="">
                            <p>Helps you <span>track if you have missed any medication and aboid taking them too
                                    many times</span> accidentally.</p>
                            <h2>Chek of a <br>
                                <span>Calender</span>
                            </h2>
                        </div>
                    </div>
                    <div class="order-cart-wish d-flex justify-content-center">
                        <a href="{{ route('u.order.list') }}">
                            <div class="single d-flex align-items-center justify-content-center">
                                <div class="content text-center">
                                    <img src="{{ asset('user/asset/img/my-order.png') }}" alt="">
                                    <h2>{{ __('My Orders') }}</h2>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="single  d-flex align-items-center justify-content-center">
                                <div class="content text-center">
                                    <img src="{{ asset('user/asset/img/my-cart.png') }}" alt="">
                                    <h2>{{ __('My Cart') }}</h2>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('u.wishlist.list') }}">
                            <div class="single  d-flex align-items-center justify-content-center">
                                <div class="content text-center">
                                    <img src="{{ asset('user/asset/img/wishtlist2.png') }}" alt="">
                                    <h2>{{ __('Wishlists') }}</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="medicine-slider">
                        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <h3><span>Napa Extra</span>(500 mg+65 mg)</h3>
                                    <p><span>Efficacy:</span> It might be more effective in treating the targeted
                                        condition or symptom compared to other similar medications.</p>
                                </div>
                                <div class="carousel-item active">
                                    <h3><span>Napa Extra</span>(500 mg+65 mg)</h3>
                                    <p><span>Efficacy:</span> It might be more effective in treating the targeted
                                        condition or symptom compared to other similar medications.</p>
                                </div>
                                <div class="carousel-item active">
                                    <h3><span>Napa Extra</span>(500 mg+65 mg)</h3>
                                    <p><span>Efficacy:</span> It might be more effective in treating the targeted
                                        condition or symptom compared to other similar medications.</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Previous') }}</span>
                            </button>
                            <div class="circle"></div>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Next') }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="my-payment-feedback d-flex">
                        <a href="#" class="single">
                            <div class="my-payment d-flex align-items-center justify-content-center">
                                <div class="img">
                                    <img src="{{ asset('user/asset/img/my-payment.png') }}" alt="">
                                </div>
                                <h3 class="m-0">{{ __('My Payment') }}</h3>
                            </div>
                        </a>
                        <a href="{{ route('u.fdk.index') }}" class="single">
                            <div class="feedback d-flex align-items-center justify-content-center">
                                <div class="img">
                                    <img src="{{ asset('user/asset/img/feedback.png') }}" alt="">
                                </div>
                                <h3 class="m-0">{{ __('Feedback') }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="col-right">
                    <div class="latest-offer">
                        <h2>{{ __('Our Latest Offers') }}</h2>
                        <div class="slider">
                            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                </div>

                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="items d-flex">
                                            <div class="img-col">
                                                <a href="#"><img
                                                        src="{{ asset('user/asset/img/offer-img01') }}.png"
                                                        class="d-block w-100" alt="..."></a>
                                            </div>
                                            <div class="img-col">
                                                <a href="#"><img
                                                        src="{{ asset('user/asset/img/offter-img02.png') }}"
                                                        class="d-block w-100" alt="..."></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="items d-flex">
                                            <div class="img-col">
                                                <a href="#"><img
                                                        src="{{ asset('user/asset/img/offer-img01') }}.png"
                                                        class="d-block w-100" alt="..."></a>
                                            </div>
                                            <div class="img-col">
                                                <a href="#"><img
                                                        src="{{ asset('user/asset/img/offter-img02.png') }}"
                                                        class="d-block w-100" alt="..."></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="google-map">
                        <div class="address d-flex  align-items-center justify-content-between">
                            <div class="title">
                                <h3>{{ __('Address') }}</h3>
                            </div>
                            <div class="btn">
                                <a href="javascript:void(0)" data-toggle="modal"
                                    data-target="#address_add_modal">{{ __('Add Address') }}</a>
                            </div>
                        </div>

                        @if (isset($user->address) && !empty($user->address->first()))
                            <div class="map" id="user_d_map" data-lat={{ $user->address->first()->latitude }}
                                data-lng={{ $user->address->first()->longitude }}></div>
                            <div class="address-btn">
                                <a href="{{ route('u.as.list') }}"><i
                                        class="fa-solid fa-location-dot"></i><span>{{ str_limit($user->address->first()->address, 40) }}</span><i
                                        class="fa-solid fa-angle-right"></i></a>
                            </div>
                        @else
                            <div class="map d-flex align-items-center justify-content-center ">
                                <h6 class="text-warning">{{ __('Please add address') }}</h6>
                            </div>
                            <div class="address-btn">

                            </div>
                        @endif
                    </div>
                    <div class="customer-supporrt">
                        <a href="#">
                            <div class="single d-flex align-items-center justify-content-center">
                                <div class="support-img">
                                    <img src="{{ asset('user/asset/img/customer-support.png') }}" alt="">
                                </div>
                                <div class="title">
                                    <h3 class="text-center">{{ __('Customer') }}<br> {{ __('Support') }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="log-out text-center">
                        <a href="javascript:void(0)"
                            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                            <img src="{{ asset('user/asset/img/log-out.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.address.add_address')
@endsection

@push('js_link')
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
@endpush

@push('js')
    <script src="{{ asset('user/asset/js/mapbox.js') }}"></script>
@endpush
