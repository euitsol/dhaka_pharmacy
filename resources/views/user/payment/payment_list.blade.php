@extends('user.layouts.master', ['pageSlug' => 'payment'])
@section('title', 'Payment List')
@push('css')
<style>
.my-order-section .order-row .order-status .total {
    font-size: 18px;
    font-weight: 500;
}
</style>
@endpush
@section('content')
<section class="my-order-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="page-title mb-3">
                    <h3>{{ __('My Payments') }}</h3>
                </div>
                <div class="show-order d-flex align-items-center">
                    <h4 class="me-2">{{ __('Show:') }}</h4>
                    <select class="form-select order_filter" aria-label="Default select example">
                        <option value="all" {{ $filterValue == 'all' ? 'selected' : '' }}>{{ __('All payments') }}
                        </option>
                        <option value="7" {{ $filterValue == '7' ? 'selected' : '' }}>{{ __('Last 7 days') }}
                        </option>
                        <option value="15" {{ $filterValue == '15' ? 'selected' : '' }}>{{ __('Last 15 days') }}
                        </option>
                        <option value="30" {{ $filterValue == '30' ? 'selected' : '' }}>{{ __('Last 30 days') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="payment_wrap">
            @forelse ($payments as $payment)
            <div class="order-row">
                <div class="order-id-row border-0 p-4">
                    <div class="row align-items-center" style="position: relative;">
                        <div class="col-lg-4 col-12">
                            <h3 class="order-num">
                                {{ __('Transaction ID: ') }}<span>{{ $payment->transaction_id }}</span>
                            </h3>
                            <p class="date-time my-1">
                                {{ __('Order ID: ') }}<span>{{ $payment->order->order_id }}</span>
                            </p>
                            <p class="date-time">{{ __('Payment Date: ') }}<span>{{ $payment->date }}</span></p>
                        </div>
                        <div class="col-lg-8 col-12 mt-2 mt-lg-0">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-lg-3 col-sm-6 col-12 text-center">
                                    <div class="order-status pe-0">
                                        <div class="total">
                                            <p class="total text-start">
                                                {{ __('Payment Type: ') }}<span>{{ $payment->payment_method }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-12">
                                    <div class="order-status pe-0">
                                        <div class="total">
                                            <p class="total text-start">
                                                {{ __('Total: ') }}<span>{{ number_format(ceil($payment->amount)) }}</span>tk
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 ps-0 ps-sm-3 col-2 col-lg-2 text-md-center text-end">
                                    <span
                                        class="{{ $payment->statusBg() }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $payment->statusTitle())))) }}</span>
                                </div>
                                <div class="col-md-4 mt-2 mt-md-0 col-12 text-start text-md-end d-flex justify-content-md-end justify-content-start">
                                    <div class="order-status payment-btn-main">
                                        <div class="btn p-0">
                                            <a
                                                href="{{ route('u.payment.details', $payment->encrypted_id) }}">{{ __('Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <h3 class="my-5 text-danger text-center">{{ __('Payment Not Found') }}</h3>
            @endforelse
        </div>
        <div class="paginate mt-3">
            {!! $pagination !!}
        </div>

    </div>
</section>
@endsection
@push('js')
<script>
const myDatas = {
    'filter': `{{ $filterValue }}`,
    'url': `{{ route('u.payment.list', ['filter' => 'filter_value', 'page' => '1']) }}`,
    'details_url': `{{ route('u.payment.details', ['param']) }}`,
};
</script>
<script src="{{ asset('user/asset/js/payment_list.js') }}"></script>
@endpush