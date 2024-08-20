@extends('user.layouts.master', ['pageSlug' => 'payment'])
@section('title', 'Payment Details')
@section('content')
    <section class="order-info-section">
        <div class="container">
            <div class="order-info-cont">
                <!-- payment-status-row-start -->
                <div class="row py-4">
                    <div class="col">
                        <div class="order-status-row d-flex align-items-center">
                            <div class="img me-3">
                                <img src="{{ asset('user/asset/img/order-status.png') }}" alt="">
                            </div>
                            <h2 class="mb-0 me-4">{{ __('Transaction ID: ') }}<span>{{ $payment->transaction_id }}</span>
                            </h2>
                            <p class="mb-0 ">{{ slugToTitle($payment->statusTitle()) }}</p>
                        </div>
                    </div>
                </div>
                <!-- payment-status-row-end -->

                <!-- payment-details-row-start -->
                <div class="row py-2 pt-4">
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Payment Date') }}</span>
                            <p>{{ $payment->place_date }}</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Order ID') }}</span>
                            <p>{{ $payment->order->order_id }}</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Customer') }} </span>
                            <p class="mb-0">{{ $payment->customer->name }}</p>
                            <p>{{ __('Mobile : ') }}
                                {{ formatPhoneNumber($payment->customer->phone) }}
                            </p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="order-details">
                            <span>{{ __('Payment Method') }}</span>
                            <p>{{ strtoupper($payment->payment_method) }}</p>
                        </div>
                    </div>
                </div>
                <!-- payment-details-row-end -->
                <!-- payment-information-row-start -->
                <div class="order-info-row">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="mb-3 title">{{ __('Payment Information') }}</h4>
                            <div class="right d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Total Price') }}</h5>
                                    <p>{!! get_taka_icon() . number_format($payment->order->totalPrice, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Discount') }}</h5>
                                    <p>{!! get_taka_icon() . number_format($payment->order->totalPrice - $payment->order->totalDiscountPrice, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Sub Total') }}</h5>
                                    <p>{!! get_taka_icon() . number_format(ceil($payment->order->totalDiscountPrice), 2) !!}</p>
                                </div>
                                <div class="total-border d-flex justify-content-between mb-3">
                                    <h5>{{ __('Delivery Charge') }}</h5>
                                    <p>{!! get_taka_icon() . number_format($payment->order->delivery_fee, 2) !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ slugToTitle($payment->statusTitle()) }}{{ __(' Amount') }}</h5>
                                    <p>{!! get_taka_icon() .
                                        number_format(ceil($payment->order->totalDiscountPrice + $payment->order->delivery_fee), 2) !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-3 title">{{ __('Customer Information') }}</h4>
                            <div class="right d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Customer Name') }}</h5>
                                    <p class="text-end">{{ $payment->customer->name }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Phone') }}</h5>
                                    <p class="text-end">{{ formatPhoneNumber($payment->customer->phone) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Email') }}</h5>
                                    <p class="text-end">{{ $payment->customer->email }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Delivery Address') }}</h5>
                                    <p class="text-end">{{ $payment->order->address->address }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('City') }}</h5>
                                    <p class="text-end">{{ $payment->order->address->city }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Street Address') }}</h5>
                                    <p class="text-end">{{ $payment->order->address->street_address }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Apartment') }}</h5>
                                    <p class="text-end">{{ $payment->order->address->apartment }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Floor') }}</h5>
                                    <p class="text-end">{{ $payment->order->address->floor }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>{{ __('Delivery Instruction') }}</h5>
                                    <p class="text-end">{{ $payment->order->address->delivery_instruction }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- payment-information-row-end -->
            </div>
        </div>
    </section>
@endsection
