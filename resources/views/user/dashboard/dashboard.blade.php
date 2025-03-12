@extends('user.layouts.master', ['pageSlug' => 'dashboard'])
@section('title', 'User Dashboard')
@push('css_link')
    {{-- <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
    <style>
        .offer_image img {
            height: 75px;
            width: 100%;
            border: 2px solid var(--btn_bg) !important;
            padding: 0px;
            object-fit: contain;
            border-radius: 10px;
        }

        .tips_image img {
            height: 120px;
            width: 100%;
            border: 2px solid var(--btn_bg) !important;
            padding: 0px;
            object-fit: contain;
            border-radius: 10px;
        }

        /* .tips_details {
                height: 55px;
                overflow-y: hidden;
            } */
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-mid">
                    <div class="col-left">
                        <div class="row row-gap-3 row-gap-sm-4">
                            <div class="col-xl-9 col-12 order-2 order-xl-1">
                                <div class="row mb-0 mb-xl-4 row-gap-3 row-gap-sm-4">
                                    <div class="col-lg-6 col-12">
                                        <div class="row row-gap-3 row-gap-sm-4">
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.order.list') }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box cancel-order">
                                                        <div class="count">
                                                            <span>{{ $total_orders }}</span>
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('My Orders') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.payment.list') }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box previous-order">
                                                        <div class="count-cart">
                                                            <span>{{ $total_payments }}</span>
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('My Payments') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="javascript:void(0)" id="db_cart_icon_btn"
                                                    data-bs-toggle="offcanvas" data-bs-target="#cartbtn"
                                                    aria-controls="offcanvasRight"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box">
                                                        <div class="count">
                                                            <span id="db_cart_btn_quantity"></span>
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('My Cart') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.order.list', ['status' => 'current-orders']) }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box previous-order">
                                                        <div class="count-cart">
                                                            <span>{{ $total_current_orders }}</span>
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Running Orders') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.order.list', ['status' => 'previous-orders']) }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box cancel-order">
                                                        <div class="count">
                                                            <span>{{ $total_previous_orders }}</span>
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Previous Orders') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.order.list', ['status' => 'cancel-orders']) }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box previous-order">
                                                        <div class="count-cart">
                                                            <span>{{ $total_cancel_orders }}</span>
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Cancel Orders') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="row row-gap-3 row-gap-sm-4">
                                            <div class="col-12 order-2 order-lg-1">
                                                <div class="medicine-slider">
                                                    <div id="carouselExampleControlsNoTouching" class="carousel slide"
                                                        data-bs-touch="false">
                                                        <div class="carousel-inner">
                                                            @foreach ($order_products as $key => $product)
                                                                <div
                                                                    class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                    <h3><span>{{ $product->name }}</span>({{ optional($product->strength)->name }})
                                                                    </h3>
                                                                    <p><span>{{ __('Efficacy: ') }}</span>
                                                                        {!! $product->precaution->description !!}
                                                                    </p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#carouselExampleControlsNoTouching"
                                                            data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">{{ __('Previous') }}</span>
                                                        </button>
                                                        <div class="circle"></div>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#carouselExampleControlsNoTouching"
                                                            data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">{{ __('Next') }}</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12 order-1 order-xl-2">
                                <div class="letest-offer-shadow">
                                    <div class="col-right row row-gap-3 row-gap-xl-0">
                                        <div class="col-xl-12 col-md-6 col-12 mt-0">
                                            <div class="latest-col">
                                                @include('user.dashboard.include.latest-offer')
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-6 col-12">
                                            <div class="tips-col">
                                                @if ($user_tips->isNotEmpty())
                                                    <div class="tips">
                                                        @foreach ($user_tips as $tips)
                                                            <div class="single-tips d-flex d-xl-block  gap-3">
                                                                <div class="tips_image">
                                                                    <div id="lightbox" class="lightbox h-100">
                                                                        <div class="lightbox-content h-100">
                                                                            <img src="{{ storage_url($tips->image) }}"
                                                                                class="lightbox_image d-block w-100">
                                                                        </div>
                                                                        <div class="close_button fa-beat">X</div>
                                                                    </div>
                                                                    {{-- <img src="{{ asset('user/asset/img/tips-img.png') }}"
                                                        alt=""> --}}
                                                                </div>
                                                                <div class="tips_details mt-0 mt-xl-3">
                                                                    <p>{!! str_limit(strip_tags($tips->description), 270) !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="col-mid">
                    <div class="col-left mt-4 mt-xl-0">
                        <div class="row row-gap-3 row-gap-sm-4">
                            <div class="col-xl-9 col-12">
                                <div class="col-right row row-gap-3 row-gap-sm-4 ">
                                    <div class="col-lg-6 col-12 order-2 order-lg-1">
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
                                                {{-- <div class="map" id="user_d_map"
                                            data-lat="{{ $user->address->first()->latitude }}"
                                            data-lng="{{ $user->address->first()->longitude }}">
                                        </div> --}}
                                                <div class="address_details px-3">
                                                    <div class="card bg-transparent">
                                                        <div class="card-body">
                                                            {{-- {{ dd($user->address) }} --}}
                                                            <ul class="m-0 list-unstyled">
                                                                <li>
                                                                    <strong>{{ __('Street Addrees: ') }}</strong>
                                                                    {{ str_limit($user->address[0]->street_address) }}
                                                                </li>
                                                                <li><strong>{{ __('Address: ') }}</strong>
                                                                    {{ str_limit($user->address[0]->address) }}
                                                                </li>
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-12">
                                                                            <strong>{{ __('Apartment: ') }}</strong>
                                                                            {{ $user->address[0]->apartment }}
                                                                        </div>
                                                                        <div class="col-sm-6 col-12">
                                                                            <strong>{{ __('Floor: ') }}</strong>
                                                                            {{ $user->address[0]->floor }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-12">
                                                                            <strong>{{ __('City: ') }}</strong>
                                                                            {{ $user->address[0]->city }}
                                                                        </div>
                                                                        <div class="col-sm-6 col-12">
                                                                            <strong>{{ __('Zone: ') }}</strong>
                                                                            {{ optional($user->address[0]->zone)->name }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-12 col-lg-12 col-xxl-6">
                                                                            <strong>{{ __('Delivery Charge: ') }}</strong>
                                                                            {{ optional($user->address[0]->zone)->charge ? optional($user->address[0]->zone)->charge . __('BDT') : '' }}
                                                                        </div>
                                                                        <div class="col-sm-6 col-12 col-lg-12 col-xxl-6">
                                                                            <strong>{{ __('Est. Delivery Time: ') }}</strong>
                                                                            {{ optional($user->address[0]->zone)->delivery_time_hours ? optional($user->address[0]->zone)->delivery_time_hours . __('Hours') : '' }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-12 col-lg-12 col-xxl-6">
                                                                            <strong>{{ __('Express Delivery: ') }}</strong>
                                                                            {{ optional($user->address[0]->zone)->allows_express ? __('Yes') : 'No' }}
                                                                        </div>
                                                                        <div class="col-sm-6 col-12 col-lg-12 col-xxl-6">
                                                                            <strong>{{ __('Express Charge: ') }}</strong>
                                                                            {{ optional($user->address[0]->zone)->allows_express ? optional($user->address[0]->zone)->express_charge . __('BDT') : 'N/A' }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
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
                                    </div>
                                    <div class="col-lg-6 col-12 order-1 order-lg-2">
                                        <div class="row mb-0 mb-xl-4 row-gap-3 row-gap-sm-4">
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.kyc.verification') }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box cancel-order">
                                                        <div class="icon-imges">
                                                            <img src="{{ asset('user/asset/img/kyc.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Kyc') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.review.list') }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box previous-order">
                                                        <div class="icon-imges">
                                                            <img src="{{ asset('user/asset/img/star-half.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Reviews') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-2 col-4 px-2">
                                                <a href="{{ route('u.wishlist.list') }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box cancel-order">
                                                        <div class="icon-imges">
                                                            <img src="{{ asset('user/asset/img/wishtlist2.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Wishlists') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-8 col-lg-8 col-md-4  col-8 order-5 order-xl-4 px-2">
                                                <div class="customer-supporrt p-sm-0">
                                                    <a href="#">
                                                        <div
                                                            class="single d-flex align-items-center justify-content-center">
                                                            <div class="support-img">
                                                                <img src="{{ asset('user/asset/img/customer-support.png') }}"
                                                                    alt="icon-imges">
                                                            </div>
                                                            <div class="title">
                                                                <h3 class="text-center">{{ __('Customer') }}<br>
                                                                    {{ __('Support') }}</h3>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4  col-md-2 col-4 order-4 order-xl-6 px-2">
                                                <a href="{{ route('u.fdk.index') }}"
                                                    style="text-decoration: none; color:#212529;">
                                                    <div class="single-box previous-order">
                                                        <div class="icon-imges">
                                                            <img src="{{ asset('user/asset/img/feedback.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="title">
                                                            <h2>{{ __('Feedback') }}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12 order-1 order-xl-2">
                                <div class="row row-gap-3 row-gap-sm-4">

                                    <div class="col-12 col-sm-6 col-xl-12 m-lg-0 m-auto">
                                        <div class="language">
                                            <form id="languageForm" action="{{ route('language.switch') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="locale" id="localeInput"
                                                    value="{{ app()->getLocale() }}">

                                                <div class="language-switch" onclick="toggleLanguage()">
                                                    <span id="english-text"
                                                        class="{{ app()->getLocale() === 'en' ? 'active-text' : '' }}">English</span>
                                                    <span id="bangla-text"
                                                        class="{{ app()->getLocale() === 'bn' ? 'active-text' : '' }}">বাংলা</span>
                                                    <div class="switch-btn {{ app()->getLocale() === 'bn' ? 'active-right' : 'active-left' }}"
                                                        id="switch-btn"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-xl-12 m-lg-0 m-auto ">
                                        <div class="log-out text-left">
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
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>


    <script>
        $('#carouselExampleDark').carousel({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            dots: true,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]

        })
    </script>
@endpush
