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
<div class="order_details_wrap">
    <div class="row px-3">
        <div class="card px-0">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-7 ">
                        <div class="card ">
                            <div class="card-body order_items">
                                <div class="row justify-content-between mb-3">
                                    <div class="col-auto"> <h6 class="color-1 mb-0 change-color">Order Items</h6> </div>
    
                                    @php
                                        $badgeBg = ($order->status == 1) ? 'badge badge-success' : (($order->status == 0) ? 'badge badge-info' : (($order->status == -1) ? 'badge badge-danger' : (($order->status == -2) ? 'badge badge-warning' : 'badge badge-primary')));
    
                                        $badgeStatus = ($order->status == 1) ? 'Success' : (($order->status == 0) ? 'Pending' : (($order->status == -1) ? 'Failed' : (($order->status == -2) ? 'Cancel' : 'Processing'))); 
    
                                    @endphp
    
                                    <div class="col-auto  "> Order Status : <span class="{{$badgeBg}}">{{$badgeStatus}}</span></div>
                                </div>
                                <div class="row">
                                    @foreach ($order_items as $item)
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
                            <div class="card-body order_details">
                                <div class="row mb-3">
                                    <div class="col-auto"> <h6 class="color-1 mb-0 change-color">Order Details</h6> </div>
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
                                                <td><span>&#2547; </span>{{count($order_items)*2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Sub Total</th>
                                                <td>:</td>
                                                <td><span>&#2547; </span>{{number_format($totalPrice,2)}}</td>
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
                                                    'params' => [$payment->id],
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
        $(document).ready(function(){
            var order_details_height = $('.order_details').height();
            $('.order_items').height(order_details_height + 'px');
        });
    </script>
@endpush
