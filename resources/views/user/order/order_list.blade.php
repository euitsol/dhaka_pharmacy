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
                        <option selected>Last 5 orders</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
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
                @foreach ($order->order_items as $item)
                    <div class="row">
                        <div class="col-8">
                            <div class="row py-3 px-4">
                                <div class="col-3">
                                    <div class="img">
                                        <img class="w-100" src="{{storage_url($item->product->image)}}" alt="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="product-info">
                                        <h2 class="name" title="{{$item->product->attr_title}}">{{$item->product->name}}</h2>
                                        <h3 class="cat">{{$item->product->pro_sub_cat->name}}</h3>
                                        <h3 class="cat">{{$item->product->pro_cat->name}}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <p class="qty">Qty: <span>{{$item->quantity}}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-end py-3 px-4">
                            <div class="order-status">
                                <div class="btn">
                                    <a href="#">{{$order->od->statusTitle()}}</a>
                                </div>
                                <div class="total">
                                    <p class="total">Total: <span>{{$order->totalPrice}}</span>tk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        
        {{-- <div class="order-row">
            <div class="order-id-row">
                <div class="col">
                    <h3 class="order-num">Order: <span>001120560</span></h3>
                    <p class="date-time">Placed on <span>03 apr 2024 12:45:00</span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="row py-3 px-4">
                        <div class="col-3">
                            <div class="img">
                                <img class="w-100" src="asset/img/ace-plus.png" alt="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="product-info">
                                <h2 class="name">Ace Plus (500mg)</h2>
                                <h3 class="cat">Table</h3>
                                <h3 class="cat">Dhaka Pharma</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <p class="qty">Qty: <span>01</span></p>
                        </div>
                    </div>
                    <div class="row py-3 px-4">
                        <div class="col-3">
                            <div class="img">
                                <img class="w-100" src="asset/img/seclo.png" alt="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="product-info">
                                <h2 class="name">Seclo (500mg)</h2>
                                <h3 class="cat">Table</h3>
                                <h3 class="cat">Dhaka Pharma</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <p class="qty">Qty: <span>01</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-end  py-3 px-4">
                    <div class="order-status">
                        <div class="btn">
                            <a href="#">Delivered</a>
                        </div>
                        <div class="total">
                            <p class="total">Total: <span>1900</span>tk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</section>
@endsection