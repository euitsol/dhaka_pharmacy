@extends('frontend.layouts.master')
@section('title', 'Home')
@push('css_link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
@endpush
@push('css')
    <style>
        .breadcrumb_wrap {
            position: relative;
        }

        .breadcrumb_wrap .breadcrumb.wizard {
            padding: 0px;

            list-style: none;
            overflow: hidden;
            font-size: 15px;
        }

        .breadcrumb_wrap .breadcrumb.wizard>li+li:before {
            padding: 0;
        }

        .breadcrumb_wrap .breadcrumb.wizard li {
            float: left;
        }

        .breadcrumb_wrap .breadcrumb.wizard li.active a {
            /* background: var(--primary-bg);                   fallback color */
            background: var(--primary-bg);
        }

        .breadcrumb_wrap .breadcrumb.wizard li.completed a {
            background: var(--primary-bg);
            /* fallback color */
            background: var(--secundary-color);
        }

        .breadcrumb_wrap .breadcrumb.wizard li.active a:after {
            border-left: 30px solid var(--primary-bg);
        }

        .breadcrumb_wrap .breadcrumb.wizard li.completed a:after {
            border-left: 30px solid var(--secundary-color);
        }

        .breadcrumb_wrap .breadcrumb.wizard li a {
            color: var(--text-color-white);
            background: var(--primary-bg);
            text-decoration: none;
            padding: 10px 0 10px 45px;
            position: relative;
            display: block;
            float: left;
        }

        .breadcrumb_wrap .breadcrumb.wizard li a:after {
            content: " ";
            display: block;
            width: 0;
            height: 0;
            border-top: 50px solid transparent;
            /* Go big on the size, and let overflow hide */
            border-bottom: 50px solid transparent;
            border-left: 30px solid var(--nav-primary-bg);
            position: absolute;
            top: 50%;
            margin-top: -50px;
            left: 100%;
            z-index: 2;
        }

        .breadcrumb_wrap .breadcrumb.wizard li a:before {
            content: " ";
            display: block;
            width: 0;
            height: 0;
            border-top: 50px solid transparent;
            /* Go big on the size, and let overflow hide */
            border-bottom: 50px solid transparent;
            border-left: 30px solid var(--text-color-white);
            position: absolute;
            top: 50%;
            margin-top: -50px;
            margin-left: 1px;
            left: 100%;
            z-index: 1;
        }

        .breadcrumb_wrap .breadcrumb.wizard li:first-child a {
            padding-left: 15px;
        }

        .breadcrumb_wrap .breadcrumb.wizard li a:hover {
            background: var(--secondary-bg);
        }

        .breadcrumb_wrap .breadcrumb.wizard li a:hover:after {
            border-left-color: var(--secondary-bg) !important;
        }

        .breadcrumb_wrap .favorite {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 22px;
            cursor: pointer;
        }

        .breadcrumb_wrap .favorite i.fa-solid {
            color: red;
        }

        .single_product_section .single_product .product_content h1,
        .single_product_section .resembling_products h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            line-height: 35px;
            font-weight: 500;
            color: var(--text-color-black);
            transition: .4s;
            cursor: pointer;
        }

        .single_product_section .single_product .product_content h1:hover,
        .single_product_section .resembling_products h2:hover {
            color: var(--text-primary-color);
        }
        .single_product_section .single_product .product_content h1 small{
            font-size: 13px;
        }
        .single_product_section .single_product .product_image {}

        .single_product_section .single_product .product_image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .single_product_section .single_product .product_content {}

        .single_product_section .single_product .product_content p {
            margin-bottom: 5px;
            font-size: 18px;
            color: var(--text-color-black);
        }

        .single_product_section .single_product .product_content .product_price {}

        .single_product_section .single_product .product_content .product_price select {
            text-align: center;
            color: var(--text-color-black);

        }

        .single_product_section .single_product .product_content .product_price select:focus {
            border-color: var(--text-color-black);
            box-shadow: none;
        }

        .single_product_section .single_product .product_content .product_price p {}

        .single_product_section .single_product .product_content .product_price a {}






        /* Product Details CSS  */

        .single_product_section .single_product .product_details {}

        .single_product_section .single_product .product_details .tab-pane {
            padding: 15px;

        }

        .single_product_section .single_product .product_details .nav-tabs {
            position: relative;
            border: none !important;
            background-color: var(--text-color-white);
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            padding: 0;
        }

        .single_product_section .single_product .product_details .nav-tabs li {
            margin: 0px !important;
        }

        .single_product_section .single_product .product_details .nav-tabs li a {
            position: relative;
            margin-right: 0px !important;
            padding: 20px 40px !important;
            font-size: 16px;
            border: none !important;
            color: #333;
        }

        .single_product_section .single_product .product_details .nav-tabs a:hover {
            background-color: var(--text-color-white) !important;
            border: none;
        }

        .single_product_section .single_product .product_details .slider {
            display: inline-block;
            width: 30px;
            height: 4px;
            border-radius: 3px;
            background-color: var(--secondary-bg);
            position: absolute;
            z-index: 1200;
            bottom: 0;
            transition: all .4s linear;

        }

        .single_product_section .single_product .product_details .nav-tabs .active {
            background-color: transparent !important;
            border: none !important;
            color: var(--secundary-color) !important;
        }





        /* resembling Product CSS  */

        .single_product_section .resembling_products .single-item .img img {
            height: 100%;
            object-fit: cover;
            padding: 15px 5px;
        }

        .single_product_section .resembling_products .single-item img {
            border-color: var(--text-color-black) !important;
        }

        .single_product_section .resembling_products .single-item .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .single_product_section .resembling_products .single-item .pdct-title {
            margin: 0;
            padding: 0;
        }

        .single_product_section .resembling_products .single-item .pdct-title {
            font-family: "Open Sans", sans-serif;
            font-size: 15px;
            line-height: 23px;
            font-weight: 500;
            display: block;
            text-decoration: none;
            color: var(--text-color-black);
            transition: 0.4s;
        }

        .single_product_section .resembling_products .single-item .pdct-title:hover {
            color: var(--asent-color);
        }

        .single_product_section .resembling_products .single-item .pdct-price {
            font-family: "Open Sans", sans-serif;
            font-size: 17px;
            line-height: 25px;
            font-weight: 500;
            color: var(--secundary-color);
            margin: 0;
        }

        .resembling_products_card {
            overflow-y: auto;
        }

        .resembling_products_card::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
            border-radius: 10px;
            background-color: var(--primary-bg);
        }

        .resembling_products_card::-webkit-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
        }

        .resembling_products_card::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: var(--secundary-color);
            background-image: -webkit-linear-gradient(90deg,
                    transparent,
                    var(--secundary-color) 50%,
                    transparent,
                    transparent)
        }









        /* Review CSS */
        .single_product_section .product_details .what-say {
            background: #F5F5F5 !important;
            padding-top: 100px !important;
        }

        .single_product_section .product_details .what-say .testimonial {
            margin: 0 20px 40px;
        }

        .single_product_section .product_details .what-say .testimonial .testimonial-content {
            padding: 35px 25px 35px 50px;
            margin-bottom: 35px;
            background: var(--text-color-white);
            position: relative;
        }

        .single_product_section .product_details .what-say .testimonial .testimonial-content:before {
            content: "";
            position: absolute;
            bottom: -30px;
            left: 0;
            border-top: 15px solid var(--primary-color);
            border-left: 15px solid transparent;
            border-bottom: 15px solid transparent;
        }

        .single_product_section .product_details .what-say .testimonial .testimonial-content:after {
            content: "";
            position: absolute;
            bottom: -30px;
            right: 0;
            border-top: 15px solid var(--primary-color);
            border-right: 15px solid transparent;
            border-bottom: 15px solid transparent;
        }

        .single_product_section .product_details .what-say .testimonial-content .testimonial-icon {
            width: 50px;
            height: 45px;
            background: var(--secundary-color);
            text-align: center;
            font-size: 22px;
            color: var(--text-color-white);
            line-height: 42px;
            position: absolute;
            top: 37px;
            left: -19px;
        }

        .single_product_section .product_details .what-say .testimonial-content .testimonial-icon:before {
            content: "";
            border-bottom: 16px solid var(--secundary-color);
            border-left: 18px solid transparent;
            position: absolute;
            top: -16px;
            left: 1px;
        }

        .single_product_section .product_details .what-say .testimonial .description {
            font-size: 15px;
            font-style: italic;
            color: var(--text-color-black);
            line-height: 23px;
            margin: 0;
        }

        .single_product_section .product_details .what-say .testimonial .title {
            display: block;
            font-size: 18px;
            font-weight: 500;
            color: var(--text-color-black);
            text-transform: capitalize;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
        }

        .single_product_section .product_details .what-say .testimonial .post {
            display: block;
            font-size: 14px;
            color: var(--secundary-color);
        }

        .single_product_section .product_details .what-say .owl-theme .owl-controls {
            margin-top: 20px;
        }

        .single_product_section .product_details .what-say .owl-theme .owl-controls .owl-page span {
            background: var(--primary-color);
            opacity: 1;
            transition: all 0.4s ease 0s;
        }

        .single_product_section .product_details .what-say .owl-theme .owl-controls .owl-page.active span,
        .single_product_section .product_details .what-say .owl-theme .owl-controls.clickable .owl-page:hover span {
            background: var(--secundary-color);
        }

        /* Related Product CSS */
    </style>
@endpush
@section('content')
    <div class="row pt-4">
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @if ($menuItems->isNotEmpty())
            @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
        @endif
        <!--=========== Sidebar-Category-Section-Include  ==============-->


        <!--=========== Main Content Section Start ==============-->
        <div class="{{ $menuItems->isNotEmpty() ? 'col-md-9 col-lg-10' : 'col-12' }} content-col">
            <section class="single_product_section pb-4">
                <div class="row">
                    <div class="col-9">
                        <div class="card single_product_card">
                            <div class="card-body">
                                <div class="single_product">
                                    <div class="breadcrumb_wrap">
                                        <ul class="breadcrumb wizard">
                                            <li class="completed"><a href="javascript:void(0);">{{ __('Home') }}</a></li>
                                            <li class="completed"><a
                                                    href="javascript:void(0);">{{ __($single_product->pro_cat->name) }}</a>
                                            </li>
                                            <li class="completed"><a
                                                    href="javascript:void(0);">{{ __($single_product->pro_sub_cat->name) }}</a>
                                            </li>
                                            <li><a
                                                    href="javascript:void(0);">{{ __($single_product->medicine_cat->name) }}</a>
                                            </li>
                                        </ul>
                                        <div class="favorite">
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                    </div>

                                    <div class="row gx-4">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="product_image">
                                                        <img src="{{ $single_product->image ? storage_url($single_product->image) : asset('no_img/no_img.png') }}"
                                                            alt="Product Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product_content">
                                                <h1>{{ __($single_product->name) }} <small>{{__($single_product->strength->quantity.' '. strtoupper($single_product->strength->unit))}}</small></h1>
                                                <p>{{ __($single_product->medicine_cat->name) }}</p>
                                                <p>{{ __($single_product->generic->name) }}</p>
                                                <p>{{ __($single_product->company->name) }}</p>
                                                <form action="">
                                                    <div class="product_price mt-4">
                                                        <p><strong>{{ __('MRP: Tk') }} <span
                                                                    class="total_price">{{ __(number_format($single_product->price, 2)) }}
                                                                </span></strong> {{ __('/piece') }}</p>
                                                        <div class="form-group my-4">
                                                            <select name="price"
                                                                class="form-select form-select-lg price_select_box"
                                                                aria-label=".form-select-lg example">
                                                                <option value="{{ $single_product->price }}">
                                                                    {{ __('Price') }}</option>
                                                                @foreach ($units as $unit)
                                                                    <option
                                                                        value="{{ $single_product->price * $unit->quantity }}">
                                                                        {{ __($unit->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="add_to_card">
                                                        <a class="cart-btn" type="submit" href="#"><img
                                                                src="{{ asset('frontend/asset/img/cart-icon.svg') }}"
                                                                alt="">{{ __('Add to Cart') }}</a>
                                                    </div>
                                                    <div class="order_button mt-4">
                                                        <a class="order-btn" type="submit" href="#">{{ __('Order Now') }}</a>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="product_details py-4">
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                                    <div class="slider"></div>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                                            data-bs-target="#description" type="button" role="tab"
                                                            aria-controls="description" aria-selected="false"><i
                                                                class="fa-regular fa-file-lines"></i>
                                                            {{ __('Description') }}</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="info-tab" data-bs-toggle="tab"
                                                            data-bs-target="#info" type="button" role="tab"
                                                            aria-controls="info" aria-selected="false"><i
                                                                class="fa-solid fa-circle-info"></i>
                                                            {{ __('Information') }}</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="review-tab" data-bs-toggle="tab"
                                                            data-bs-target="#review" type="button" role="tab"
                                                            aria-controls="review" aria-selected="false"><i
                                                                class="fa-regular fa-star-half-stroke"></i>
                                                            {{ __('Review') }}</a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                                                        aria-labelledby="description-tab">{!! $single_product->description !!}
                                                    </div>
                                                    <div class="tab-pane fade" id="info" role="tabpanel"
                                                        aria-labelledby="info-tab">
                                                        <table class="table table-responsive table-bordered table-striped">
                                                            <tr>
                                                                <td>{{ __(strtoupper('Product Category')) }}</td>
                                                                <td>{{ __($single_product->pro_cat->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Product Sub Category')) }}</td>
                                                                <td>{{ __($single_product->pro_sub_cat->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Medicine Name')) }}</td>
                                                                <td>{{ __($single_product->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Generic Name')) }}</td>
                                                                <td>{{ __($single_product->generic->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Medicine Dosage')) }}</td>
                                                                <td>{{ __($single_product->medicine_cat->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Company Name')) }}</td>
                                                                <td>{{ __($single_product->company->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Product Strength')) }}</td>
                                                                <td>{{ __($single_product->strength->quantity . ' ' . $single_product->strength->unit) }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="review" role="tabpanel"
                                                        aria-labelledby="review-tab">
                                                        <!--Start What-Customer-Say Section-->
                                                        <div class="what-say">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div id="testimonial-slider" class="owl-carousel">
                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipisit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">John</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>

                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Kelle</h3>
                                                                                <span class="post">Web Designer</span>
                                                                            </div>

                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Steven</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>

                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Peter</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>
                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Peter</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>
                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Peter</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>
                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Peter</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>
                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Peter</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>
                                                                            <div class="testimonial">
                                                                                <div class="testimonial-content">
                                                                                    <div class="testimonial-icon">
                                                                                        <i class="fa fa-quote-left"></i>
                                                                                    </div>
                                                                                    <p class="description">
                                                                                        Lorem ipsum dolor sit amet,
                                                                                        consectetur adipiscing elit.
                                                                                        Praesent bibendum dolor sit
                                                                                        amet eros imperdiet, sit amet
                                                                                        hendrerit nisi vehicula.
                                                                                    </p>
                                                                                </div>
                                                                                <h3 class="title">Peter</h3>
                                                                                <span class="post">Web Developer</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--End What-Customer-Say Section-->

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-3">
                        <div class="card resembling_products_card" style="height:100%">
                            <div class="card-body">
                                <div class="resembling_products">
                                    <h2 class="mb-4">{{ __('Resembling Products') }}</h2>
                                    <div class="products">
                                        <div class="row">
                                            @foreach ($resembling_products as $product)
                                                @for ($i = 1; $i <= 2; $i++)
                                                    <div class="col-12">
                                                        <div class="single-item">
                                                            <a href="{{ route('product.single_product', $product->id) }}">
                                                                <div class="row">

                                                                    <div class="col-4 img">
                                                                        <img class="w-100 border border-1 rounded-1"
                                                                            src="{{ $product->image ? storage_url($product->image) : asset('no_img/no_img.png') }}"
                                                                            alt="{{ __($product->name) }}">
                                                                    </div>
                                                                    <div class="col-8 content">
                                                                        <h3 class="pdct-title">{{ __($product->name) }}
                                                                        </h3>
                                                                        <h4 class="pdct-price">
                                                                            <span>&#2547;</span>{{ __(number_format($product->price, 2)) }}
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <section class="related_product_section pb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="related_product">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="title mb-4">{{__('Related Products')}}</h2>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="related-product-slider" class="owl-carousel">
                                        @foreach ($resembling_products as $product)
                                            @for ($i=1; $i<=20; $i++)
                                            <div class="px-2">
                                                <div class="single-pdct">
                                                    <a href="{{route('product.single_product',$product->id)}}">
                                                        <div class="pdct-img">
                                                            <img class="w-100" src="{{ ($product->image) ? storage_url($product->image) : asset('no_img/no_img.png') }}"
                                                                alt="Product Image">
                                                        </div>
                                                        <div class="pdct-info">
                                                            <h3 class="fw-bold">{{$product->name}}</h3>
                                                            <p>{{$product->generic->name}}</p>
                                                            <h4><span>&#2547;</span>{{$product->price}}</h4>
                                                        </div>
                                                    </a>
                                                    <div class="add_to_card">
                                                        <a class="cart-btn" href="#"><img
                                                                src="{{ asset('frontend/asset/img/cart-icon.svg') }}"
                                                                alt="">{{__('Add to Cart')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endfor
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--=========== Main Content Section End ==============-->
    </div>
@endsection
@push('js_link')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js">
    </script>
@endpush
@push('js')
    <script>

        //testimonial-slider
        $(document).ready(function() {
            $("#testimonial-slider").owlCarousel({
                items: 3,
                itemsDesktop: [1000, 3],
                itemsDesktopSmall: [980, 2],
                itemsTablet: [768, 2],
                itemsMobile: [650, 1],
                pagination: true,
                navigation: false,
                slideSpeed: 1000,
                autoPlay: 2000
            });
        });
        //related product
        $(document).ready(function() {
            $("#related-product-slider").owlCarousel({
                items: 5,
                itemsDesktop: [1000, 5],
                itemsDesktopSmall: [980, 4],
                itemsTablet: [768, 3],
                itemsMobile: [650, 2],
                itemsMobile: [480, 1],
                pagination: true,
                navigation: false,
                slideSpeed: 1000,
                autoPlay: 2000
            });
        });
    </script>
    <script>
        function numberFormat(value, decimals) {
            return parseFloat(value).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        $(document).ready(function() {


            $('.price_select_box').on('change', function() {
                console.log($(this).val());
                var formattedNumber = numberFormat($(this).val(), 2);
                $('.total_price').html(formattedNumber);
            });


            //Height Control Jquery
            var single_product_height = $('.single_product_card').height();
            $('.resembling_products_card').css('max-height', single_product_height + 'px')

            $('.product_details .nav-item').on('click', function() {
                var single_product_height = $('.single_product_card').height();
                $('.resembling_products_card').css('max-height', single_product_height + 'px')
            });



            //Breadcrumb Jquery
            $('.breadcrumb_wrap .favorite i').on('click', function() {
                if ($(this).hasClass('fa-regular')) {
                    $(this).removeClass('fa-regular').addClass('fa-solid');
                } else {
                    $(this).removeClass('fa-solid').addClass('fa-regular');
                }
            });



            //Product Description Jquery
            $(".single_product_section .product_details .nav-tabs a").click(function() {
                var position = $(this).parent().position();
                var width = $(this).parent().width();
                $(".single_product_section .product_details .slider").css({
                    "left": +position.left,
                    "width": width
                });
                $('.product_details .nav-tabs li a').removeClass('active');
                $(this).addClass('active');
            });
            var actWidth = $(".single_product_section .product_details .nav-tabs").find(".active").parent("li")
                .width();
            var actPosition = $(".single_product_section .product_details .nav-tabs .active").position();
            $(".single_product_section .product_details .slider").css({
                "left": +actPosition.left,
                "width": actWidth
            });





        });
    </script>
@endpush
