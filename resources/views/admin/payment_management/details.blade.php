@extends('admin.layouts.master', ['pageSlug' => 'payment_details'])
@push('css')
    <link rel="stylesheet" href="{{asset('admin/css/ordermanagement.css')}}">
@endpush
@section('content')
<div class="order_details_wrap">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row mb-3">
                                    <div class="col-12 d-flex justify-content-between align-items-center"> 
                                        <h4 class="color-1 mb-0">{{__('Payment Details')}}</h4> 
                                        @include('admin.partials.button', [
                                                    'routeName' => 'pym.payment.payment_list',
                                                    'className' => 'btn-primary',
                                                    'params'=>strtolower($payment->statusTitle($payment->status)),
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
                                                <th>Customer Name</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->name}}</td>
                                                <th>Customer Phone</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Address</th>
                                                <td>:</td>
                                                <td>Mirpur-10, Dhaka</td>
                                                <th>Order ID</th>
                                                <td>:</td>
                                                <td>
                                                    @if (!auth()->user()->can('order_details'))
                                                        {{$payment->order->order_id}}
                                                    @else
                                                        <a class="btn btn-sm btn-success" href="{{route('om.order.order_details',encrypt($payment->order_id))}}">{{$payment->order->order_id}}</a>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Transaction Date</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['tran_date']  ?? '--'}}</td>
                                                <th>Transaction ID</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['tran_id']  ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>:</td>
                                                <td><span>&#2547; {{number_format($totalDiscount,2)}}</span></td>
                                                <th>Sub Total</th>
                                                <td>:</td>
                                                <td>
                                                    <span>&#2547; {{number_format($totalPrice,2)}}</span>
                                                    @if ($totalRegularPrice !== $totalPrice)
                                                        <span class="text-danger ms-2"><del>&#2547; {{number_format(($totalRegularPrice), 2)}}</del></span> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Charges</th>
                                                <td>:</td>
                                                <td>Free</td>
                                                <th>Card Type</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_type'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Bank Tran ID</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['bank_tran_id'] ?? '--'}}</td>
                                                <th>Status</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['status'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Currency</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['currency'] ?? '--'}}</td>
                                                <th>Card Issuer</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Card Brand</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_brand'] ?? '--'}}</td>
                                                <th>Card Sub Brand</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_sub_brand'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer_country'] ?? '--'}}</td>
                                                <th>Country Code</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer_country_code'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Store ID</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['store_id'] ?? '--'}}</td>
                                                <th>Store Amount</th>
                                                <td>:</td>
                                                <td>{!! isset(json_decode($payment->details,true)['store_amount']) ? "&#2547; ". number_format(json_decode($payment->details,true)['store_amount'],2) : '0.00' !!}</td>
                                            </tr>
                                            <tr>
                                                <th>Currency Rate</th>
                                                <td>:</td>
                                                <td>{{isset(json_decode($payment->details,true)['currency_rate']) ? number_format(json_decode($payment->details,true)['currency_rate'],2) : ''}}</td>
                                                <th>Currency Type</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['currency_type'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Status</th>
                                                <td>:</td>
                                                <th><span class="{{$payment->statusBg()}}">{{$payment->statusTitle()}}</span></th>
                                                <th>Payable Amount</th>
                                                <td>:</td>
                                                <th><span>&#2547; </span>{{number_format(($payment->amount),2)}}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="jumbotron-fluid">
                                    <div class="row justify-content-between ">
                                        <div class="col-auto my-auto "><h2 class="mb-0 font-weight-bold">PAID AMOUNT</h2></div>
                                        <div class="col-auto my-auto ml-auto"><h1 class="display-3 ">&#2547; {{isset(json_decode($payment->details,true)['amount']) ? number_format((json_decode($payment->details,true)['amount']),2) : '--'}}</h1></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            



@endsection
