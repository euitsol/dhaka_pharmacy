@extends('frontend.layouts.master')
@section('title', 'Home')
@push('css_link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugin/xzoom/xzoom.min.css') }}" media="all" />
@endpush
@push('css')
    <style>
        .product_content .product_price .boxed label {
            display: inline-block;
            width: 100px;
            padding: 10px;
            border: solid 2px #ccc;
            transition: all 0.3s;
        }

        .product_content .product_price .boxed input[type="radio"] {
            display: none;
        }

        .product_content .product_price .boxed input[type="radio"]:checked+label {
            border: solid 2px green;
        }
        .product_content .product_price .boxed img {
            height: 70px;
            width: 100%;
            object-fit: cover;
        }
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
                    <div class="{{ $similar_products->isNotEmpty() ? 'col-md-9' : 'col-md-12' }}">
                        <div class="card single_product_card">
                            <div class="card-body">
                                <div class="single_product">
                                    <div class="breadcrumb_wrap">
                                        <ul class="breadcrumb wizard">
                                            <li class="completed"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                            <li class="completed"><a
                                                    href="{{route('category.products',['category'=>$single_product->pro_cat->slug])}}">{{ __($single_product->pro_cat->name) }}</a>
                                            </li>
                                            <li><a
                                                    href="{{route('category.products',['category'=>$single_product->pro_cat->slug,'sub-category'=>$single_product->pro_sub_cat->slug])}}">{{ __($single_product->pro_sub_cat->name) }}</a>
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
                                                    <div class="product_image xzoom-container">
                                                        <img class="xzoom" id="xzoom-default"
                                                            src="{{  storage_url($single_product->image) }}"
                                                            xoriginal="{{  storage_url($single_product->image) }}">

                                                        <!-- Thumbnails -->
                                                        <div class="xzoom-thumbs">
                                                            <a
                                                                href="{{  storage_url($single_product->image) }}">
                                                                <img class="xzoom-gallery xactive" width="80"
                                                                    src="{{  storage_url($single_product->image) }}"
                                                                    xpreview="{{  storage_url($single_product->image) }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product_content">
                                                <h1>{{ __($single_product->name) }} </h1>
                                                <p>{{ __($single_product->pro_sub_cat->name) }}</p>
                                                <p>{{ __($single_product->generic->name) }}</p>
                                                <p>{{ __($single_product->company->name) }}</p>
                                                <form action="">
                                                    <div class="product_price mt-4">
                                                        <p><strong>{{ __('MRP: Tk') }} <span
                                                                    class="total_price">{{ __(number_format($single_product->price, 2)) }}
                                                                </span></strong> /<span class="unit_name">{{ __('piece') }}</span> </p>
                                                        <div class="form-group my-4 boxed">
                                                            @foreach ($units as $key => $unit)
                                                                <input type="radio" data-id="{{$unit->id}}" data-name="{{$unit->name}}"
                                                                    @if ($key == 0) checked @endif
                                                                    class="item_quantity" id="android-{{ $key }}"
                                                                    name="data"
                                                                    value="{{ $single_product->price * $unit->quantity }}">
                                                                <label for="android-{{ $key }}">
                                                                    <img src="{{storage_url($unit->image)}}">
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="add_to_card">
                                                        <a class="cart-btn" href="javascript:void(0)" data-product_slug="{{ $single_product->slug }}"  href="#">
                                                            <i class="fa-solid fa-cart-plus"></i>
                                                            {{ __('Add to Cart') }}</a>
                                                    </div>
                                                    <div class="order_button mt-4">
                                                        <a class="order-btn" type="submit"
                                                            href="#">{{ __('Order Now') }}</a>
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
                                                        <a class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                                            data-bs-target="#info" type="button" role="tab"
                                                            aria-controls="info" aria-selected="false"><i
                                                                class="fa-solid fa-circle-info"></i>
                                                            {{ __('Information') }}</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="description-tab" data-bs-toggle="tab"
                                                            data-bs-target="#description" type="button" role="tab"
                                                            aria-controls="description" aria-selected="false"><i
                                                                class="fa-regular fa-file-lines"></i>
                                                            {{ __('Description') }}</a>
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
                                                    <div class="tab-pane fade show active" id="info" role="tabpanel"
                                                        aria-labelledby="info-tab">
                                                        <table class="table table-responsive table-bordered table-striped">
                                                            <tr>
                                                                <td>{{ __(strtoupper('Product Category')) }}</td>
                                                                <td>{{ __($single_product->pro_cat->name) }}</td>
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
                                                                <td>{{ __($single_product->pro_sub_cat->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Company Name')) }}</td>
                                                                <td>{{ __($single_product->company->name) }}</td>
                                                            </tr>
                                                            @if($single_product->strength_id)
                                                            <tr>
                                                                <td>{{ __(strtoupper('Product Strength')) }}</td>
                                                                <td>{{ __($single_product->strength->quantity . ' ' . $single_product->strength->unit) }}
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade" id="description" role="tabpanel"
                                                        aria-labelledby="description-tab">{!! $single_product->description !!}
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
                    @if ($similar_products->isNotEmpty())
                        <div class="col-3">
                            <div class="card similar_products_card" style="height:100%">
                                <div class="card-body">
                                    <div class="similar_products">
                                        <h2 class="mb-4">{{ __('Similar Products') }}</h2>
                                        <div class="products">
                                            <div class="row px-3">
                                                @foreach ($similar_products as $product)
                                                    <div class="col-12 single-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-4 img">
                                                                <a
                                                                    href="{{ route('product.single_product', $product->slug) }}">
                                                                    <img height=""
                                                                        class="w-100 border border-1 rounded-1"
                                                                        src="{{ storage_url($product->image) }}"
                                                                        alt="{{ __($product->name) }}">
                                                                </a>
                                                            </div>
                                                            <div class="col-8 content">

                                                                <h3 class="pdct-title" title="{{$product->attr_title}}"><a
                                                                        href="{{ route('product.single_product', $product->slug) }}">{{$product->name}}
                                                                    </a></h3>
                                                                <p><a
                                                                        href="">{{ $product->pro_sub_cat->name }}</a>
                                                                </p>

                                                                <p><a
                                                                        href="">{{ $product->generic->name }}</a>
                                                                </p>
                                                                <p><a
                                                                        href="">{{ $product->company->name }}</a>
                                                                </p>
                                                                <h4 class="pdct-price">
                                                                    <span>&#2547;</span>{{ __(number_format($product->price, 2)) }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                </div>
            </section>
            @if ($similar_products->isNotEmpty())
                <section class="related_product_section pb-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="related_product">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="title mb-4">{{ __('Related Products') }}</h2>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="related-product-slider" class="owl-carousel">
                                            @foreach ($similar_products as $product)
                                                    <div class="px-2 py-1">
                                                        

                                                        <div class="single-pdct">
                                                            <a href="{{ route('product.single_product', $product->slug) }}">
                                                                <div class="pdct-img">
                                                                    <img class="w-100"
                                                                        src="{{ storage_url($product->image) }}"
                                                                        alt="Product Image">
                                                                </div>
                                                            </a>
                                                            <div class="pdct-info">
                                                                <a href="#" class="generic-name">
                                                                    {{ $product->generic->name}}
                                                                </a>
                                                                <a href="#" class="company-name">
                                                                    {{ $product->company->name}}
                                                                </a>
                                                                <div class="product_title">
                                                                    <a href="{{ route('product.single_product', $product->slug) }}">
                                                                        <h3 class="fw-bold" title="{{$product->attr_title}}">
                                                                            {{ $product->name }}
                                                                        </h3>
                                                                    </a>
                                                                </div>
                                                                <h4> <span> &#2547; </span> {{ number_format($product->price) }}</h4>
                                                                <div class="add_to_card">
                                                                    <a class="cart-btn" href="javascript:void(0)" data-product_slug="{{ $product->slug }}">
                                                                        <i class="fa-solid fa-cart-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                
                                                        </div>
                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
        <!--=========== Main Content Section End ==============-->
    </div>
@endsection
@push('js_link')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js">
    </script>
    <script type="text/javascript" src="{{ asset('frontend/plugin/xzoom/xzoom.min.js') }}"></script>
@endpush
@push('js')
    <script>
        // XZoom 
        $(document).ready(function() {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: 400,
                title: true,
                tint: '#333',
                Xoffset: 15
            });
        });
        // Xzoom 

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


            $('.product_price .item_quantity').on('change', function() {
                var name = $(this).data('name');
                var id = $(this).data('id');
                $(this).closest('.product_content').find('.cart-btn').attr('data-unit_id',id);

                var formattedNumber = numberFormat($(this).val(), 2);
                $('.total_price').html(formattedNumber);
                $('.unit_name').html(name);
            });


            //Height Control Jquery
            var single_product_height = $('.single_product_card').height();
            $('.similar_products_card').css('max-height', single_product_height + 'px')




            //Breadcrumb Jquery
            $('.breadcrumb_wrap .favorite i').on('click', function() {
                if ($(this).hasClass('fa-regular')) {
                    $(this).removeClass('fa-regular').addClass('fa-solid');
                } else {
                    $(this).removeClass('fa-solid').addClass('fa-regular');
                }
            });



            //Product Description Jquery
            $(".single_product_section .product_details .nav-tabs a").on('click', function() {
                var single_product_height = $('.single_product_card').height();
                $('.similar_products_card').css('max-height', single_product_height + 'px');

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
