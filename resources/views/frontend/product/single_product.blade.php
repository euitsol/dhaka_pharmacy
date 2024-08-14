@extends('frontend.layouts.master')
@section('title', $single_product->name)
@push('css_link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugin/xzoom/xzoom.min.css') }}" media="all" />
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/single_product.css') }}">
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
                                                    href="{{ route('category.products', ['category' => $single_product->pro_cat->slug]) }}">{{ __($single_product->pro_cat->name) }}</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('category.products', ['category' => $single_product->pro_cat->slug, 'sub-category' => $single_product->pro_sub_cat->slug]) }}">{{ __($single_product->pro_sub_cat->name) }}</a>
                                            </li>
                                        </ul>
                                        <div class="favorite">
                                            <i class="{{ !empty($single_product->wish()) && !empty($single_product->wish->status) && $single_product->wish->status == 1 ? 'fa-solid' : 'fa-regular' }} fa-heart wish_update"
                                                data-pid="{{ encrypt($single_product->id) }}"></i>
                                        </div>
                                    </div>

                                    <div class="row gx-4">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="product_image xzoom-container">
                                                        @php
                                                            $singleProDisPrice = proDisPrice(
                                                                $single_product->price,
                                                                $single_product->discounts,
                                                            );
                                                        @endphp
                                                        @if ($singleProDisPrice != $single_product->price)
                                                            <span
                                                                class="discount_tag">{{ formatPercentageNumber($single_product->discount_percentage) . '% 0ff' }}</span>
                                                        @endif
                                                        <img class="xzoom" id="xzoom-default"
                                                            src="{{ $single_product->image }}"
                                                            xoriginal="{{ $single_product->image }}">

                                                        <!-- Thumbnails -->
                                                        <div class="xzoom-thumbs">
                                                            <a href="{{ $single_product->image }}">
                                                                <img class="xzoom-gallery xactive" width="80"
                                                                    src="{{ $single_product->image }}"
                                                                    xpreview="{{ $single_product->image }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{ route('u.ck.init') }}" id="single_order_form" method="POST">
                                                @csrf
                                                <div class="product_content">
                                                    <h1>{{ __($single_product->name) }} </h1>
                                                    {{-- <input type="hidden" name="slug"
                                                        value="{{ $single_product->slug }}"> --}}
                                                    <input type="hidden" name="product" value="{{ $single_product->id }}">
                                                    <p>{{ __($single_product->pro_sub_cat->name) }}</p>
                                                    <p>{{ __($single_product->generic->name) }}</p>
                                                    <p>{{ __($single_product->company->name) }}</p>


                                                    <div class="product_price mt-3">
                                                        @if ($singleProDisPrice != $single_product->price)
                                                            <p><del class="text-danger">{{ __('MRP Tk') }} <span
                                                                        class="total_regular_price">{{ __(number_format($single_product->price, 2)) }}</span></del>
                                                                <span
                                                                    class="badge bg-danger">{{ formatPercentageNumber($single_product->discount_percentage) . '% 0ff' }}</span>
                                                            </p>
                                                        @endif
                                                        <p><strong>{{ __('Price: Tk') }} <span
                                                                    class="total_price">{{ __(number_format($singleProDisPrice, 2)) }}
                                                                </span></strong> /<span
                                                                class="unit_name">{{ __('piece') }}</span> </p>

                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="form-group my-4 boxed">
                                                                @foreach ($single_product->units as $key => $unit)
                                                                    <input type="radio" value="{{ $unit->id }}"
                                                                        name="unit_id" data-id="{{ $unit->id }}"
                                                                        data-name="{{ $unit->name }}"
                                                                        @if ($key == 0) checked @endif
                                                                        class="item_quantity"
                                                                        id="android-{{ $key }}" name="data"
                                                                        data-total_price="{{ $singleProDisPrice * $unit->quantity }}"
                                                                        data-total_regular_price="{{ $single_product->price * $unit->quantity }}">
                                                                    <label for="android-{{ $key }}">
                                                                        <img src="{{ storage_url($unit->image) }}"
                                                                            title="{{ $unit->name }}">
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                            <div class="sp_quantity w-25">
                                                                <div class="form-group">
                                                                    <div class="input-group" role="group">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm minus_qty disabled">
                                                                            <i class="fa-solid fa-minus"></i>
                                                                        </a>
                                                                        <input type="text"
                                                                            class="form-control text-center quantity_input"
                                                                            name="quantity" value="1">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm plus_qty">
                                                                            <i class="fa-solid fa-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="add_to_card">
                                                        <a class="cart-btn" href="javascript:void(0)"
                                                            data-product_slug="{{ $single_product->slug }}"
                                                            data-quantity="1"
                                                            data-unit_id="{{ $single_product->units[0]['id'] }}">
                                                            <i class="fa-solid fa-cart-plus"></i>
                                                            {{ __('Add to Cart') }}</a>
                                                    </div>
                                                    <div class="order_button mt-4">
                                                        <button class="order-btn"
                                                            type="submit">{{ __('Order Now') }}</button>
                                                    </div>


                                                </div>
                                            </form>
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
                                                    @php
                                                        $reviews = $single_product->reviews->where('status', 1);
                                                    @endphp
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="review-tab" data-bs-toggle="tab"
                                                            data-bs-target="#review" type="button" role="tab"
                                                            aria-controls="review" aria-selected="false"><i
                                                                class="fa-regular fa-star-half-stroke"></i>
                                                            {{ __('Review') }}
                                                            <sup
                                                                class="badge bg-success">{{ $reviews->count() }}</sup></a>
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
                                                            @if ($single_product->strength_id)
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
                                                                            @foreach ($reviews->take(2) as $review)
                                                                                <div class="testimonial">
                                                                                    <div class="testimonial-content">
                                                                                        <div class="testimonial-icon">
                                                                                            <i
                                                                                                class="fa fa-quote-left"></i>
                                                                                        </div>
                                                                                        <p class="description"
                                                                                            style="text-align: justify">
                                                                                            {{ str_limit(html_entity_decode($review->description), 180) }}
                                                                                            <a class="float-end review_read"
                                                                                                data-content="{!! $review->description !!}"
                                                                                                data-author="{{ $review->customer->name }}"
                                                                                                href="javascript:void(0)">{{ __('Read More') }}</a>
                                                                                        </p>
                                                                                        <p
                                                                                            class="description text-end mt-2">
                                                                                            <strong>{{ $review->customer->name }}</strong>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
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
                                                    @php
                                                        $ProDisPrice = proDisPrice(
                                                            $product->price,
                                                            $product->discounts,
                                                        );
                                                    @endphp
                                                    <div class="col-12 single-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-4 img">
                                                                <a
                                                                    href="{{ route('product.single_product', $product->slug) }}">
                                                                    <img height=""
                                                                        class="w-100 border border-1 rounded-1"
                                                                        src="{{ $product->image }}"
                                                                        alt="{{ __($product->name) }}">
                                                                </a>
                                                            </div>
                                                            <div class="col-8 content">

                                                                <h3 class="pdct-title"
                                                                    title="{{ $product->attr_title }}"><a
                                                                        href="{{ route('product.single_product', $product->slug) }}">{{ $product->name }}
                                                                    </a></h3>
                                                                <p><a href="">{{ $product->pro_sub_cat->name }}</a>
                                                                </p>

                                                                <p><a href="">{{ $product->generic->name }}</a>
                                                                </p>
                                                                <p><a href="">{{ $product->company->name }}</a>
                                                                </p>
                                                                <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                                                        {{ number_format($ProDisPrice, 2) }}</span>
                                                                    @if ($ProDisPrice != $product->price)
                                                                        <span class="regular_price">
                                                                            <del>{!! get_taka_icon() !!}
                                                                                {{ number_format($product->price, 2) }}</del></span>
                                                                    @endif
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
                                                @php
                                                    $similarProDisPrice = proDisPrice(
                                                        $product->price,
                                                        $product->discounts,
                                                    );
                                                @endphp
                                                <div class="px-2 py-1">
                                                    <div class="single-pdct">
                                                        <a href="{{ route('product.single_product', $product->slug) }}">
                                                            <div class="pdct-img">
                                                                @if ($similarProDisPrice != $product->price)
                                                                    <span
                                                                        class="discount_tag">{{ formatPercentageNumber($product->discount_percentage) . '% off' }}</span>
                                                                @endif
                                                                <img class="w-100" src="{{ $product->image }}"
                                                                    alt="Product Image">
                                                            </div>
                                                        </a>
                                                        <div class="pdct-info">
                                                            <a href="#" class="generic-name">
                                                                {{ $product->generic->name }}
                                                            </a>
                                                            <a href="#" class="company-name">
                                                                {{ $product->company->name }}
                                                            </a>
                                                            <div class="product_title">
                                                                <a
                                                                    href="{{ route('product.single_product', $product->slug) }}">
                                                                    <h3 class="fw-bold"
                                                                        title="{{ $product->attr_title }}">
                                                                        {{ $product->name }}
                                                                    </h3>
                                                                </a>
                                                            </div>

                                                            <h4> <span> {!! get_taka_icon() !!}
                                                                    {{ number_format($similarProDisPrice, 2) }}</span>
                                                                @if ($similarProDisPrice != $product->price)
                                                                    <span class="regular_price">
                                                                        <del>{!! get_taka_icon() !!}
                                                                            {{ number_format($product->price, 2) }}</del></span>
                                                                @endif
                                                            </h4>

                                                            <div class="add_to_card">
                                                                <a class="cart-btn" href="javascript:void(0)"
                                                                    data-product_slug="{{ $product->slug }}">
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

    <!-- Review Details Modal -->
    <div class="modal fade" id="review_modal" tabindex="-1" aria-labelledby="review_modal_Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="review_modal_Label">{{ __('Review Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body review_details">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_link')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js">
    </script>
    <script type="text/javascript" src="{{ asset('frontend/plugin/xzoom/xzoom.min.js') }}"></script>
    <script src="{{ asset('frontend/asset/js/single_product.js') }}"></script>
@endpush
@push('js')
    <script>
        let errors = {!! json_encode($errors->all()) !!};
        if (errors.length > 0) {
            errors.forEach(function(error) {
                toastr.error(error);
            });
        }
    </script>
@endpush
