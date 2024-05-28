@extends('frontend.layouts.master')
@section('title', 'Checkout')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend\asset\css\checkout.css') }}">
@endpush
@section('content')
    <div class="row py-5 my-5 main_checkout_wrap">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <form action="{{ route('product.order.confirm', encrypt($order_id)) }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ encrypt($order_id) }}">
                    <div class="row">
                        <div class="col-md-8 cart">
                            <div class="title">
                                <div class="row">
                                    <div class="col">
                                        <h4><b>{{ __('Your Products') }}</b></h4>
                                    </div>
                                    <div class="col align-self-center text-end text-muted">
                                        {{ collect($checkItems)->count() }} {{ __('items') }}</div>
                                </div>
                            </div>
                            @php
                                $total_price = 0;
                                $total_regular_price = 0;
                                $total_discount = 0;
                            @endphp
                            @foreach ($checkItems as $key => $cartItem)
                                <div class="row order-item">
                                    <div class="row main align-items-center py-2 px-0">
                                        <div class="col-2"><img class="img-fluid"
                                                src="{{ storage_url($cartItem['product']->image) }}"></div>
                                        <div class="col-6">
                                            <div class="row" title="{{ $cartItem['product']->attr_title }}">
                                                {{ $cartItem['product']->name }}</div>
                                            <div class="row text-muted">{{ $cartItem['product']->pro_sub_cat->name }}</div>
                                            <div class="row text-muted">{{ $cartItem['product']->generic->name }}</div>
                                            <div class="row text-muted">{{ $cartItem['product']->company->name }}</div>
                                        </div>
                                        <div class="col-2">
                                            @if (isset($cartItem['status']))
                                                @php
                                                    $total_discount +=
                                                        $cartItem['quantity'] *
                                                        number_format(
                                                            $cartItem['product']->discount_amount *
                                                                $cartItem['unit']->quantity,
                                                            2,
                                                        );
                                                @endphp
                                                <span>1 X {{ $cartItem['name'] }}</span>
                                            @else
                                                <span>{{ $cartItem['quantity'] }} X {{ $cartItem['name'] }}</span>
                                                @php
                                                    $total_discount +=
                                                        $cartItem['quantity'] *
                                                        number_format(
                                                            $cartItem['product']->discount_amount *
                                                                $cartItem['unit']->quantity,
                                                            2,
                                                        );
                                                @endphp
                                            @endif
                                        </div>
                                        <div class="col-2 text-end">
                                            @php
                                                $single_total_price =
                                                    $cartItem['product']->discountPrice() *
                                                    $cartItem['unit']->quantity *
                                                    $cartItem['quantity'];
                                                $single_regular_price =
                                                    $cartItem['product']->price *
                                                    $cartItem['unit']->quantity *
                                                    $cartItem['quantity'];
                                                $total_price += $single_total_price;
                                                $total_regular_price += $single_regular_price;
                                            @endphp
                                            @if (productDiscountPercentage($cartItem['product']->id))
                                                <span class="text-danger me-2"><del>{!! get_taka_icon() !!}
                                                        {{ number_format($single_regular_price, 2) }}</del></span>
                                            @endif
                                            <span> {!! get_taka_icon() !!}
                                            </span><span>{{ number_format($single_total_price, 2) }}</span>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row order-item">
                                <div class="row main align-items-center py-2 px-0">
                                    <div class="col mb-2">{{ __('Total Item') }} ( {{ count($checkItems) }} )</div>
                                    <div class="col text-end">
                                        <span>{{ __('Sub-total  ') }}</span>
                                        @if ($total_regular_price !== $total_price)
                                            <span class="text-danger mx-2"><del>{!! get_taka_icon() !!}
                                                    {{ number_format(ceil($total_regular_price)) }}</del></span>
                                        @endif
                                        <span>{!! get_taka_icon() !!} {{ number_format(ceil($total_price)) }}</span>

                                    </div>
                                </div>
                            </div>


                            <div class="back-to-shop"><a href="{{ route('category.products') }}">&leftarrow; <span
                                        class="text-muted">{{ __('Back to shop') }}</span></a>
                            </div>
                        </div>
                        <div class="col-md-4 summary">
                            <div>
                                <h5><b>{{ __('Order Summary') }}</b></h5>
                            </div>
                            <hr>
                            <div class="row mb-2">

                                <p class="p-0">{{ __('Shipping') }}</p>
                                <select name="delivery_type">
                                    <option class="text-muted" value="normal">{{ __('Normal-Delivery') }} </option>
                                    <option class="text-muted" value="standard">{{ __('Standard-Delivery') }} </option>
                                </select>
                                {{-- <p>{{__('GIVE PROMO CODE')}}</p>
                                    <input id="code" placeholder="Enter your code"> --}}
                                <p class="p-0">{{ __('Address') }}</p>

                                @foreach ($customer->address as $key => $address)
                                    <div class="form-check ms-2">
                                        <input class="form-check-input address" value="{{ $address->id }}"
                                            style="width: 1em" type="radio" name="address_id"
                                            id="address{{ $key }}"
                                            @if ($address->is_default == true) checked @endif>
                                        <label class="form-check-label ms-2" for="address{{ $key }}">
                                            {{ str_limit($address->address, 80) }} (<span> {!! get_taka_icon() !!} </span>
                                            <span class="charge" data-charge=""></span>)
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{ __('Total Price') }}</div>
                                <div class="col text-end ">
                                    <span> {!! get_taka_icon() !!} {{ number_format(ceil($total_regular_price)) }}</span>
                                </div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{ __('Discount') }}</div>
                                <div class="col text-end "><span> {!! get_taka_icon() !!} </span>
                                    <span>{{ number_format(ceil($total_discount)) }}</span>
                                </div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{ __('Sub-total') }}</div>
                                <div class="col text-end ">
                                    <span> {!! get_taka_icon() !!} {{ number_format(ceil($total_price)) }}</span>
                                </div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{ __('Delivery Fee') }}</div>
                                <div class="col text-end "><span> {!! get_taka_icon() !!} </span>
                                    <span class="delivery_fee">{{ number_format(ceil($default_delivery_fee)) }}</span>
                                    <input type="hidden" name="delivery_fee" class="delivery_input" value="{{ ceil($default_delivery_fee) }}">
                                </div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{ __('Payable Amount') }}</div>
                                <div class="col text-end "><span> {!! get_taka_icon() !!} </span>
                                    <span class="total_price" data-total_price="{{ceil($total_price)}}">{{ number_format(ceil($total_price+$default_delivery_fee)) }}</span>
                                </div>
                            </div>

                            <div class="row align-items-center atc_functionality">
                                <div class="item_units col">
                                    <div class="form-group my-1 boxed">
                                        <input type="radio" class="unit_quantity" id="android-1" name="payment_method"
                                            value="bkash" checked>
                                        <label for="android-1">
                                            <img style="object-fit: cover"
                                                src="{{ asset('frontend/asset/img/bkash.png') }}">
                                        </label>
                                        <input type="radio" class="unit_quantity" id="android-2" name="payment_method"
                                            value="nogod">
                                        <label for="android-2">
                                            <img style="object-fit: cover"
                                                src="{{ asset('frontend/asset/img/nogod.png') }}">
                                        </label>
                                        <input type="radio" class="unit_quantity" id="android-3" name="payment_method"
                                            value="roket">
                                        <label for="android-3">
                                            <img style="object-fit: cover"
                                                src="{{ asset('frontend/asset/img/roket.png') }}">
                                        </label>
                                        <input type="radio" class="unit_quantity" id="android-4" name="payment_method"
                                            value="ssl">
                                        <label for="android-4">
                                            <img src="{{ asset('frontend/asset/img/ssl.jpg') }}"
                                                style="object-fit: cover">
                                        </label>
                                    </div>
                                </div>
                                <button class="btn confirm_button" disabled type="submit">{{ __('CONFIRM ORDER') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js_link')
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
    <script src="{{ asset('frontend/js/checkbox.js') }}"></script>
@endpush

@push('js')
    <script>
        // Number Format Function 
        // function numberFormat(value, decimals) {
        //     if (decimals != null && decimals >= 0) {
        //         value = parseFloat(value).toFixed(decimals);
        //     } else {
        //         value = Math.round(parseFloat(value)).toString();
        //     }
        //     return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        // }
        const data = {
            'details_url': `{{ route('u.ck.address', ['param']) }}`,
        };
    </script>
@endpush
