@extends('admin.layouts.master', ['pageSlug' => 'order_details'])
@push('css')

<style>
    

        .order_details_wrap p {
            font-size: 14px;
            margin-bottom: 7px;

        }

        .order_details_wrap .small {
            letter-spacing: 0.5px !important;
        }

        .order_details_wrap .card-1 {
            box-shadow: 2px 2px 10px 0px rgb(190, 108, 170);
        }

        .order_details_wrap hr {
            background-color: rgba(248, 248, 248, 0.667);
        }


        .order_details_wrap .bold {
            font-weight: 500;
        }

        .order_details_wrap .change-color {
            color: #AB47BC !important;
        }

        .order_details_wrap .card-2 {
            box-shadow: 1px 1px 3px 0px rgb(112, 115, 139);

        }

        .order_details_wrap .fa-circle.active {
            font-size: 8px;
            color: #AB47BC;
        }

        .order_details_wrap .fa-circle {
            font-size: 8px;
            color: #aaa;
        }

        .order_details_wrap .rounded {
            border-radius: 2.25rem !important;
        }
        .order_details_wrap .invoice {
            position: relative;
            top: -70px;
        }

        .order_details_wrap .Glasses {
            position: relative;
            top: -12px !important;
        }

        .order_details_wrap .card-footer {
            background-color: #0093E9;
            background-image: linear-gradient( 288deg,  rgba(0,85,255,1) 1.5%, rgb(4, 56, 115) 91.6% );
        }
        .order_details_wrap .card-footer h2,
        .order_details_wrap .card-footer h1{
            color: #fff;
            font-size: 30px;
        }

        .order_details_wrap h2 {
            color: rgb(78, 0, 92);
            letter-spacing: 2px !important;
        }

        .order_details_wrap .display-3 {
            font-weight: 500 !important;
        }

        @media (max-width: 479px) {
            .order_details_wrap .invoice {
                position: relative;
                top: 7px;
            }

            .order_details_wrap .border-line {
                border-right: 0px solid rgb(226, 206, 226) !important;
            }

        }

        @media (max-width: 700px) {

            .order_details_wrap h2 {
                color: rgb(78, 0, 92);
                font-size: 17px;
            }

            .order_details_wrap .display-3 {
                font-size: 28px;
                font-weight: 500 !important;
            }
        }

        .order_details_wrap .card-footer small {
            letter-spacing: 7px !important;
            font-size: 12px;
        }

        .order_details_wrap .border-line {
            border-right: 1px solid rgb(226, 206, 226)
        }
        .order_items{
            overflow-y: auto;
        }
</style>
    
@endpush
@section('content')
@php
    $badgeBg = ($order->status == 2) ? 'badge badge-success' : (($order->status == 1) ? 'badge badge-info' : (($order->status == 0) ? 'badge badge-secondary' : (($order->status == -1) ? 'badge badge-danger' : (($order->status == -2) ? 'badge badge-warning' : 'badge badge-primary'))));

    $badgeStatus = ($order->status == 2) ? 'Success' : (($order->status == 1) ? 'Pending' : (($order->status == 0) ? 'Initiated' : (($order->status == -1) ? 'Failed' : (($order->status == -2) ? 'Cancel' : 'Processing')))); 
@endphp
<div class="order_details_wrap">
    <div class="row px-3">
        <div class="card px-0">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body order_details">
                                <div class="row mb-3">
                                    <div class="col-12 d-flex justify-content-between align-items-center"> 
                                        <h6 class="color-1 mb-0 change-color">{{__('Order Details')}}</h6> 
                                        @include('admin.partials.button', [
                                                    'routeName' => 'om.order.order_list',
                                                    'className' => 'btn-primary',
                                                    'params'=>strtolower($badgeStatus),
                                                    'label' => 'Back',
                                                ])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Customer Name</th>
                                                <td>:</td>
                                                <td>{{$order->customer->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Phone</th>
                                                <td>:</td>
                                                <td>{{$order->customer->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Email</th>
                                                <td>:</td>
                                                <td>{{$order->customer->email ?? "--"}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Address</th>
                                                <td>:</td>
                                                <td>Mirpur-10, Dhaka</td>
                                            </tr>
                                            <tr>
                                                <th>Order ID</th>
                                                <td>:</td>
                                                <td>{{$order->order_id}}</td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td>:</td>
                                                <td>{{$order->created_date()}}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>:</td>
                                                <td><span>&#2547; {{number_format($totalDiscount,2)}}</span></td>
                                            </tr>
                                            <tr>
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
                                            </tr>
                                            <tr>
                                                <th>Payable Amount</th>
                                                <td>:</td>
                                                <th><span>&#2547; </span>{{number_format($totalPrice,2)}}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('om.order.order_distribution',encrypt($order->id))}}" method="POST" class="px-0">
                        @csrf
                        <div class="col-md-12 ">
                            <div class="card ">
                                <div class="card-body order_items">
                                    <div class="row justify-content-between mb-3">
                                        <div class="col-auto"> <h6 class="color-1 mb-0 change-color">Order Distribution</h6> </div>
                                        <div class="col-auto  "> Order Status : <span class="{{$badgeBg}}">{{$badgeStatus}}</span></div>
                                    </div>
                                        <div class="row">
                                            @foreach ($order_items as $key=>$item)
                                            <div class="col-12">
                                                    <input type="hidden" name="datas[{{$key}}][cart_id]" value="{{$item->id}}">
                                                    <div class="card card-2 mb-3">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-9">
                                                                    <div class="media">
                                                                        <div class="sq align-self-center "> <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{storage_url($item->product->image)}}" width="135" height="135" /> </div>
                                                                        <div class="media-body my-auto text-center">
                                                                            <div class="row  my-auto flex-column flex-md-row px-3">
                                                                                <div class="col my-auto"> <h6 class="mb-0 text-start">{{$item->product->name}}</h6>  </div>
                                                                                <div class="col-auto my-auto"> <small>{{$item->product->pro_cat->name}} </small></div>
                                                                                <div class="col my-auto"> <small>Qty : {{$item->quantity}}</small></div>
                                                                                <div class="col my-auto"> <small>Pack : {{$item->unit->name ?? 'Piece'}}</small></div>
                                                                                <div class="col my-auto">
                                                                                    <h6 class="mb-0 text-end">
                                                                                        @if (productDiscountPercentage($item->product->id))
                                                                                        <span class="text-danger"><del>&#2547; {{number_format((($item->product->regular_price*$item->unit->quantity) * $item->quantity), 2)}}</del></span> 
                                                                                        @endif
                                                                                    </h6>
                                                                                    <h6 class="mb-0 text-end">
                                                                                        <span>&#2547; {{number_format((($item->product->price*($item->unit->quantity ?? 1)) * $item->quantity), 2)}}</span> 
                                                                                    </h6>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <select name="datas[{{$key}}][pharmacy_id]" class="form-control {{ $errors->has('datas.'.$key.'.pharmacy_id') ? ' is-invalid' : '' }}">
                                                                            <option selected hidden>Select Pharmacy</option>
                                                                            @foreach ($pharmacies as $pharmacy)
                                                                                <option @if((isset($order_distribution->odps) && $order_distribution->odps[$key]->pharmacy_id == $pharmacy->id) || (old('datas.'.$key.'.pharmacy_id') == $pharmacy->id)) selected @endif value="{{$pharmacy->id}}">{{$pharmacy->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        
                                                                        @include('alerts.feedback', ['field' => 'datas.'.$key.'.pharmacy_id'])
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                            
                                                
                                            </div>
                                            @endforeach
                                            <div class="col-12">
                                                <div class="row mt-3">
                                                    <div class="form-group col-md-4">
                                                        <label>Payment Type</label>
                                                        <select name="payment_type" class="form-control {{ $errors->has('payment_type') ? ' is-invalid' : '' }}">
                                                            <option selected hidden>Select Payment Type</option>
                                                            <option value="0" {{((isset($order_distribution->payment_type) && $order_distribution->payment_type == 0) || old('payment_type') == 0) ? 'selected' : ''}}>Fix Payment</option>
                                                            <option value="1" {{((isset($order_distribution->payment_type) && $order_distribution->payment_type == 1) || old('payment_type') == 1) ? 'selected' : ''}}>Open Payment</option>
                                                        </select>
                                                        @include('alerts.feedback', ['field' => 'payment_type'])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Distribution Type</label>
                                                        <select name="distribution_type" class="form-control {{ $errors->has('distribution_type') ? ' is-invalid' : '' }}">
                                                            <option selected hidden>Select Distribution Type</option>
                                                            <option value="0" {{((isset($order_distribution->distribution_type) && $order_distribution->distribution_type == 0) || old('distribution_type') == 0) ? 'selected' : ''}}>Normal Distribution</option>
                                                            <option value="1" {{((isset($order_distribution->distribution_type) && $order_distribution->distribution_type == 1) || old('distribution_type') == 1) ? 'selected' : ''}}>Priority Distribution</option>
                                                        </select>
                                                        @include('alerts.feedback', ['field' => 'distribution_type'])
                                                    </div>
                                                    {{-- <div class="form-group col-md-4">
                                                        <select name="prep_time" class="form-control">
                                                            <option selected hidden>Select Prepare Time</option>
                                                            <option value="5m">5 Minute</option>
                                                            <option value="10m">10 Minute</option>
                                                            <option value="15m">15 Minute</option>
                                                            <option value="20m">20 Minute</option>
                                                            <option value="25m">25 Minute</option>
                                                            <option value="30m">30 Minute</option>
                                                            <option value="35m">35 Minute</option>
                                                            <option value="40m">40 Minute</option>
                                                            <option value="45m">45 Minute</option>
                                                            <option value="50m">50 Minute</option>
                                                            <option value="55m">55 Minute</option>
                                                            <option value="1h">1 Houre</option>
                                                        </select>
                                                    </div> --}}
                                                    <div class="form-group col-md-4">
                                                        <label >Prepare Time</label>
                                                        <input type="datetime-local" name="prep_time" value="{{isset($order_distribution->prep_time) ? $order_distribution->prep_time : old('prep_time')}}" class="form-control {{ $errors->has('prep_time') ? ' is-invalid' : '' }}">
                                                        @include('alerts.feedback', ['field' => 'prep_time'])
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label >Note</label>
                                                        <textarea name="note" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}" placeholder="Enter order instraction for pharmacy">{{isset($order_distribution->note) ? $order_distribution->note : old('note')}}</textarea>
                                                        @include('alerts.feedback', ['field' => 'note'])
                                                    </div>
                                                    
                                                    <div class="form-group col-md-12 text-end">
                                                        <input type="submit" value="Distribute" class="btn btn-sm btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        
            <div class="card-footer col-md-12">
                <div class="jumbotron-fluid">
                    <div class="row justify-content-between ">
                        <div class="col-auto my-auto "><h2 class="mb-0 font-weight-bold">TOTAL AMOUNT</h2></div>
                        <div class="col-auto my-auto ml-auto"><h1 class="display-3 ">&#2547; {{number_format($totalPrice,2)}}</h1></div>
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
                            <h4 class="card-title">{{ __("Payments") }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Transaction ID') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            @php
                                $statusBgColor = ($payment->status == 1) ? 'badge badge-success' : (($payment->status == 0) ? 'badge badge-info' : (($payment->status == -1) ? 'badge badge-danger' : (($payment->status == -2) ? 'badge badge-warning' : 'badge badge-primary')));

                                $status = ($payment->status == 1) ? 'Success' : (($payment->status == 0) ? 'Pending' : (($payment->status == -1) ? 'Failed' : (($payment->status == -2) ? 'Cancel' : 'Processing')));
                            @endphp
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $payment->transaction_id }}</td>
                                    <td><span class="{{$statusBgColor}}">{{$status}}</span></td>
                                    <td>{{ $order->created_date() }}</td>

                                    <td> {{ $order->creater_name() }} </td>
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
