@extends('user.layouts.master', ['pageSlug' => 'order'])

@section('title', 'Dashboard')
@section('content')
<section class="my-order-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="page-title">
                    <h3>My Order</h3>
                </div>
                <div class="show-order d-flex align-items-center">
                    <h4 class="me-2">Show:</h4>
                    <select class="form-select" aria-label="Default select example">
                        <option value="all">All orders</option>
                        <option value="5">Last 5 orders</option>
                        <option value="7">Last 7 days</option>
                        <option value="30">Last 30 days</option>
                    </select>
                </div>
            </div>
        </div>
        @foreach ($orders as $order)
            <div class="order-row">
                <div class="order-id-row">
                    <div class="col">
                        <h3 class="order-num">Order: <span>{{$order->order_id}}</span></h3>
                        <p class="date-time">Placed on <span>{{date('d M Y h:m:s'),strtotime($order->created_at)}}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                            @foreach ($order->order_items as $item)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row py-3 px-4">
                                            <div class="col-3">
                                                <div class="img">
                                                    <img class="w-100" src="{{storage_url($item->product->image)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="product-info">
                                                    <h2 class="name" title="{{$item->product->attr_title}}">{{$item->product->name}}</h2>
                                                    <h3 class="cat">{{$item->product->pro_sub_cat->name}}</h3>
                                                    <h3 class="cat">{{$item->product->pro_cat->name}}</h3>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <p class="qty">Qty: <span>{{$item->quantity}}</span></p>
                                            </div>
                                            <div class="col-2">
                                                @if($order->od)
                                                    <span class="{{$order->od->statusBg()}}">{{$order->od->statusTitle()}}</span>
                                                @else
                                                    <span class="badge bg-info">{{__('Pending')}}</span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center py-3 px-4">
                            <div class="order-status">
                                <div class="btn">
                                    @if($order->od)
                                        <a href="#">{{__('Details')}}</a>
                                    @else
                                        <a href="#" class="text-danger">{{__("Cancel")}}</a>
                                    @endif
                                    
                                </div>
                                <div class="total">
                                    <p class="total">Total: <span>{{$order->totalPrice}}</span>tk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        @endforeach
    </div>
</section>
@endsection