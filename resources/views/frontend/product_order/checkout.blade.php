@extends('frontend.layouts.master')
@section('title', 'Home')

@push('css')
    <style>
        .checkout_products .image img {
            height: 75px;
            object-fit: cover;
        }
         .checkout_products .details .product_title {
            font-size: 17px;
            color: var(--text-color-black);
        }

        .checkout_products .details p {
            color: var(--text-color-black);
            font-size: .8rem;
            line-height: 1rem;
        }

        .checkout_products .details .product_sub_cat {
            font-size: 1rem;
            color: #959595;
        }

        .checkout_products .input-group .btn {
            height: 100% !important;
        }








        .payment_methods h2 {
            color: #AAAAAA;
        }

        .payment_methods ul {
            list-style: none;
            margin: 0;
            padding: 0;
            overflow: auto;
        }

        .payment_methods ul li {
            color: #AAAAAA;
            display: block;
            position: relative;
            float: left;
            width: 100%;
            height: 100px;
            border-bottom: 1px solid #333;
        }

        .payment_methods ul li input[type=radio] {
            position: absolute;
            visibility: hidden;
        }

        .payment_methods ul li label {
            display: block;
            position: relative;
            font-weight: 300;
            font-size: 1.35em;
            padding: 25px 25px 25px 80px;
            margin: 10px auto;
            height: 30px;
            z-index: 9;
            cursor: pointer;
            -webkit-transition: all 0.25s linear;
        }

        .payment_methods ul li:hover label {
            color: #FFFFFF;
        }

        .payment_methods ul li .check {
            display: block;
            position: absolute;
            border: 5px solid #AAAAAA;
            border-radius: 100%;
            height: 25px;
            width: 25px;
            top: 42px;
            left: 20px;
            z-index: 5;
            transition: border .25s linear;
            -webkit-transition: border .25s linear;
        }

        .payment_methods ul li:hover .check {
            border: 5px solid #0DFF92;
            background: #0DFF92;
            color: #0DFF92;
        }

        .payment_methods ul li .check::before {
            display: block;
            position: absolute;
            content: '';
            border-radius: 100%;
            height: 8px;
            width: 8px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: auto;
            transition: background 0.25s linear;
            -webkit-transition: background 0.25s linear;
        }

        .payment_methods input[type=radio]:checked~.check {
            border: 5px solid #0DFF92;
        }

        .payment_methods input[type=radio]:checked~.check::before {
            background: #0DFF92;
        }

        .payment_methods input[type=radio]:checked~label {
            color: #0DFF92;
        }
    </style>
@endpush

@section('content')
    <div class="row py-5 my-5">
        <div class="col-md-10 mx-auto">
            <div class="row">
                <div class="col-md-7 order-md-1 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your Products</span>
                        <span class="badge badge-secondary badge-pill">3</span>
                    </h4>
                    <div class="checkout_products">
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach ($checkItems as $cartItem)
                            <div class="row align-items-center mb-3">
                                <div class="image col-2">
                                    <img class="w-100 border border-1 rounded-1"
                                        src="{{storage_url($cartItem->product->image)}}"
                                        alt="Napa 500 mg (500 mg)">
                                </div>
                                <div class="col-6 details">
                                    <h4 class="product_title" title="{{$cartItem->product->attr_title}}">{{$cartItem->product->name}}</h4>
                                    <p class="product_sub_cat">{{$cartItem->product->pro_sub_cat->name}}</p>
                                    <p>{{{$cartItem->product->generic->name}}}</p>
                                    <p>{{$cartItem->product->company->name}}</p>
                                </div>
                                <div class="product_quantity col-2">
                                    <span>{{$cartItem->quantity}}</span><span> x </span><span>{{number_format($cartItem->product->price,2)}}</span>
                                </div>
                                <div class="total_price col-2">
                                    @php
                                        $single_total_price = number_format(($cartItem->quantity * $cartItem->product->price),2);
                                        $total_price +=$single_total_price;
                                    @endphp
                                    <span> &#2547; </span><span>{{$single_total_price}}</span>
                                </div>
                            </div>
                        @endforeach
                        
                        
                        <form class="card p-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Promo code">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">Redeem</button>
                                </div>
                            </div>
                        </form>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3>{{__('Order Summary')}}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td>{{__("Subtotal(".(isset($cartItem) ? $cartItem->count() : 0)." items)")}}</td>
                                        <td>:</td>
                                        <td class="text-end"><span> &#2547; </span><span>{{$total_price}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Delivery Fee')}}</td>
                                        <td>:</td>
                                        <td class="text-end"><span> &#2547; </span><span>{{isset($cartItem) ? number_format($cartItem->product->delivery_fee,2) : 0}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Discounts')}}</td>
                                        <td>:</td>
                                        <td class="text-end">-<span> &#2547; </span><span>{{isset($cartItem) ? number_format($cartItem->product->discount,2) : 0}}</span></td>
                                    </tr>
                                    <tr>
                                        @php
                                            
                                            $total_payment = ($total_price + (isset($cartItem) ? ((number_format($cartItem->product->delivery_fee,2))-(number_format($cartItem->product->discount,2))) : 0))
                                        @endphp
                                        <th>{{__('Total Payment')}}</th>
                                        <th>:</th>
                                        <th class="text-end"><span> &#2547; </span><span>{{$total_payment}}</span></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-5 order-md-2 billing_details">
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="payment_methods">

                                
                                    <h2>Payment Methods</h2>

                                    <ul>
                                        <li>
                                            <input type="radio" id="f-option" name="selector">
                                            <label for="f-option">Cash On Dalivery</label>

                                            <div class="check"></div>
                                        </li>

                                        <li>
                                            <input type="radio" id="s-option" name="selector">
                                            <label for="s-option">Mobile Banking</label>

                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="b-option" name="selector">
                                            <label for="b-option">Bank Transfer</label>

                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
