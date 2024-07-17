@extends('admin.layouts.master', ['pageSlug' => 'order_' . $order->statusTitle()])
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
                                                                                        {{ $product->totalPrice }}
                                                                                    </del>
                                                                                </span>
                                                                            </h6>
                                                                        @endif
                                                                        <h6 class="mb-0 text-end">
                                                                            <span>
                                                                                {!! get_taka_icon() !!}
                                                                                {{ $product->totalDiscountPrice }}
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

                                                @if ($order->status == 1)
                                                    @include('admin.partials.button', [
                                                        'routeName' => 'om.order.order_distribution',
                                                        'className' => 'btn-primary',
                                                        'params' => encrypt($order->id),
                                                        'label' => 'Distribute',
                                                    ])
                                                @endif

                                                @include('admin.partials.button', [
                                                    'routeName' => 'om.order.order_list',
                                                    'className' => 'btn-primary',
                                                    'params' => strtolower($order->statusTitle($order->status)),
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
                                                    <td class="fw-bolder">{{ __('Order ID') }}</td>
                                                    <td>:</td>
                                                    <td>{{ $order->order_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Delivery Address') }}</td>
                                                    <td>:</td>
                                                    <td>{!! optional($order->address)->address !!}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Order Date') }}</td>
                                                    <td>:</td>
                                                    <td>{{ timeFormate($order->created_at) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Order Type') }}</td>
                                                    <td>:</td>
                                                    <td>{{ $order->orderType() }}</td>
                                                </tr>
                                                {{-- <tr>
                                                    <td class="fw-bolder">{{ __('Order Generated By') }}</td>
                                                    <td>:</td>
                                                    <td>{{ $order->creater ? $order->creater->name : $order->customer->name }}
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Total Amount') }}</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{!! get_taka_icon() !!}
                                                            {{ number_format($order->totalPrice, 2) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Discount') }}</td>
                                                    <td>:</td>
                                                    <td><span>{!! get_taka_icon() !!}
                                                            {{ number_format($order->totalPrice - $order->totalDiscountPrice, 2) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Sub Total') }}</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span>{!! get_taka_icon() !!}
                                                            {{ number_format($order->totalDiscountPrice) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Delivery Fee') }}</td>
                                                    <td>:</td>
                                                    <td>{!! get_taka_icon() !!}{{ number_format($order->delivery_fee) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bolder">{{ __('Total Payable Amount') }}</td>
                                                    <td>:</td>
                                                    <td class="fw-bolder"><span>{!! get_taka_icon() !!}
                                                        </span>{{ number_format(ceil($order->totalDiscountPrice + $order->delivery_fee)) }}
                                                    </td>
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
    <div class="payment_details_wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">{{ __('Payments') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Transaction ID') }}</th>
                                    <th>{{ __('Total Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Payment date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->payments as $payment)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->transaction_id }}</td>
                                        <td><span>{!! get_taka_icon() !!}
                                            </span>{{ number_format(ceil($payment->amount)) }}</td>
                                        <td><span class="{{ $payment->statusBg() }}">{{ $payment->statusTitle() }}</span>
                                        </td>
                                        <td>{{ timeFormate($order->created_at) }}</td>
                                        <td>
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'pym.payment.payment_details',
                                                        'params' => [encrypt($payment->id)],
                                                        'target' => '_blank',
                                                        'label' => 'Details',
                                                    ],
                                                ],
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                        </nav>
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
