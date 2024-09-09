@extends('user.layouts.master', ['pageSlug' => 'dashboard'])
@section('title', 'User Dashboard')
@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
    <style>
        .offer_image img {
            height: 120px;
            width: 159.5px;
            border: 2px solid var(--btn_bg) !important;
            padding: 5px;
            object-fit: cover;
            border-radius: 20px;
        }

        .tips_image img {
            height: 100px;
            width: 120px;
            border: 2px solid var(--btn_bg) !important;
            padding: 5px;
            object-fit: cover;
            border-radius: 20px;
        }
    </style>
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
                    @if ($user_tips->isNotEmpty())
                        <div class="tips">
                            <h2>{{ __('Tips of The Day') }}</h2>
                            @foreach ($user_tips as $tips)
                                <div class="single-tips d-flex align-items-center justify-content-start gap-3">
                                    <div class="tips_image">
                                        <div id="lightbox" class="lightbox tips_image">
                                            <div class="lightbox-content">
                                                <img src="{{ storage_url($tips->image) }}" class="lightbox_image">
                                            </div>
                                            <div class="close_button fa-beat">X</div>
                                        </div>
                                        {{-- <img src="{{ asset('user/asset/img/tips-img.png') }}" alt=""> --}}
                                    </div>
                                    <div class="tips_details">
                                        <p>{{ str_limit(html_entity_decode($tips->description), 270) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="order-cart-wish d-flex justify-content-center mt-5">
                        <a href="{{ route('u.order.list') }}">
                            <div class="single d-flex align-items-center justify-content-center">
                                <div class="content text-center">
                                    <img src="{{ asset('user/asset/img/my-order.png') }}" alt="">
                                    <h2>{{ __('My Orders') }}</h2>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#cartbtn"
                            aria-controls="offcanvasRight">
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
                        <a href="{{ route('u.review.list') }}">
                            <div class="single  d-flex align-items-center justify-content-center">
                                <div class="content text-center">
                                    <img src="{{ asset('user/asset/img/star-half.png') }}" alt="">
                                    <h2>{{ __('Reviews') }}</h2>
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
                        <a href="{{ route('u.payment.list') }}" class="single">
                            <div class="my-payment d-flex align-items-center justify-content-center">
                                <div class="img">
                                    <img src="{{ asset('user/asset/img/my-payment.png') }}" alt="">
                                </div>
                                <h3 class="m-0">{{ __('My Payments') }}</h3>
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
                    @if ($latest_offers->isNotEmpty())
                        <div class="latest-offer">
                            <h2>{{ __('Our Latest Offers') }}</h2>
                            <div class="slider">
                                <div id="carouselExampleDark" class="carousel carousel-dark slide"
                                    data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @if ($latest_offers->count() > 2)
                                            @foreach ($latest_offers->chunk(2) as $key => $lf)
                                                <button type="button" data-bs-target="#carouselExampleDark"
                                                    data-bs-slide-to="{{ $key }}"
                                                    class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"
                                                    aria-label="Slide {{ $key + 1 }}"></button>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="carousel-inner">
                                        @foreach ($latest_offers->chunk(2) as $key => $lfs)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <div class="items d-flex">
                                                    @foreach ($lfs as $lf)
                                                        <div class="img-col w-100">
                                                            <a href="#">
                                                                <div id="lightbox" class="lightbox offer_image">
                                                                    <div class="lightbox-content">
                                                                        <img src="{{ storage_url($lf->image) }}"
                                                                            class="lightbox_image">
                                                                    </div>
                                                                    <div class="close_button fa-beat">X</div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <h2>{{ __('Address') }}</h2>
                    @endif
                    <div class="google-map" @if ($latest_offers->isEmpty()) style="margin-top:20px" @endif>
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
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
