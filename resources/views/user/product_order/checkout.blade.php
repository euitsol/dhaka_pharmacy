@extends('frontend.layouts.master')
@section('title', 'Checkout')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/checkout.css') }}">
@endpush
@push('css_link')
    {{-- <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
    <script>
        const data = {
            'details_url': `{{ route('u.ck.address', ['param']) }}`,
            'taka_icon': `{!! get_taka_icon() !!}`,
        };
    </script>
@endpush
@section('content')
    <section class="checkout-section py-3 py-lg-5">
        <div class="container">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <form action="{{ route('u.ck.product.order.confirm') }}" id="confirmOrderForm" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ encrypt($order->order_id) }}">
                <div class="row row-gap-4">
                    <div class="col-12 col-lg-7 px-0 px-lg-3">
                        <div class="order-info-row">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-xxl-6 mb-3 mb-xxl-0">
                                            <div class="add-new-box border rounded hover-shadow">
                                                <a href="javascript:void(0)"
                                                    class="address_btn text-decoration-none d-flex align-items-center justify-content-center gap-2 py-3"
                                                    data-bs-toggle="modal" data-bs-target="#address_add_modal">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M19 10c0 3.976-7 11-7 11s-7-7.024-7-11c0-3.866 3.134-7 7-7s7 3.134 7 7z" />
                                                        <path
                                                            d="M15 10c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
                                                        <path d="M9 6.5V5c0-1.105.895-2 2-2h2c1.105 0 2 .895 2 2v1.5" />
                                                        <path d="M12 7v2" />
                                                        <path d="M10.5 8.5h3" />
                                                    </svg>
                                                    <span class="fw-medium">{{ __('Add New Delivery Address') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6">
                                            <div class="add-new-box border rounded hover-shadow">
                                                <a href="javascript:void(0)"
                                                    class="address_btn text-decoration-none d-flex align-items-center justify-content-center gap-2 py-3"
                                                    data-bs-toggle="modal" data-bs-target="#addVoucherModal">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M21 5H3a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h18c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1z" />
                                                        <path
                                                            d="M21 13H3a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h18c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1z" />
                                                        <path d="M6.5 5v14" />
                                                        <path d="M17.5 5v14" />
                                                        <path d="m9 8.5 2-2" />
                                                        <path d="m9 6.5 2 2" />
                                                        <path d="m13 16.5 2-2" />
                                                        <path d="m13 14.5 2 2" />
                                                    </svg>
                                                    <span class="fw-medium">{{ __('Add Voucher Code') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="my-3 title">{{ __('Your Products') }} </h4>
                                    <div class="left">
                                        @foreach ($order->products as $key => $product)
                                            <div class="row align-items-center py-2">
                                                <div class="col-4 col-sm-3 col-md-2">
                                                    <div class="img">
                                                        <img src="{{ storage_url($product->image) }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-8 col-sm-9 col-md-10">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-sm-7 col-md-8 pe-0 pe-md-4">
                                                            <h5 class="mb-1" title="{{ $product->attr_title }}">
                                                                {{ $product->name }}</h5>
                                                            <p class="mb-0" title="{{ $product->generic->name }}">
                                                                {{ $product->generic->name }}</p>
                                                            <p class="mb-0" title="{{ $product->company->name }}">
                                                                {{ $product->company->name }}</p>
                                                        </div>
                                                        <div class="col-12 col-sm-5 col-md-4 mt-1 mt-md-0">
                                                            <div
                                                                class="qty-col d-flex justify-content-start d-md-block flex-column flex-xl-row">
                                                                <div class="qt-1 pe-3 pe-md-0">
                                                                    <p class="qt mb-1">
                                                                        {{ __('Qty: ') }}<span>{{ $product->pivot->quantity }}</span>
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="d-flex justify-content-between flex-column flex-xl-row">
                                                                    <p class="qt mb-0 pe-3 pe-md-0">
                                                                        {{ __('Unit: ') }}<span>{{ $product->pivot->unit_name }}</span>
                                                                    </p>
                                                                    <p class="qt mb-0 mt-1 mt-xl-0">
                                                                        @if ($product->pivot->unit_discount > 0)
                                                                            <del class="offer">{!! get_taka_icon() !!}
                                                                                {{ number_format($product->pivot->unit_price * $product->pivot->quantity, 2) }}</del>
                                                                        @endif
                                                                        <span>{!! get_taka_icon() !!}
                                                                            {{ number_format($product->pivot->total_price, 2) }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 px-0 px-lg-3">
                        <div class="order-info-row">
                            <div class="right d-flex flex-column justify-content-center">
                                <h4 class="mb-3 title">{{ __('Delivery Address') }}</h4>
                                <select id="address{{ $key }}" name="address"
                                    class="mb-2 py-2 px-1 bg-white address">
                                    @forelse ($user->address as $key => $address)
                                        <option class="charge" value="{{ $address->id }}"
                                            @if ($address->is_default == true) selected @endif>
                                            {{ str_limit($address->address, 45) }}
                                        </option>
                                    @empty
                                        <option value="">{{ __('No address found. Please add a new address.') }}
                                        </option>
                                    @endforelse
                                </select>
                                <h4 class="mb-3 mt-1 title">{{ __('Order Summary') }}</h4>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Sub Total') }}</h5>
                                    <p>{!! get_taka_icon() !!}
                                        <span class="amount-a">
                                            {{ number_format(ceil($order->sub_total), 2) }}</span> (+)
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Product Discount') }}</h5>
                                    <p>{!! get_taka_icon() !!}
                                        <span class="amount-m">{{ number_format($order->product_discount, 2) }}</span> (-)
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Voucher Discount') }}</h5>
                                    <p>{!! get_taka_icon() !!}
                                        <span class="amount-m">{{ number_format($order->voucher_discount, 2) }}</span> (-)
                                    </p>
                                </div>
                                <div class="total-border d-flex justify-content-between mb-3">
                                    <h5>{{ __('Delivery Charge') }}</h5>
                                    <p>{!! get_taka_icon() !!}
                                        <span class="amount-a"
                                            id="delivery_charge">{{ number_format($order->delivery_fee, 2) }}</span> (+)
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Payable Amount') }}</h5>
                                    <p><span> {!! get_taka_icon() !!} </span>
                                        <span class="total-amount"
                                            id="total_amount">{{ number_format(ceil($order->total_amount), 2) }}</span>
                                    </p>
                                </div>
                                <div class="delivery-section p-3 bg-white rounded shadow-sm">
                                    <h5 class="mb-2">{{ __('Delivery Type') }}</h5>
                                    <div class="row g-4" id="delivery_type_container">
                                        <div class="text-center w-100">{{ __('Please add a delivery address') }}</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <h5>{{ __('Payment Method') }}</h5>
                                </div>
                                <div class="atc_functionality">
                                    <div class="item_units payment">
                                        <div class="form-group my-1 boxed">
                                            <input type="radio" class="payment-method" id="android-1"
                                                name="payment_method" value="bkash">
                                            <label for="android-1">
                                                <img style="object-fit: contain"
                                                    src="{{ asset('frontend/asset/img/bkash.png') }}">
                                            </label>
                                            <input type="radio" class="payment-method" id="android-2"
                                                name="payment_method" value="nogod">
                                            <label for="android-2">
                                                <img style="object-fit: contain"
                                                    src="{{ asset('frontend/asset/img/nogot.png') }}">
                                            </label>
                                            <input type="radio" class="payment-method" id="android-3"
                                                name="payment_method" value="roket">
                                            <label for="android-3">
                                                <img style="object-fit: contain"
                                                    src="{{ asset('frontend/asset/img/rocket.png') }}">
                                            </label>
                                            <input type="radio" class="payment-method" id="android-4"
                                                name="payment_method" value="ssl">
                                            <label for="android-4">
                                                <img src="{{ asset('frontend/asset/img/ssl.png') }}"
                                                    style="object-fit: contain">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="place-order confirm_button text-decoration-none border-0"
                                type="submit">{{ __('Place order') }}<img
                                    src="{{ asset('frontend/asset/img/ArrowRight.png') }}"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('user.address.add_address')
    @include('user.product_order.voucher-modal')
    {{-- @include('user.address.new-address-modal') --}}
@endsection

@push('js_link')
    {{-- <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('user/asset/js/address.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/checkout.js') }}"></script>
@endpush

@push('js')
    @if ($errors->any())
        <script>
            var errors = @json($errors->all());
            errors.forEach(function(error) {
                toastr.error(error);
            });
        </script>
    @endif
@endpush
