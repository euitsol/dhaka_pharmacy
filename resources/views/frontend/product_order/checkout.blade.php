@extends('frontend.layouts.master')
@section('title', 'Home')

@push('css')
    <style>
        .main_wrap {
            height: 100%;
            vertical-align: middle;
            display: flex;
            font-family: sans-serif;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .main_wrap .title {
            margin-bottom: 5vh;
        }
        .main_wrap .order-item {
            border-bottom: 1px solid #dee2e6;
        }
        .main_wrap .order-item:first-child{
            border-top: 1px solid #dee2e6;
        }
        .main_wrap .order-item:last-child{
            border-bottom: 0;
        }

        .main_wrap .boxed label {
            display: inline-block;
            width: 50px;
            border: solid 2px #ccc;
            transition: all 0.3s;
        }

        .main_wrap .boxed input[type="radio"] {
            display: none;
        }

        .main_wrap .boxed input[type="radio"]:checked+label {
            border: solid 2px green;
        }
        .main_wrap .boxed img {
            height: 45px;
            width: 45px;
            padding: 3px;
            object-fit: contain;
        }
        

        .card {
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 1rem;
            border: transparent;
            background: #ddd;
        }

        @media(max-width:767px) {
            .card {
                margin: 3vh auto;
            }
        }

        .main_wrap .cart {
            background-color: #fff;
            padding: 4vh 5vh;
            border-bottom-left-radius: 1rem;
            border-top-left-radius: 1rem;
        }

        @media(max-width:767px) {
            .main_wrap .cart {
                padding: 4vh;
                border-bottom-left-radius: unset;
                border-top-right-radius: 1rem;
            }
        }

        .main_wrap .summary {
            background-color: #ddd;
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
            padding: 30px;
            color: rgb(65, 65, 65);
        }

        @media(max-width:767px) {
            .main_wrap .summary {
                border-top-right-radius: unset;
                border-bottom-left-radius: 1rem;
            }
        }

        .main_wrap .summary .col-2 {
            padding: 0;
        }

        .main_wrap .summary .col-10 {
            padding: 0;
        }

        .main_wrap.row {
            margin: 0;
        }

        .main_wrap .title b {
            font-size: 1.5rem;
        }

        .main_wrap .main {
            margin: 0;
            width: 100%;
        }

        .main_wrap a {
            padding: 0 1vh;
        }

        .main_wrap .close {
            margin-left: auto;
            font-size: 0.7rem;
        }

        .main_wrap img {
            width: 3.5rem;
        }

        .main_wrap .back-to-shop {
            margin-top: 4.5rem;
        }

        .main_wrap h5 {
            margin-top: 4vh;
        }

        .main_wrap hr {
            margin-top: 1.25rem;
        }


        .main_wrap select {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1.5vh 1vh;
            margin-bottom: 4vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247);
        }

        .main_wrap input {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1vh;
            margin-bottom: 4vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247);
        }
        

        .main_wrap input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        .main_wrap .btn {
            background-color: #000;
            border-color: #000;
            color: white;
            width: 100%;
            font-size: 0.7rem;
            margin-top: 4vh;
            padding: 1vh;
            border-radius: 0;
        }

        .main_wrap .btn:focus {
            box-shadow: none;
            outline: none;
            box-shadow: none;
            color: white;
            -webkit-box-shadow: none;
            -webkit-user-select: none;
            transition: none;
        }

        .main_wrap .btn:hover {
            color: white;
        }

        .main_wrap a {
            color: black;
        }

        .main_wrap a:hover {
            color: black;
            text-decoration: none;
        }

        .main_wrap #code {
            background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253), rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: center;
        }
    </style>
@endpush

@section('content')
    <div class="row py-5 my-5">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="row main_wrap">
                    <div class="col-md-8 cart">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    <h4><b>{{__('Your Products')}}</b></h4>
                                </div>
                                <div class="col align-self-center text-end text-muted">{{collect($checkItems)->count()}} items</div>
                            </div>
                        </div>
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach ($checkItems as $cartItem)
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
                                        <span>1 X {{$cartItem['quantity']}}</span>
                                    </div>
                                    <div class="col-2 text-end">
                                        @php
                                            $single_total_price = number_format(($cartItem['quantity'] * $cartItem['product']->price),2);
                                            $total_price +=$single_total_price;
                                        @endphp
                                        <span> &#2547; </span><span>{{$single_total_price}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row order-item">
                            <div class="row main align-items-center py-2 px-0">
                                <div class="col mb-2">{{__('Total Item')}} ( {{optional($checkItems)->count()}} )</div>
                                <div class="col text-end"><span>{{__('Sub-total')}}  &#2547; </span> <span>{{$total_price}}</span></div>
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
                            <form>
                                <p>{{__('SHIPPING')}}</p>
                                <select>
                                    <option class="text-muted">{{__('Normal-Delivery-')}} <span> &#2547; </span> <span> 25 </span></option>
                                    <option class="text-muted">{{__('Standard-Delivery-')}} <span> &#2547; </span> <span> 50 </span></option>
                                </select>
                                <p>{{__('GIVE PROMO CODE')}}</p>
                                <input id="code" placeholder="Enter your code">
                                <p>{{__('ADDRESS')}}</p>
                                  <div class="form-check ms-2">
                                    <input class="form-check-input" style="width: 1em" type="radio" name="address" id="address1" checked>
                                    <label class="form-check-label ms-2" for="address1">
                                      Default Address
                                    </label>
                                  </div>
                                  <div class="form-check ms-2">
                                    <input class="form-check-input" style="width: 1em" type="radio" name="address" id="address2">
                                    <label class="form-check-label ms-2" for="address2">
                                      Address -1
                                    </label>
                                  </div>
                                  <div class="form-check ms-2">
                                    <input class="form-check-input" style="width: 1em" type="radio" name="address" id="address3">
                                    <label class="form-check-label ms-2" for="address3">
                                      Address -2
                                    </label>
                                  </div>
                            </form>
                        </div>
                        <div class="row py-2 px-0" style="border-top: 1px solid rgba(0,0,0,.1);">
                            <div class="col ps-0">{{__('TOTAL PRICE')}}</div>
                            <div class="col text-end "><span> &#2547; </span> <span>{{$total_price}}</span></div>
                        </div>
                        <div class="row align-items-center atc_functionality">
                            <div class="item_units col">
                                <div class="form-group my-1 boxed">
                                    <input type="radio" class="unit_quantity" id="android-1" name="payment_method" value="1" checked>
                                    <label for="android-1">
                                        <img src="{{asset('frontend/asset/img/bkash.png')}}">
                                    </label>
                                    <input type="radio" class="unit_quantity" id="android-2" name="payment_method" value="1">
                                    <label for="android-2">
                                        <img src="{{asset('frontend/asset/img/nogod.png')}}">
                                    </label>
                                    <input type="radio" class="unit_quantity" id="android-3" name="payment_method" value="1">
                                    <label for="android-3">
                                        <img src="{{asset('frontend/asset/img/roket.png')}}">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn">{{__('CONFIRM ORDER')}}</button>
                    </div>
                </div>

            </div>


        </div>
    </div>
    </div>
@endsection
