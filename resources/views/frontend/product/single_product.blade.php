@extends('frontend.layouts.master')
@section('title', 'Home')
@push('css_link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
@endpush
@push('css')
    <style>
        .boxed label {
            display: inline-block;
            width: 100px;
            padding: 10px;
            border: solid 2px #ccc;
            transition: all 0.3s;
        }

        .boxed input[type="radio"] {
            display: none;
        }

        .boxed input[type="radio"]:checked + label {
            border: solid 2px green;
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
                                                        <div class="form-group my-4 boxed">
                                                            @foreach ($units as $key=>$unit)
                                                                <input type="radio" class="item_quantity" id="android-{{$key}}" name="data" value="{{ $single_product->price * $unit->quantity }}">
                                                                <label for="android-{{$key}}">
                                                                    <img src="http://via.placeholder.com/150x150">
                                                                </label>
                                                            @endforeach
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
                                                                <td>{{ __($single_product->pro_cat->name.' - ') }}<small>{{ __($single_product->pro_sub_cat->name) }}</small></td>
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
                    <div class="col-3">
                        <div class="card similar_products_card" style="height:100%">
                            <div class="card-body">
                                <div class="similar_products">
                                    <h2 class="mb-4">{{ __('Similar Products') }}</h2>
                                    <div class="products">
                                        <div class="row px-3">
                                            @foreach ($similar_products as $product)
                                                @for ($i = 1; $i <= 2; $i++)
                                                    <div class="col-12 single-item">
                                                                <div class="row align-items-center">
                                                                    <div class="col-4 img">
                                                                        <a href="{{ route('product.single_product', $product->id) }}"> 
                                                                        <img height="" class="w-100 border border-1 rounded-1"
                                                                            src="{{ $product->image ? storage_url($product->image) : asset('no_img/no_img.png') }}"
                                                                            alt="{{ __($product->name) }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-8 content">
                                                                        <h3 class="pdct-title">{{ __(str_limit($product->name,25)) }}
                                                                        </h3>
                                                                        <p><a href="">{{str_limit($product->generic->name,25)}}</a></p>
                                                                        <p><a href="">{{str_limit($product->company->name,25)}}</a></p>
                                                                        <p><a href="">{{str_limit($product->medicine_cat->name,25)}}</a></p>
                                                                        <h4 class="pdct-price">
                                                                            <span>&#2547;</span>{{ __(number_format($product->price, 2)) }}
                                                                        </h4>
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
                                        @foreach ($similar_products as $product)
                                            @for ($i=1; $i<=20; $i++)
                                            <div class="px-2">
                                                <div class="single-pdct">
                                                    <a href="{{route('product.single_product',$product->id)}}">
                                                        <div class="pdct-img">
                                                            <img class="w-100" src="{{ ($product->image) ? storage_url($product->image) : asset('no_img/no_img.png') }}"
                                                                alt="Product Image">
                                                        </div>
                                                        <div class="pdct-info">
                                                            <h3 class="fw-bold">{{$product->name}} <small>({{$product->medicine_cat->name}})</small></h3>
                                                            <p><a href="">{{str_limit($product->generic->name,25)}}</a></p>
                                                            <p><a href="">{{str_limit($product->company->name,25)}}</a></p>
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


            $('.item_quantity').on('change', function() {
                console.log($(this).val());
                var formattedNumber = numberFormat($(this).val(), 2);
                $('.total_price').html(formattedNumber);
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
            $(".single_product_section .product_details .nav-tabs a").on('click',function() {
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
