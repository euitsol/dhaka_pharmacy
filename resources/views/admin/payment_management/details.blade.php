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
    <div class="row px-3">
        <div class="card px-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row justify-content-between mb-3">
                                    <div class="col-auto"> <h6 class="color-1 mb-0 change-color">Order Items</h6> </div>
    
                                    @php
                                        $badgeBg = ($payment->status == 1) ? 'badge badge-success' : (($payment->status == 0) ? 'badge badge-info' : (($payment->status == -1) ? 'badge badge-danger' : (($payment->status == -2) ? 'badge badge-warning' : 'badge badge-primary')));
    
                                        $badgeStatus = ($payment->status == 1) ? 'Success' : (($payment->status == 0) ? 'Pending' : (($payment->status == -1) ? 'Failed' : (($payment->status == -2) ? 'Cancel' : 'Processing'))); 
    
                                    @endphp
    
                                    <div class="col-auto  "> Payment Status : <span class="{{$badgeBg}}">{{$badgeStatus}}</span></div>
                                </div>
                                <div class="row">
                                    @php
                                        $total_price = 0;
                                    @endphp
                                    @foreach ($payment_items as $item)
                                    <div class="col-12">
                                        <div class="card card-2">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="sq align-self-center "> <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{storage_url($item->product->image)}}" width="135" height="135" /> </div>
                                                    <div class="media-body my-auto text-center">
                                                        <div class="row  my-auto flex-column flex-md-row px-3">
                                                            <div class="col my-auto"> <h6 class="mb-0 text-start">{{$item->product->name}}</h6>  </div>
                                                            <div class="col-auto my-auto"> <small>{{$item->product->pro_cat->name}} </small></div>
                                                            <div class="col my-auto"> <small>Qty : {{$item->quantity}}</small></div>
                                                            <div class="col my-auto"><h6 class="mb-0">&#2547; {{number_format(($item->product->price * $item->quantity), 2)}}</h6>
                                                                @php
                                                                    $total_price += $item->product->price * $item->quantity;
                                                                @endphp
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
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-auto"> <h6 class="color-1 mb-0 change-color">Order Details</h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Customer Name</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Phone</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Email</th>
                                                <td>:</td>
                                                <td>{{$payment->customer->email ?? "--"}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Address</th>
                                                <td>:</td>
                                                <td>Mirpur-10, Dhaka</td>
                                            </tr>
                                            <tr>
                                                <th>Order ID</th>
                                                <td>:</td>
                                                <td>{{$payment->order_id}}</td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td>:</td>
                                                <td>{{$payment->created_date()}}</td>
                                            </tr>
                                            <tr>
                                                <th>Sub Total</th>
                                                <td>:</td>
                                                <td><span>&#2547; </span>{{number_format($total_price,2)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>:</td>
                                                <td><span>&#2547; </span>2</td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Charges</th>
                                                <td>:</td>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <th>Payable Amount</th>
                                                <td>:</td>
                                                <th>{{number_format(($total_price-2),2)}}</th>
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
                        <div class="col-auto my-auto "><h2 class="mb-0 font-weight-bold">PAID AMOUNT</h2></div>
                        <div class="col-auto my-auto ml-auto"><h1 class="display-3 ">&#2547; {{number_format(($payment->amount),2)}}</h1></div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
</div>



@endsection
