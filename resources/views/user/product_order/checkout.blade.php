@extends('frontend.layouts.master')
@section('title', 'Checkout')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/checkout.css') }}">
@endpush
@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
@endpush
@section('content')
    @php
        $totalPrice = 0;
        $totalDiscountedPrice = 0;
    @endphp
    <section class="checkout-section py-5">
        <div class="container">
            <form action="{{ route('u.ck.product.order.confirm', encrypt($order->id)) }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ encrypt($order->id) }}">
                <div class="row">
                    <div class="col-7">
                        <div class="order-info-row">
                            <div class="row">
                                <div class="col-12">
                                    <div class="add-new-box border text-center py-4">
                                        <a href="javascript:void(0)" class="address_btn text-decoration-none"
                                            data-bs-toggle="modal"
                                            data-bs-target="#address_add_modal">{{ __('+ Add New Delivery Address') }}</a>
                                    </div>
                                    <h4 class="my-3 title">{{ __('Your Products') }} </h4>
                                    <div class="left">
                                        @foreach ($order->products as $key => $product)
                                            @php
                                                $totalPrice +=
                                                    $product->pivot->quantity *
                                                    $product->pivot->unit->quantity *
                                                    $product->price;
                                                $totalDiscountedPrice +=
                                                    $product->pivot->quantity *
                                                    $product->pivot->unit->quantity *
                                                    $product->discounted_price;
                                            @endphp
                                            <div class="row align-items-center py-2">
                                                <div class="col-2">
                                                    <div class="img">
                                                        <img src="{{ $product->image }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-6 pe-4">
                                                    <h5 class="mb-1" title="{{ $product->attr_title }}">
                                                        {{ $product->name }}</h5>
                                                    <p class="mb-0">{{ $product->generic->name }}</p>
                                                    <p class="mb-0">{{ $product->company->name }}</p>
                                                </div>
                                                <div class="col-4">
                                                    <p class="qt mb-1">
                                                        {{ __('Qty: ') }}<span>{{ $product->pivot->quantity < 10 ? '0' . $product->pivot->quantity : $product->pivot->quantity }}</span>
                                                    </p>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="qt mb-0">
                                                            {{ __('Pack: ') }}<span>{{ $product->pivot->unit->name }}</span>
                                                        </p>
                                                        <p class="qt mb-0">
                                                            @if ($product->discounted_price != $product->price)
                                                                <del class="offer">{!! get_taka_icon() !!}
                                                                    {{ number_format($product->pivot->quantity * $product->pivot->unit->quantity * $product->price, 2) }}</del>
                                                            @endif
                                                            <span>{!! get_taka_icon() !!}
                                                                {{ number_format($product->pivot->quantity * $product->pivot->unit->quantity * $product->discounted_price, 2) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="order-info-row">
                            <div class="right d-flex flex-column justify-content-center">
                                <h4 class="mb-3 title">{{ __('Delivery Address') }}</h4>
                                <select id="address{{ $key }}" name="address"
                                    class="mb-2 py-2 px-1 bg-white address">
                                    @foreach ($customer->address as $key => $address)
                                        <option data-charge="" class="charge" value="{{ $address->id }}"
                                            @if ($address->is_default == true) selected @endif>
                                            {{ str_limit($address->address, 80) }}
                                        </option>
                                    @endforeach
                                </select>
                                <h4 class="mb-3 mt-1 title">{{ __('Order Summary') }}</h4>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Total Price') }}</h5>
                                    <p>{!! get_taka_icon() !!} {{ number_format($totalPrice, 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Discount') }}</h5>
                                    <p>{!! get_taka_icon() !!}{{ number_format($totalPrice - $totalDiscountedPrice, 2) }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Sub Total') }}</h5>
                                    <p>{!! get_taka_icon() !!} {{ number_format(ceil($totalDiscountedPrice)) }}</span></p>
                                </div>
                                <div class="total-border d-flex justify-content-between mb-3">
                                    <h5>{{ __('Delivery Charge') }}</h5>
                                    <p><span> {!! get_taka_icon() !!} </span>
                                        <span class="delivery_fee">0</span>
                                        <input type="hidden" name="delivery_fee" class="delivery_input" value="0">
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Payable Amount') }}</h5>
                                    <p><span> {!! get_taka_icon() !!} </span>
                                        <span class="total_price"
                                            data-total_price="{{ ceil($totalDiscountedPrice) }}">{{ number_format(ceil($totalDiscountedPrice)) }}</span>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Payment Method') }}</h5>
                                </div>
                                <div class="atc_functionality">
                                    <div class="item_units payment">
                                        <div class="form-group my-1 boxed">
                                            <input type="radio" class="unit_qnt" id="android-1" name="payment_method"
                                                value="bkash" checked>
                                            <label for="android-1">
                                                <img style="object-fit: cover"
                                                    src="{{ asset('frontend/asset/img/bkash.png') }}">
                                            </label>
                                            <input type="radio" class="unit_qnt" id="android-2" name="payment_method"
                                                value="nogod">
                                            <label for="android-2">
                                                <img style="object-fit: cover"
                                                    src="{{ asset('frontend/asset/img/nogot.png') }}">
                                            </label>
                                            <input type="radio" class="unit_qnt" id="android-3" name="payment_method"
                                                value="roket">
                                            <label for="android-3">
                                                <img style="object-fit: cover"
                                                    src="{{ asset('frontend/asset/img/rocket.png') }}">
                                            </label>
                                            <input type="radio" class="unit_qnt" id="android-4" name="payment_method"
                                                value="ssl">
                                            <label for="android-4">
                                                <img src="{{ asset('frontend/asset/img/ssl.png') }}"
                                                    style="object-fit: cover">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="place-order confirm_button text-decoration-none border-0" disabled
                                type="submit">{{ __('Place order') }}<img
                                    src="{{ asset('frontend/asset/img/ArrowRight.png') }}" alt="SSL"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('user.address.add_address')
@endsection

@push('js_link')
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
@endpush

@push('js')
    <script>
        let errors = {!! json_encode($errors->all()) !!};
        if (errors.length > 0) {
            errors.forEach(function(error) {
                toastr.error(error);
            });
        }
    </script>
    <script src="{{ asset('user/asset/js/mapbox.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/checkout.js') }}"></script>
    <script>
        const data = {
            'details_url': `{{ route('u.ck.address', ['param']) }}`,
            'taka_icon': `{!! get_taka_icon() !!}`,
        };
    </script>
@endpush
