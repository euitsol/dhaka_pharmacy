@extends('user.layouts.master', ['pageSlug' => 'order'])
@section('title', 'Order List')
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h3>{{ __(isset($status) ? slugToTitle($status) : 'My Orders') }}</h3>
                    </div>
                    <div class="show-order d-flex align-items-center">
                        <h4 class="me-2">{{ __('Show:') }}</h4>
                        <select class="form-select order_filter" aria-label="Default select example">
                            <option value="all" {{ $filterValue == 'all' ? 'selected' : '' }}>{{ __('All orders') }}
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
            <div class="order_wrap">
                @forelse ($orders as $order)
                    <div class="order-row">
                        <div class="order-id-row">
                            <div class="row">
                                <div class="col-10">
                                    <div class="d-flex">
                                        <div class="text">
                                            <h3 class="order-num">
                                                {{ __('Order: ') }}<span>{{ $order->order_id }}</span>
                                            </h3>
                                            <p class="date-time">
                                                {{ __('Placed on ') }}<span>{{ $order->place_date }}</span>
                                            </p>
                                        </div>
                                        <div class="status ms-3 order-info-section">
                                            <div class="order-status-row d-flex gap-3 align-items-center">
                                                <span class="{{ $order->statusBg }}">{{ __($order->statusTitle) }}</span>
                                                @if (isset($order->otp))
                                                    <p class="fw-bold">{{ __('OTP: ') }}{{ $order->otp }}
                                                    </p>
                                                @endif
                                            </div>
                                            <p class="total p-0">
                                                {{ __('Total Amount: ') }}<span
                                                    class="fw-bold">{{ number_format($order->totalPrice, 2) }}{{ __('tk') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    <div class="order-status">
                                        <div class="btn p-0">
                                            <a
                                                href="{{ route('u.order.details', $order->encrypt_oid) }}">{{ __('Details') }}</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 px-4">
                                @foreach ($order->products as $product)
                                    <div class="row py-3 px-4 align-items-center list-item">
                                        <div class="col-2">
                                            <div class="img">
                                                <img class="w-100" src="{{ $product->image }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="product-info">
                                                <h2 class="name" title="{{ $product->attr_title }}">
                                                    {{ $product->name }}</h2>
                                                <p class="cat">{{ $product->pro_sub_cat->name }}</p>
                                                <p class="cat">{{ $product->generic->name }}</p>
                                                <p class="cat">{{ $product->company->name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <p class="qty">
                                                {{ __('Qty: ') }}<span>{{ $product->pivot->quantity < 10 ? '0' . $product->pivot->quantity : $product->pivot->quantity }}</span>
                                            </p>
                                            <p class="qty">
                                                {{ __('Unit: ') }}<span>{{ $product->pivot->unit->name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <h3 class="my-5 text-danger text-center">{{ __('Order Not Found') }}</h3>
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
            'status': `{{ $status }}`,
            'filter': `{{ $filterValue }}`,
            'url': `{{ route('u.order.list', ['status' => '_status', 'filter' => 'filter_value', 'page' => '1']) }}`,
            'details_route': `{{ route('u.order.details', ['order_id']) }}`,
        };
    </script>
    <script src="{{ asset('user/asset/js/order_list.js') }}"></script>
@endpush
