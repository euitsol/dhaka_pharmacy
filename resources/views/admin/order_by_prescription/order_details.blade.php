@extends('admin.layouts.master', ['pageSlug' => 'ubp_' . $order->obp->statusTitle()])
@section('title', 'Order Details')
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
@endpush
@section('content')
    <div class="order_details_wrap">
        <div class="row px-3">
            <div class="card px-0">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-7 ">
                            <div class="card ">
                                <div class="card-header">
                                    <div class="row justify-content-between mb-4">
                                        <div class="col-auto">
                                            <h4 class="color-1 mb-0">{{ __('Order Items') }}</h4>
                                        </div>
                                        <div class="col-auto  "> {{ __('Order Status :') }} <span
                                                class="{{ $order->statusBg() }}">{{ $order->statusTitle() }}</span></div>
                                    </div>
                                </div>
                                <div class="card-body order_items">
                                    <div class="row">
                                        @foreach ($order->products as $product)
                                            <div class="col-12">
                                                <div class="card card-2">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="sq align-self-center "> <img
                                                                    class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                                    src="{{ storage_url($product->image) }}" width="135"
                                                                    height="135" /> </div>
                                                            <div class="media-body my-auto text-center">
                                                                <div class="row  my-auto flex-column flex-md-row px-3">
                                                                    <div class="col my-auto">
                                                                        <h6 class="mb-0 text-start">
                                                                            {{ $product->name }}</h6>
                                                                    </div>
                                                                    <div class="col-auto my-auto">
                                                                        <small>{{ $product->pro_cat->name }} </small>
                                                                    </div>
                                                                    <div class="col my-auto"> <small>{{ __('Qty :') }}
                                                                            {{ $product->pivot->quantity }}</small></div>
                                                                    <div class="col my-auto"> <small>{{ __('Pack :') }}
                                                                            {{ $product->pivot->unit->name ?? 'Piece' }}</small>
                                                                    </div>
                                                                    <div class="col my-auto">
                                                                        @if ($product->totalPrice != $product->totalDiscountPrice)
                                                                            <h6 class="mb-0 text-end">
                                                                                <span class="text-danger">
                                                                                    <del>
                                                                                        {!! get_taka_icon() !!}
                                                                                        {{ number_format(ceil($product->totalPrice)) }}
                                                                                    </del>
                                                                                </span>
                                                                            </h6>
                                                                        @endif
                                                                        <h6 class="mb-0 text-end">
                                                                            <span>
                                                                                {!! get_taka_icon() !!}
                                                                                {{ number_format(ceil($product->totalDiscountPrice)) }}
                                                                            </span>
                                                                        </h6>
                                                                    </div>
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
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row mb-3">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <h4 class="color-1 mb-0">{{ __('Order Details') }}</h4>
                                            <div class="buttons">
                                                @include('admin.partials.button', [
                                                    'routeName' => 'om.order.order_distribution',
                                                    'className' => 'btn-primary',
                                                    'params' => encrypt($order->id),
                                                    'label' => 'Distribute',
                                                ])
                                                @include('admin.partials.button', [
                                                    'routeName' => 'obp.obp_list',
                                                    'className' => 'btn-primary',
                                                    'params' => $order->obp->statusTitle(),
                                                    'label' => 'Back',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body order_details">

                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>{{ __('Order ID') }}</th>
                                                    <td>:</td>
                                                    <td>{{ $order->order_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Delivery Address') }}</th>
                                                    <td>:</td>
                                                    <td>{!! optional($order->address)->address !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Order Date') }}</th>
                                                    <td>:</td>
                                                    <td>{{ timeFormate($order->created_at) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Order Type') }}</th>
                                                    <td>:</td>
                                                    <td>{{ $order->orderType() }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Order Generated By') }}</th>
                                                    <td>:</td>
                                                    <td>{{ $order->creater ? $order->creater->name : $order->customer->name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Total Price') }}</th>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{!! get_taka_icon() !!}
                                                            {{ number_format(ceil($order->totalPrice)) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Discount') }}</th>
                                                    <td>:</td>
                                                    <td><span>{!! get_taka_icon() !!}
                                                            {{ number_format(ceil($order->totalPrice - $order->totalDiscountPrice)) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Sub Total') }}</th>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{!! get_taka_icon() !!}
                                                            {{ number_format(ceil($order->totalDiscountPrice)) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Delivery Fee') }}</th>
                                                    <td>:</td>
                                                    <td>{!! get_taka_icon() !!}{{ number_format(ceil($order->delivery_fee)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Payable Amount') }}</th>
                                                    <td>:</td>
                                                    <th>
                                                        <span>{!! get_taka_icon() !!}
                                                        </span>{{ number_format(ceil($order->totalDiscountPrice + $order->delivery_fee)) }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Order Generated BY') }}</th>
                                                    <td>:</td>
                                                    <th>{{ $order->creater->name }}</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer col-md-12">
                    <div class="jumbotron-fluid">
                        <div class="row justify-content-between ">
                            <div class="col-auto my-auto ">
                                <h2 class="mb-0 font-weight-bold">{{ __('TOTAL AMOUNT') }}</h2>
                            </div>
                            <div class="col-auto my-auto ml-auto">
                                <h1 class="display-3 ">{!! get_taka_icon() !!}
                                    {{ number_format(ceil($order->totalDiscountPrice + $order->delivery_fee)) }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var order_details_height = $('.order_details').height();
            $('.order_items').height(order_details_height + 'px');
        });
    </script>
@endpush
