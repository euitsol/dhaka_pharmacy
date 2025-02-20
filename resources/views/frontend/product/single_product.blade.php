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
    <div class="row pt-2 pt-lg-4">
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @if ($menuItems->isNotEmpty())
            @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
        @endif
        <!--=========== Sidebar-Category-Section-Include  ==============-->


        <!--=========== Main Content Section Start ==============-->
        <div class="{{ $menuItems->isNotEmpty() ? 'col-8 col-xxl-10 col-12 col-lg-9' : 'col-12' }} content-col">
            <section class="single_product_section pb-3">
                <div class="row">
                    <div class="{{ $similar_products->isNotEmpty() ? 'col-12 col-xxl-9' : 'col-md-12' }}">
                        <div class="card single_product_card">
                            <div class="card-body">
                                <div class="single_product">
                                    <div class="breadcrumb_wrap">
                                        <ul class="breadcrumb wizard">
                                            <li class="completed"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                            <li class="completed"><a
                                                    href="{{ route('category.products', ['category' => $single_product->pro_cat->slug]) }}">{{ __($single_product->pro_cat->name) }}</a>
                                            </li>
                                            @if ($single_product->pro_sub_cat)
                                                <li><a
                                                        href="{{ route('category.products', ['category' => $single_product->pro_cat->slug, 'sub-category' => $single_product->pro_sub_cat->slug]) }}">{{ __($single_product->pro_sub_cat->name) }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                        <div class="favorite">
                                            <i class="{{ !empty($single_product->wish()) && !empty($single_product->wish->status) && $single_product->wish->status == 1 ? 'fa-solid' : 'fa-regular' }} fa-heart wish_update"
                                                data-pid="{{ encrypt($single_product->id) }}"></i>
                                        </div>
                                    </div>

                                    <div class="row gx-4">
                                        <div class="col-5 col-xxl-5 col-12 col-md-5 mb-3 mb-sm-0">
                                            <div class="card h-100">
                                                <div class="card-body h-100">
                                                    <div class="product_image xzoom-container">
                                                        @if ($single_product->discount_percentage > 0)
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
                                        <div class="col-7 col-xxl-6 col-12 col-md-7">
                                            <form action="{{ route('u.ck.single') }}" id="single_order_form"
                                                method="POST">
                                                @csrf
                                                <div class="product_content">
                                                    <h1>{{ __($single_product->name) }} </h1>
                                                    <input type="hidden" name="slug"
                                                        value="{{ $single_product->slug }}">

                                                    <p>{{ __(optional($single_product->pro_sub_cat)->name) }}</p>
                                                    <p>{{ __(optional($single_product->generic)->name) }}</p>
                                                    <p>{{ __(optional($single_product->company)->name) }}</p>

                                                    @include('frontend.product.includes.product_price', [
                                                        'single_product' => $single_product,
                                                    ])


                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="product_details pt-4">
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
                                                            <sup class="badge bg-success">{{ $reviews->count() }}</sup></a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="info" role="tabpanel"
                                                        aria-labelledby="info-tab">
                                                        <table class="table table-responsive table-bordered table-striped">
                                                            <tr>
                                                                <td>{{ __(strtoupper('Product Category')) }}</td>
                                                                <td>{{ __(optional($single_product->pro_cat)->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Medicine Name')) }}</td>
                                                                <td>{{ __($single_product->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Generic Name')) }}</td>
                                                                <td>{{ __(optional($single_product->generic)->name) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Medicine Dosage')) }}</td>
                                                                <td>{{ __(optional($single_product->pro_sub_cat)->name) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __(strtoupper('Company Name')) }}</td>
                                                                <td>{{ __(optional($single_product->company)->name) }}</td>
                                                            </tr>
                                                            @if ($single_product->strength_id)
                                                                <tr>
                                                                    <td>{{ __(strtoupper('Product Strength')) }}</td>
                                                                    <td>{{ __(
                                                                        optional($single_product->strength)->quantity .
                                                                            '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ' .
                                                                            optional($single_product->strength)->unit,
                                                                    ) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade ck ck-reset ck-editor ck-rounded-corners"
                                                        id="description" role="tabpanel" aria-labelledby="description-tab">
                                                        {!! $single_product->description !!}
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
                                                                                                data-author="{{ optional($review->customer)->name }}"
                                                                                                href="javascript:void(0)">{{ __('Read More') }}</a>
                                                                                        </p>
                                                                                        <p
                                                                                            class="description text-end mt-2">
                                                                                            <strong>{{ optional($review->customer)->name }}</strong>
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
                        <div class="col-12 col-xxl-3 mt-3 mt-xxl-0">
                            <div class="card similar_products_card" style="height:100%">
                                <div class="card-body px-3 px-xxl-4">
                                    <div class="similar_products">
                                        <h2 class="mb-3 mb-lg-4">{{ __('Similar Products') }}</h2>
                                        <div class="products">
                                            <div class="row align-items-baseline px-0 ">
                                                @foreach ($similar_products as $product)
                                                    <div
                                                        class="col-xxl-12 col-md-4 col-sm-4 col-6 py-2 py-xxl-0 px-2 p-xxl-2">
                                                        <div class="single-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 px-1 px-xxl-2 col-xxl-4 img">
                                                                    <a class="d-block w-100"
                                                                        href="{{ route('product.single_product', $product->slug) }}">
                                                                        <img height=""
                                                                            class="w-100 border border-xxl-1 rounded-1"
                                                                            src="{{ $product->image }}"
                                                                            alt="{{ __($product->name) }}">
                                                                    </a>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-xxl-8 content px-2 px-lg-3 px-xxl-2">

                                                                    <h3 class="pdct-title"
                                                                        title="{{ $product->attr_title }}"><a
                                                                            href="{{ route('product.single_product', $product->slug) }}">{{ $product->formatted_name }}
                                                                        </a></h3>

                                                                    <p class="d-block"><a href=""
                                                                            title="{{ optional($product->pro_sub_cat)->name }}">
                                                                            {{ $product->formatted_sub_cat }}
                                                                        </a></p>
                                                                    <p><a href=""
                                                                            title="{{ optional($product->generic)->name }}">
                                                                            {{ $product->generic_info }}
                                                                        </a></p>
                                                                    <p><a href=""
                                                                            title="{{ optional($product->company)->name }}">
                                                                            {{ $product->company_info }}
                                                                        </a></p>
                                                                    <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                                                            @if ($product->is_tba)
                                                                                <span>{{ __('TBA') }}</span>
                                                                            @else
                                                                                {{ number_format($product->discounted_price, 2) }}
                                                                        </span>

                                                                        @if ($product->discount_percentage > 0)
                                                                            <span class="regular_price">
                                                                                <del>{!! get_taka_icon() !!}
                                                                                    {{ number_format($product->price, 2) }}</del></span>
                                                                        @endif
                                                @endif
                                                </h4>
                                                <!-- add to cart button -->
                                                <div class="add_to_card d-xxl-none d-block">
                                                    @if ($product->is_tba)
                                                        <a class="cart-btn no-cart"
                                                            href="{{ route('product.single_product', $product->slug) }}">
                                                            <i class="fa-solid fa-info"></i>
                                                            <span class="d-block">{{ __('Details') }}</span>
                                                        </a>
                                                    @else
                                                        <a class="cart-btn" href="javascript:void(0)"
                                                            data-product_slug="{{ $product->slug }}">
                                                            <i class="fa-solid fa-cart-plus"></i>
                                                            <span class="d-block">{{ __('Add To Cart') }}</span>
                                                        </a>
                                                    @endif
                                                </div>


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
                                <h2 class="title mb-3 mb-lg-4">{{ __('Related Products') }}</h2>
                            </div>
                            <div class="col-md-12">
                                <div id="related-product-slider" class="owl-carousel">
                                    @foreach ($similar_products as $product)
                                        <div class="px-2 py-1">
                                            <div class="single-pdct">
                                                <a href="{{ route('product.single_product', $product->slug) }}">
                                                    <div class="pdct-img">
                                                        @if ($product->discount_percentage > 0)
                                                            <span
                                                                class="discount_tag">{{ formatPercentageNumber($product->discount_percentage) . '% off' }}</span>
                                                        @endif
                                                        <img class="w-100" src="{{ $product->image }}"
                                                            alt="Product Image">
                                                    </div>
                                                </a>
                                                <div class="pdct-info">
                                                    <div class="product_title">
                                                        <a href="{{ route('product.single_product', $product->slug) }}">
                                                            <h3 class="fw-bold" title="{{ $product->attr_title }}">
                                                                {{ $product->formatted_name }}
                                                            </h3>
                                                        </a>
                                                    </div>
                                                    <div class="all-product-containt">
                                                        <p>
                                                            <a href=""
                                                                title="{{ optional($product->pro_sub_cat)->name }}">
                                                                {{ $product->formatted_sub_cat }}
                                                            </a>
                                                        </p>
                                                        <p>
                                                            <a href="#" class="generic-name"
                                                                title="{{ optional($product->generic)->name }}">
                                                                {{ $product->generic_info }}
                                                            </a>
                                                        </p>
                                                        <p>
                                                            <a href="#" class="company-name"
                                                                title="{{ optional($product->company)->name }}">
                                                                {{ $product->company_info }}
                                                            </a>
                                                        </p>

                                                    </div>
                                                    @if ($product->is_tba)
                                                        <h4><span>{{ __('TBA') }}</span></h4>
                                                        <div class="add_to_card">
                                                            <a class="cart-btn no-cart"
                                                                href="{{ route('product.single_product', $product->slug) }}">
                                                                <i class="fa-solid fa-info"></i>
                                                                <span class="d-block d-xl-none">{{ __('Details') }}</span>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <h4> <span> {!! get_taka_icon() !!}
                                                                {{ number_format($product->discounted_price, 2) }}</span>
                                                            @if ($product->discount_percentage > 0)
                                                                <span class="regular_price">
                                                                    <del>{!! get_taka_icon() !!}
                                                                        {{ number_format($product->price, 2) }}</del></span>
                                                            @endif
                                                        </h4>
                                                        <div class="add_to_card">
                                                            <a class="cart-btn" href="javascript:void(0)"
                                                                data-product_slug="{{ $product->slug }}">
                                                                <i class="fa-solid fa-cart-plus"></i>
                                                                <span
                                                                    class="d-block d-xl-none">{{ __('Add To Cart') }}</span>
                                                            </a>
                                                        </div>
                                                    @endif


                                                    <!-- add to cart button -->

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
    <script src="{{ asset('frontend/asset/js/single_price_handle.js') }}"></script>
@endpush
@push('js')
    <script>
        let errors = "{!! json_encode($errors->all()) !!}";
        if (errors.length > 0) {
            errors.forEach(function(error) {
                toastr.error(error);
            });
        }
    </script>
@endpush
