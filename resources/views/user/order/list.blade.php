@extends('user.layouts.master', ['pageSlug' => 'order'])
@section('title', 'Order List')
@section('content')
    <section class="my-order-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h3>{{ __(isset($status) ? slugToTitle($status->title()) : 'My Orders') }}</h3>
                    </div>
                    <div class="show-order d-flex align-items-center">
                        <h4 class="me-2">{{ __('Show:') }}</h4>
                        <select class="form-select order_filter" aria-label="Default select example">
                            <option value="all" {{ $filterValue == 'all' ? 'selected' : '' }}>{{ __('All orders') }}
                            </option>
                            <option value="5" {{ $filterValue == '5' ? 'selected' : '' }}>{{ __('Last 5 orders') }}
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
                                    <h3 class="order-num">{{ __('Order: ') }}<span>{{ $order->order_id }}</span></h3>
                                    <p class="date-time">{{ __('Placed on ') }}<span>{{ $order->place_date }}</span></p>
                                </div>
                                <div class="col-2 text-end">
                                    <span class="{{ $order->statusBg }}">{{ __(slugToTitle($order->statusTitle)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                @forelse ($order->products as $product)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row py-3 px-4">
                                                <div class="col-3">
                                                    <div class="img">
                                                        <img class="w-100" src="{{ $product->image }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="product-info">
                                                        <h2 class="name" title="{{ $product->attr_title }}">
                                                            {{ $product->name }}</h2>
                                                        <h3 class="cat">{{ $product->pro_sub_cat->name }}</h3>
                                                        <h3 class="cat">{{ $product->pro_cat->name }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <p class="qty">
                                                        {{ __('Qty: ') }}<span>{{ $product->pivot->quantity }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <div class="col-3 d-flex justify-content-end align-items-center py-3 px-4">
                                <div class="order-status">
                                    <div class="btn">
                                        <a
                                            href="{{ route('u.order.details', encrypt($order->id)) }}">{{ __('Details') }}</a>
                                    </div>
                                    <div class="total">
                                        <p class="total text-center">
                                            {{ __('Total: ') }}<span>{{ $order->totalPrice }}</span>{{ __('tk') }}
                                        </p>
                                    </div>
                                </div>
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
    <script src="{{ asset('user/asset/js/order_list.js') }}"></script>
    <script>
        const myDatas = {
            'status': `{{ $status }}`,
            'url': `{{ route('u.order.list', ['filter' => 'filter_value', 'page' => '1', 'status' => '_status']) }}`,
        };
    </script>
@endpush
