@extends('frontend.layouts.master')
@section('title', 'Checkout')
@push('css')
    <link rel="stylesheet" href="{{asset('frontend\asset\css\checkout.css')}}">
@endpush
@section('content')
    <div class="row py-5 my-5 main_checkout_wrap">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <form action="{{route('product.order.confirm',encrypt($order_id))}}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{encrypt($order_id)}}">
                    <div class="row">
                        <div class="col-md-8 cart">
                            <div class="title">
                                <div class="row">
                                    <div class="col">
                                        <h4><b>{{__('Your Products')}}</b></h4>
                                    </div>
                                    <div class="col align-self-center text-end text-muted">{{collect($checkItems)->count()}} {{__('items')}}</div>
                                </div>
                            </div>
                            @php
                                $total_price = 0;
                                $total_regular_price = 0;
                                $total_discount = 0;
                            @endphp
                            @foreach ($checkItems as $key=>$cartItem)
                                <div class="row order-item">
                                    <div class="row main align-items-center py-2 px-0">
                                        <div class="col-2"><img class="img-fluid" src="{{storage_url($cartItem['product']->image)}}"></div>
                                        <div class="col-6">
                                            <div class="row" title="{{$cartItem['product']->attr_title}}">{{$cartItem['product']->name}}</div>
                                            <div class="row text-muted">{{$cartItem['product']->pro_sub_cat->name}}</div>
                                            <div class="row text-muted">{{$cartItem['product']->generic->name}}</div>
                                            <div class="row text-muted">{{$cartItem['product']->company->name}}</div>
                                        </div>
                                        <div class="col-2">
                                            @if(isset($cartItem['status']))
                                                @php
                                                    $total_discount += $cartItem['quantity']*(number_format(($cartItem['product']->discount_amount*$cartItem['unit']->quantity),2));
                                                @endphp
                                                <span>1 X {{$cartItem['name']}}</span>
                                            @else
                                                <span>{{$cartItem['quantity']}} X {{$cartItem['name']}}</span>
                                                @php
                                                    $total_discount += $cartItem['quantity']*(number_format(($cartItem['product']->discount_amount*$cartItem['unit']->quantity),2));
                                                @endphp
                                            @endif
                                        </div>
                                        <div class="col-2 text-end">
                                            @php
                                                $single_total_price = (($cartItem['product']->discountPrice() * $cartItem['unit']->quantity)*$cartItem['quantity']);
                                                $single_regular_price = (($cartItem['product']->price * $cartItem['unit']->quantity)*$cartItem['quantity']);
                                                $total_price +=$single_total_price;
                                                $total_regular_price +=$single_regular_price;
                                            @endphp
                                            @if(productDiscountPercentage($cartItem['product']->id))
                                                <span class="text-danger me-2"><del>{!! get_taka_icon() !!} {{number_format(($single_regular_price), 2)}}</del></span>
                                            @endif
                                            <span> {!! get_taka_icon() !!} </span><span>{{number_format($single_total_price,2)}}</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row order-item">
                                <div class="row main align-items-center py-2 px-0">
                                    <div class="col mb-2">{{__('Total Item')}} ( {{count($checkItems)}} )</div>
                                    <div class="col text-end">
                                        <span>{{__('Sub-total  ')}}</span>
                                        @if($total_regular_price !== $total_price)
                                            <span class="text-danger mx-2"><del>{!! get_taka_icon() !!} {{number_format(($total_regular_price), 2)}}</del></span>
                                        @endif
                                        <span>{!! get_taka_icon() !!} {{number_format($total_price,2)}}</span> 
                                        
                                    </div>
                                </div>
                            </div>


                            <div class="back-to-shop"><a href="{{route('category.products')}}">&leftarrow; <span class="text-muted">{{__('Back to
                                    shop')}}</span></a>
                            </div>
                        </div>
                        <div class="col-md-4 summary">
                            <div>
                                <h5><b>{{__('Order Summary')}}</b></h5>
                            </div>
                            <hr>
                            <div class="row">

                                    <p class="p-0">{{__('Shipping')}}</p>
                                    <select name="delivery_type">
                                        <option class="text-muted" value="normal">{{__('Normal-Delivery')}} </option>
                                        <option class="text-muted" value="standard">{{__('Standard-Delivery')}} </option>
                                    </select>
                                    {{-- <p>{{__('GIVE PROMO CODE')}}</p>
                                    <input id="code" placeholder="Enter your code"> --}}
                                    <p>{{__('Address')}}</p>
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" value="1" style="width: 1em" type="radio" name="address_id" id="address1" checked>
                                        <label class="form-check-label ms-2" for="address1">
                                        Default Address (<span> {!! get_taka_icon() !!} </span> <span> 10 </span>)
                                        </label>
                                    </div>
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" value="2" style="width: 1em" type="radio" name="address_id" id="address2">
                                        <label class="form-check-label ms-2" for="address2">
                                        Address -1 (<span> {!! get_taka_icon() !!} </span> <span> 20 </span>)
                                        </label>
                                    </div>
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" value="3" style="width: 1em" type="radio" name="address_id" id="address3">
                                        <label class="form-check-label ms-2" for="address3">
                                        Address -2 (<span> {!! get_taka_icon() !!} </span> <span> 30 </span>)
                                        </label>
                                    </div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{__('Discount')}}</div>
                                <div class="col text-end "><span> {!! get_taka_icon() !!} </span> <span>{{number_format($total_discount,2)}}</span></div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{__('Sub-total')}}</div>
                                <div class="col text-end ">
                                    @if($total_regular_price !== $total_price)
                                            <span class="text-danger mx-2"><del>{!! get_taka_icon() !!} {{number_format(($total_regular_price), 2)}}</del></span>
                                    @endif
                                    <span> {!! get_taka_icon() !!} {{number_format($total_price,2)}}</span>
                                </div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{__('Delivery Fee')}}</div>
                                <div class="col text-end "><span> {!! get_taka_icon() !!} </span> <span>{{number_format($delivery_fee,2)}}</span></div>
                            </div>
                            <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                                <div class="col ps-0">{{__('Total Price')}}</div>
                                <div class="col text-end "><span> {!! get_taka_icon() !!} </span> <span>{{number_format(($total_price + number_format($delivery_fee,2)),2) }}</span></div>
                            </div>

                            <div class="row align-items-center atc_functionality">
                                <div class="item_units col">
                                    <div class="form-group my-1 boxed">
                                        <input type="radio" class="unit_quantity" id="android-1" name="payment_method" value="bkash" checked>
                                        <label for="android-1">
                                            <img style="object-fit: cover" src="{{asset('frontend/asset/img/bkash.png')}}">
                                        </label>
                                        <input type="radio" class="unit_quantity" id="android-2" name="payment_method" value="nogod">
                                        <label for="android-2">
                                            <img style="object-fit: cover" src="{{asset('frontend/asset/img/nogod.png')}}">
                                        </label>
                                        <input type="radio" class="unit_quantity" id="android-3" name="payment_method" value="roket">
                                        <label for="android-3">
                                            <img style="object-fit: cover" src="{{asset('frontend/asset/img/roket.png')}}">
                                        </label>
                                        <input type="radio" class="unit_quantity" id="android-4" name="payment_method" value="ssl">
                                        <label for="android-4">
                                            <img src="{{asset('frontend/asset/img/ssl.jpg')}}" style="object-fit: cover">
                                        </label>
                                    </div>
                                </div>
                                <button class="btn" type="submit">{{__('CONFIRM ORDER')}}</button>
                            </div>
                            
                            
                        </div>
                    </div>
                </form>

            </div>


        </div>
    </div>
    </div>
@endsection
