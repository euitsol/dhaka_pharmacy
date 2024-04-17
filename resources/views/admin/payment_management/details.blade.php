@extends('admin.layouts.master', ['pageSlug' => 'payment_details'])
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
</style>
    
@endpush
@section('content')
<div class="order_details_wrap">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-auto"> <h6 class="color-1 mb-0 change-color">Payment Details</h6> </div>
                                </div>
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
                                                        <a class="btn btn-sm btn-success" href="{{route('om.order.order_details',$payment->order_id)}}">{{$payment->order->order_id}}</a>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Transaction Date</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['tran_date']  ?? ''}}</td>
                                                <th>Transaction ID</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['tran_id']  ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>:</td>
                                                <td><span>&#2547; </span>{{count($payment_items)*2}}</td>
                                                <th>Sub Total</th>
                                                <td>:</td>
                                                <td><span>&#2547; </span>{{number_format($totalPrice,2)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Charges</th>
                                                <td>:</td>
                                                <td>Free</td>
                                                <th>Card Type</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_type'] ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Bank Tran ID</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['bank_tran_id'] ?? ''}}</td>
                                                <th>Status</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['status'] ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Currency</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['currency'] ?? ''}}</td>
                                                <th>Card Issuer</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer'] ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Card Brand</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_brand'] ?? ''}}</td>
                                                <th>Card Sub Brand</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_sub_brand'] ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer_country'] ?? ''}}</td>
                                                <th>Country Code</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['card_issuer_country_code'] ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Store ID</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['store_id'] ?? ''}}</td>
                                                <th>Store Amount</th>
                                                <td>:</td>
                                                <td>{{isset(json_decode($payment->details,true)['store_amount']) ? number_format(json_decode($payment->details,true)['store_amount'],2) : '0.00'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Currency Rate</th>
                                                <td>:</td>
                                                <td>{{number_format(json_decode($payment->details,true)['currency_rate'],2)}}</td>
                                                <th>Currency Type</th>
                                                <td>:</td>
                                                <td>{{json_decode($payment->details,true)['currency_type'] ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Payable Amount</th>
                                                <td>:</td>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                                <th>{{number_format(($payment->amount),2)}}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="jumbotron-fluid">
                                    <div class="row justify-content-between ">
                                        <div class="col-auto my-auto "><h2 class="mb-0 font-weight-bold">PAID AMOUNT</h2></div>
                                        <div class="col-auto my-auto ml-auto"><h1 class="display-3 ">&#2547; {{number_format((json_decode($payment->details,true)['amount']),2)}}</h1></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            



@endsection
