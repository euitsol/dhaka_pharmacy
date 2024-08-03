@extends('frontend.layouts.master')
@section('title', 'Payment')
@section('content')
    <div class="row py-5 my-5 order_success_wrap">
        <div class="col-12">
            <div class="order_success">
                <div class="printer-top"></div>

                <div class="paper-container">
                    <div class="printer-bottom"></div>

                    <div class="paper">
                        <div class="main-contents">
                            <div class="success-icon bg-danger text-white"><i class="fa-solid fa-xmark"></i></div>
                            <div class="success-title">
                                {{ __('Payment Cancel') }}
                            </div>
                            <div class="success-description">
                                {{ __('Your payment has been canceled, and the transaction has been terminated.') }}
                            </div>
                            <div class="order-details">
                                <div class="order-number-label">{{ __('Order Id') }}</div>
                                <div class="order-number">{{ $order_id }}</div>
                            </div>
                            <div class="order-footer">{{ __('You can close this page!') }}</div>
                        </div>
                        <div class="jagged-edge"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
