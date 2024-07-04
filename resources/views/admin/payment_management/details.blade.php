@extends('admin.layouts.master', ['pageSlug' => 'payment_details'])
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
@endpush
@section('content')
    <div class="order_details_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <h4 class="color-1 mb-0">{{ __('Payment Details') }}</h4>
                                @include('admin.partials.button', [
                                    'routeName' => URL::previous(),
                                    'className' => 'btn-primary',
                                    'label' => 'Back',
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th>{{ __('Customer Name') }}</th>
                                        <td>:</td>
                                        <td>{{ $payment->customer->name }}</td>
                                        <th>{{ __('Customer Phone') }}</th>
                                        <td>:</td>
                                        <td>{{ $payment->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Customer Address') }}</th>
                                        <td>:</td>
                                        <td>{!! optional($payment->order->address)->address !!}</td>
                                        <th>{{ __('Order ID') }}</th>
                                        <td>:</td>
                                        <td>
                                            @if (!auth()->user()->can('order_details'))
                                                {{ $payment->order->order_id }}
                                            @else
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('om.order.order_details', encrypt($payment->order_id)) }}">{{ $payment->order->order_id }}</a>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Transaction Date') }}</th>
                                        <td>:</td>
                                        <td>{{ timeFormate($payment->created_at) }}</td>
                                        <th>{{ __('Transaction ID') }}</th>
                                        <td>:</td>
                                        <td>{{ $payment->transaction_id ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Amount') }}</th>
                                        <td>:</td>
                                        <td>
                                            <span>{!! get_taka_icon() !!}
                                                {{ number_format(ceil($payment->amount)) }}</span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="jumbotron-fluid">
                            <div class="row justify-content-between ">
                                <div class="col-auto my-auto ">
                                    <h2 class="mb-0 font-weight-bold">{{ __('PAID AMOUNT') }}</h2>
                                </div>
                                <div class="col-auto my-auto ml-auto">
                                    <h1 class="display-3 ">{!! get_taka_icon() !!}
                                        {{ number_format(ceil($payment->amount)) }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
