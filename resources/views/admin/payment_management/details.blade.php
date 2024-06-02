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
                                                    'params'=>strtolower($payment->statusTitle()),
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
                                                <th>{{__('Customer Name')}}</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->name}}</td>
                                                <th>{{__('Customer Phone')}}</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Customer Address')}}</th>
                                                <td>:</td>
                                                <td>{!! optional($payment->order->address)->address !!}</td>
                                                <th>{{__('Order ID')}}</th>
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
                                                <th>{{__('Transaction Date')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['tran_date']  ?? '--'}}</td>
                                                <th>{{__('Transaction ID')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['tran_id']  ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Total Price')}}</th>
                                                <td>:</td>
                                                <td>
                                                    <span>{!! get_taka_icon() !!} {{$totalRegularPrice}}</span>
                                                </td>
                                                <th>{{__('Discount')}}</th>
                                                <td>:</td>
                                                <td><span>{!! get_taka_icon() !!} {{$totalDiscount}}</span></td> 
                                            </tr>
                                            <tr>
                                                <th>{{__('Sub Total')}}</th>
                                                <td>:</td>
                                                <td>
                                                    <span>{!! get_taka_icon() !!} {{$subTotalPrice}}</span>
                                                </td>
                                                <th>{{__('Delivery Charges')}}</th>
                                                <td>:</td>
                                                <td>{!! get_taka_icon() !!}{{number_format(ceil($payment->order->delivery_fee))}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <th>{{__('Order Price')}}</th>
                                                <td>:</td>
                                                <td>{!! get_taka_icon() !!}{{$totalPrice}}</td>
                                                <th>{{__('Card Type')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_type'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Bank Tran ID')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['bank_tran_id'] ?? '--'}}</td>
                                                <th>{{__('Status')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['status'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Currency')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['currency'] ?? '--'}}</td>
                                                <th>{{__('Card Issuer')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Card Brand')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_brand'] ?? '--'}}</td>
                                                <th>{{__('Card Sub Brand')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_sub_brand'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Country')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer_country'] ?? '--'}}</td>
                                                <th>{{__('Country Code')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer_country_code'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Store ID')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['store_id'] ?? '--'}}</td>
                                                <th>{{__('Store Amount')}}</th>
                                                <td>:</td>
                                                <td>{!! isset(json_decode($payment->details,true)['store_amount']) ? get_taka_icon(). number_format(json_decode($payment->details,true)['store_amount'],2) : '0.00' !!}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Currency Rate')}}</th>
                                                <td>:</td>
                                                <td>{{isset(json_decode($payment->details,true)['currency_rate']) ? number_format(json_decode($payment->details,true)['currency_rate'],2) : ''}}</td>
                                                <th>{{__('Currency Type')}}</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['currency_type'] ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('Payment Status')}}</th>
                                                <td>:</td>
                                                <th><span class="{{$payment->statusBg()}}">{{$payment->statusTitle()}}</span></th>
                                                <th>{{__('Payable Amount')}}</th>
                                                <td>:</td>
                                                <th><span>{!! get_taka_icon() !!} </span>{{number_format(ceil($payment->amount))}}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="jumbotron-fluid">
                                    <div class="row justify-content-between ">
                                        <div class="col-auto my-auto "><h2 class="mb-0 font-weight-bold">{{__('PAID AMOUNT')}}</h2></div>
                                        <div class="col-auto my-auto ml-auto"><h1 class="display-3 ">{!! get_taka_icon() !!} {{isset(json_decode($payment->details,true)['amount']) ? number_format(ceil(json_decode($payment->details,true)['amount'])) : '--'}}</h1></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            



@endsection
