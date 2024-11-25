@extends('user.layouts.master', ['pageSlug' => 'order'])
@section('title', 'Order Details')
@section('content')
    <section class="order-info-section">
        <div class="container">
            <div class="order-info-cont">
                <!-- Order-status-row-start -->
                <div class="row flex-column-reverse flex-md-row">
                    <div class="col-md-8 col-12">
                        <div class="order-status-row d-flex align-items-center py-4">
                            <div class="img me-3">
                                <img src="{{ asset('user/asset/img/order-status.png') }}" alt="">
                            </div>
                            <h2 class="mb-0 me-4">{{ __('Order ID: ') }}<span>{{ $order->order_id }}</span></h2>
                            <p class="mb-0 fw-bold">{{ slugToTitle($order->statusTitle) }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-4 gap-4">
                            <h2 class="title">{{ __('Order Tracking') }}</h2>

                        </div>
                    </div>
                    @if ($order->otp)
                        <div class="col-md-4 col-12 fs-1 pb-4">
                            <div class="order-status-row py-5 otp d-flex justify-content-center align-items-center">
                                <p class="mb-0 fw-bold">{{ __('OTP: ') }}{{ $order->otp }}</p>
                            </div>
                        </div>
                    @endif


                </div>
                <!-- Order-status-row-end -->

                <!-- Order Tracking row start-->
                <div class="order-traking-row">
                    <div class="progress-box d-flex justify-content-between">
                        <div class="step step-1 text-center">
                            <div
                                class="icon {{ $order->status >= 1 ? 'confirm' : '' }} {{ $order->status > 1 ? 'active' : '' }} text-center mb-2">
                                @if ($order->status >= 1)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <h5>{{ __('Order Submitted') }}</h5>
                            @if ($order->status >= 1)
                                <p class="m-0">{{ orderTimeFormat($order->created_at) }}</p>
                            @endif
                        </div>
                        <div class="step step-2 text-center">
                            <div
                                class="icon {{ $order->status >= 2 ? 'confirm' : '' }} {{ $order->status > 3 ? 'active' : '' }} text-center mb-2">
                                @if ($order->status >= 2)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <h5>{{ __('Order Proccesing') }}</h5>
                            @if ($order->status >= 2)
                                <p class="m-0">{{ orderTimeFormat($order->od->created_at) }}</p>
                            @endif
                        </div>
                        <div class="step step-3 text-center">
                            <div
                                class="icon {{ $order->status >= 4 ? 'confirm' : '' }} {{ $order->status > 4 ? 'active' : '' }} text-center mb-2">
                                @if ($order->status >= 4)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <h5>{{ __('Order Shipped') }}</h5>
                            @if ($order->status >= 4)
                                <p class="m-0">
                                    {{ orderTimeFormat($order->od->odrs->where('status', '!=', 0)->first()->created_at) }}
                                </p>
                            @endif
                        </div>
                        <div class="step step-4 text-center">
                            <div
                                class="icon {{ $order->status >= 5 ? 'confirm' : '' }} {{ $order->status > 5 ? 'active' : '' }} text-center mb-2">
                                @if ($order->status >= 5)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <h5>{{ __('Out For Delivery') }}</h5>
                            @if ($order->status >= 5)
                                <p class="m-0">{{ orderTimeFormat($order->od->rider_collected_at) }}</p>
                            @endif
                        </div>
                        <div class="step step-5 text-center">
                            <div
                                class="icon {{ $order->status >= 6 ? 'confirm' : '' }} {{ $order->status >= 6 ? 'active' : '' }} text-center mb-2">
                                @if ($order->status >= 6)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <h5>{{ __('Delivered') }}</h5>
                            @if ($order->status >= 6)
                                <p class="m-0">{{ orderTimeFormat($order->od->rider_delivered_at) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Order Tracking row end-->

                <!-- Order-details-row-start -->
                <div class="row py-2 pt-4">
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Order Date') }}</span>
                            <p>{{ $order->place_date }}</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Delivery Time') }}</span>
                            <p>Est. delivery 00 min</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Receiver Name') }} </span>
                            <p class="mb-0">{{ $order->customer->name }}</p>
                            <p>{{ __('Mobile : ') }}
                                {{ formatPhoneNumber($order->customer->phone) }}
                            </p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Delivery Address') }}</span>
                            <p>{{ __(optional($order->address)->address) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Order-details-row-end -->

                <!-- Order-information-row-start -->
                <div class="order-info-row">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="mb-3 title">{{ __('Order Information') }}</h4>
                            <div class="left">
                                @foreach ($order->products as $product)
                                    <div class="row align-items-center py-2">
                                        <div class="col-2">
                                            <div class="img">
                                                <img src="{{ $product->image }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7 ps-4">
                                            <h5 class="mb-1" title="{{ $product->attr_title }}">{{ $product->name }}
                                            </h5>
                                            <p class="mb-0">{{ $product->generic->name }}</p>
                                            <p class="mb-0">{{ $product->company->name }}</p>
                                        </div>
                                        <div class="col-3">
                                            <p class="qt mb-1">
                                                {{ __('Qty: ') }}<span>{{ $product->pivot->quantity }}</span></p>
                                            <p class="qt mb-0">
                                                {{ __('Pack: ') }}<span>{{ $product->pivot->unit->name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-3 title">{{ __('Order Summary') }}</h4>
                            <div class="right d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Total Price') }}</h5>
                                    <p>{!! get_taka_icon() . number_format($order->totalPrice, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Discount') }}</h5>
                                    <p>{!! get_taka_icon() . number_format($order->totalPrice - $order->totalDiscountPrice, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Sub Total') }}</h5>
                                    <p>{!! get_taka_icon() . number_format(ceil($order->totalDiscountPrice), 2) !!}</p>
                                </div>
                                <div class="total-border d-flex justify-content-between mb-3">
                                    <h5>{{ __('Delivery Charge') }}</h5>
                                    <p>{!! get_taka_icon() . number_format($order->delivery_fee, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Payable Amount') }}</h5>
                                    <p>{!! get_taka_icon() . number_format(ceil($order->totalDiscountPrice + $order->delivery_fee), 2) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-info-row mt-4">
                    <div class="row">
                        <div class="col">
                            <h4 class="mb-3 title">{{ __('Payment Information') }}</h4>
                            <div class="wrap">
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SL') }}</th>
                                            <th>{{ __('Tran ID') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Submitted date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->transaction_id }}</td>
                                                <td>{!! get_taka_icon() . number_format(ceil($payment->amount), 2) !!}
                                                </td>
                                                <td><span
                                                        class="{{ $payment->statusBg() }}">{{ $payment->statusTitle() }}</span>
                                                </td>
                                                <td>{{ timeFormate($payment->created_at) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order-information-row-end -->
            </div>
        </div>
    </section>
@endsection
