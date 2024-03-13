@extends('frontend.layouts.master')
@section('title', 'Home')

@push('css')
    <style>
        .form-floating {
            position: relative;
        }

        .form-floating>.form-control,
        .form-floating>.form-select {
            height: calc(3.625rem + 2px);
            padding: 1.125rem 1.3125rem 0.9rem;
        }

        .form-label-fixed {
            position: relative;
        }

        .form-label-fixed>.form-label {
            position: absolute;
            top: -1.00000625rem;
            left: 1rem;
            margin: 0;
            padding: 0.25rem 0.5rem 0.25rem 0.5rem;
            background-color: #ffffff;
            color: #222222;
            z-index: 1;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.9375rem 0.9375rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.7143;
            color: #222222;
            background-color: #fff;
            background-clip: padding-box;
            border: 0.125rem solid #e4e4e4;
            appearance: none;
            border-radius: 0;
            box-shadow: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #222222;
            background-color: #fff;
            border-color: #222222;
            outline: 0;
            box-shadow: none;
        }

        .dilling_details .form-floating>label,
        .dilling_details .form-label-fixed>.form-label {
            color: #767676;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label,
        .form-floating>.form-select~label {
            background-color: #ffffff;
            color: #222222;
            transform: translateY(-1.9rem);
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label,
        .form-floating>.form-select~label {
            background-color: #ffffff;
            color: #222222;
            transform: translateY(-1.9rem);
        }

        .form-floating>label {
            position: absolute;
            top: 1rem;
            height: auto;
            left: 0.75rem;
            padding: 0 0.5rem;
            pointer-events: none;
            border: 0.125rem solid transparent;
            transform-origin: 0 0;
            transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
            color: #767676;
        }

        label {
            display: inline-block;
        }

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
            top: 30px;
            left: 20px;
            z-index: 5;
            transition: border .25s linear;
            -webkit-transition: border .25s linear;
        }

        .payment_methods ul li:hover .check {
            border: 5px solid #FFFFFF;
        }

        .payment_methods ul li .check::before {
            display: block;
            position: absolute;
            content: '';
            border-radius: 100%;
            height: 15px;
            width: 15px;
            top: 5px;
            left: 5px;
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

        


        /* Styles for alert...
            by the way it is so weird when you look at your code a couple of years after you wrote it XD */

        /* .alert {
            box-sizing: border-box;
            background-color: #BDFFE1;
            width: 100%;
            position: relative;
            top: 0;
            left: 0;
            z-index: 300;
            padding: 20px 40px;
            color: #333;
        }

        .alert h2 {
            font-size: 22px;
            color: #232323;
            margin-top: 0;
        }

        .alert p {
            line-height: 1.6em;
            font-size: 18px;
        }

        .alert a {
            color: #232323;
            font-weight: bold;
        } */
    </style>
@endpush

@section('content')
    <div class="row py-5 my-5">
        <div class="col-md-10 mx-auto">
            <div class="row">
                <div class="col-md-5 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your Products</span>
                        <span class="badge badge-secondary badge-pill">3</span>
                    </h4>
                    <div class="checkout_products">
                        <div class="row align-items-center mb-3">
                            <div class="image col-2">
                                <img class="w-100 border border-1 rounded-1"
                                    src="http://127.0.0.1:8000/storage/district_manager/Napa 500 MG Tablet/Napa 500 MG Tablet_1708856236.webp"
                                    alt="Napa 500 mg (500 mg)">
                            </div>
                            <div class="col-6 details">
                                <h4 class="product_title">Napa 500 mg (500 mg)</h4>
                                <p class="product_sub_cat">Tablet</p>
                                <p>Paracetamol</p>
                                <p>Beximco pharmaceuticals ltd</p>
                            </div>
                            <div class="product_quantity col-2">
                                <span>1</span><span>x</span><span>10</span>
                            </div>
                            <div class="total_price col-2">
                                <span> &#2547; </span><span>20,000</span>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="image col-2">
                                <img class="w-100 border border-1 rounded-1"
                                    src="http://127.0.0.1:8000/storage/district_manager/Napa 500 MG Tablet/Napa 500 MG Tablet_1708856236.webp"
                                    alt="Napa 500 mg (500 mg)">
                            </div>
                            <div class="col-6 details">
                                <h4 class="product_title">Napa 500 mg (500 mg)</h4>
                                <p class="product_sub_cat">Tablet</p>
                                <p>Paracetamol</p>
                                <p>Beximco pharmaceuticals ltd</p>
                            </div>
                            <div class="product_quantity col-2">
                                <span>1</span><span>x</span><span>10</span>
                            </div>
                            <div class="total_price col-2">
                                <span> &#2547; </span><span>20,000</span>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="image col-2">
                                <img class="w-100 border border-1 rounded-1"
                                    src="http://127.0.0.1:8000/storage/district_manager/Napa 500 MG Tablet/Napa 500 MG Tablet_1708856236.webp"
                                    alt="Napa 500 mg (500 mg)">
                            </div>
                            <div class="col-6 details">
                                <h4 class="product_title">Napa 500 mg (500 mg)</h4>
                                <p class="product_sub_cat">Tablet</p>
                                <p>Paracetamol</p>
                                <p>Beximco pharmaceuticals ltd</p>
                            </div>
                            <div class="product_quantity col-2">
                                <span>1</span><span>x</span><span>10</span>
                            </div>
                            <div class="total_price col-2">
                                <span> &#2547; </span><span>20,000</span>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="image col-2">
                                <img class="w-100 border border-1 rounded-1"
                                    src="http://127.0.0.1:8000/storage/district_manager/Napa 500 MG Tablet/Napa 500 MG Tablet_1708856236.webp"
                                    alt="Napa 500 mg (500 mg)">
                            </div>
                            <div class="col-6 details">
                                <h4 class="product_title">Napa 500 mg (500 mg)</h4>
                                <p class="product_sub_cat">Tablet</p>
                                <p>Paracetamol</p>
                                <p>Beximco pharmaceuticals ltd</p>
                            </div>
                            <div class="product_quantity col-2">
                                <span>1</span><span>x</span><span>10</span>
                            </div>
                            <div class="total_price col-2">
                                <span> &#2547; </span><span>20,000</span>
                            </div>
                        </div>
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
                                <h3>Order Summary</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Subtotal(2 items)</td>
                                        <td>:</td>
                                        <td class="text-end"><span> &#2547; </span><span>40,000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Fee</td>
                                        <td>:</td>
                                        <td class="text-end"><span> &#2547; </span><span>100</span></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Discount</td>
                                        <td>:</td>
                                        <td class="text-end">-<span> &#2547; </span><span>50</span></td>
                                    </tr>
                                    <tr>
                                        <td>Discounts</td>
                                        <td>:</td>
                                        <td class="text-end">-<span> &#2547; </span><span>1000</span></td>
                                    </tr>
                                    <tr>
                                        <th>Total Payment</th>
                                        <th>:</th>
                                        <th class="text-end"><span> &#2547; </span><span>38,950</span></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-7 order-md-1 dilling_details">
                    <h4 class="mb-3">{{ __('Billing Details') }}</h4>
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_first_name"
                                        placeholder="First Name">
                                    <label for="checkout_first_name">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_last_name"
                                        placeholder="Last Name">
                                    <label for="checkout_last_name">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="search-field my-3">
                                    <div class="form-label-fixed hover-container">
                                        <label for="country" class="form-label">Country / Region*</label>
                                        <div class="js-hover__open">
                                            <select name="country" class="form-control form-control-lg" id="country">
                                                <option selected hidden>Select Country</option>
                                                <option value="bangladesh">Bangladesh</option>
                                                <option value="india">India</option>
                                                <option value="pakistan">Pakistan</option>
                                                <option value="united state">United State</option>
                                                <option value="australia">Australia</option>
                                                <option value="canada">Canada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating mt-3 mb-3">
                                    <textarea name="address" id="checkout_street_address" class="form-control" placeholder="Street Address *"></textarea>
                                    <label for="checkout_company_name">Street Address *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_city"
                                        placeholder="Town / City *">
                                    <label for="checkout_city">Town / City *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_zipcode"
                                        placeholder="Postcode / ZIP *">
                                    <label for="checkout_zipcode">Postcode / ZIP *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_province"
                                        placeholder="Province *">
                                    <label for="checkout_province">Province *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_phone"
                                        placeholder="Phone *">
                                    <label for="checkout_phone">Phone *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" id="checkout_email"
                                        placeholder="Your Mail *">
                                    <label for="checkout_email">Your Mail *</label>
                                </div>
                            </div>
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
                                            <input type="radio" id="s-option" name="selector">
                                            <label for="s-option">Bank Transfer</label>

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
