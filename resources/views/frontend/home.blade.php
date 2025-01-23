@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
<div class="row pt-3 pt-lg-4">
    <!--===========  Sidebar-Category-Section-Include ==============-->
    <!-- <div class="col-3 col-xxl-2 col-12 col-lg-3 d-none d-lg-block home-cat-sidebar">
                    @if ($menuItems->isNotEmpty())
    @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
    @endif
                </div> -->

    <!--=========== slider-section-include ==============-->
    <div class="d-block d-lg-none">
        @include('frontend.includes.home.slider')
    </div>
    <!--=========== slider-section-include ==============-->

    <!--=========== Sidebar-Category-Section-Include  ==============-->
    @if ($menuItems->isNotEmpty())
    @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
    @endif
    <!--=========== Sidebar-Category-Section-Include  ==============-->



    <!--=========== Main Content Section Start ==============-->
    <div class="{{ $menuItems->isNotEmpty() ? 'col-8 col-xxl-10 col-12 col-lg-9 content-col' : 'col-12' }} content-col">

        <!--========= Slider-Section-Include ========-->
        <div class="d-none d-lg-block">
            @include('frontend.includes.home.slider')
        </div>
        <!--========= Slider-Section-Include ========-->

        <!--========= Slider-Section-Include ========-->
        <!-- @include('frontend.includes.home.slider') -->
        <!--========= Slider-Section-Include ========-->


        <!--===========  Sidebar-Category-Section-Include ==============-->
        <!-- <div class="d-block d-lg-none">
                    @if ($menuItems->isNotEmpty())
    @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
    @endif
                </div> -->
        <!--=========== Sidebar-Category-Section-Include  ==============-->


        <!--========= Product-Section-Start ========-->
        <section class="product-section mb-4 mb-lg-5">
            <div class="row align-items-baseline">
                @if ($bsItems->isNotEmpty())
                <div class="col-12 col-xl-3 best-selling-col mb-3 mb-xl-0">
                    <h2 class="title mb-0 mb-lg-2 mb-xl-3">{{ __('Best Selling') }}</h2>
                    <div class="best-selling-products">
                        <div class="all-product">
                            <div class="row m-0">
                                @foreach ($bsItems as $item)
                                <div
                                    class="col-xxl-12 col-xl-12 col-lg-4 col-md-3 col-sm-4 col-6 px-2 px-xl-3 py-2 py-xl-0">
                                    <div class="single-item">
                                        <div class=" row align-items-center">
                                            {{-- <div class=""> --}}
                                                <div class="col-12 px-xxl-2 col-xxl-4 img">
                                                    <a href="{{ route('product.single_product', $item->slug) }}">
                                                        <img height="90"
                                                            class="w-100 border border-1 rounded-1 lg-rounded-0"
                                                            src="{{ $item->image }}" alt="{{ $item->name }}">
                                                    </a>
                                                </div>
                                                <div class="col-12 px-xxl-1 col-xxl-8">
                                                    <div class="bst-product-content mt-xl-2 mt-lg-2 mt-xxl-0">
                                                        <h3 class="pdct-title" title="{{ $item->attr_title }}"><a
                                                                href="{{ route('product.single_product', $item->slug) }}">{{
                                                                $item->name }}</a>
                                                        </h3>
                                                        <p class="d-block d-xl-none"><a href=""
                                                                title="{{ optional($item->pro_sub_cat)->name }}">
                                                                {{ optional($item->pro_sub_cat)->name }}
                                                            </a></p>
                                                        <p><a href="" title="{{ optional($item->generic)->name }}">
                                                                {{ optional($item->generic)->name }}
                                                            </a></p>
                                                        <p><a href="" title="{{ optional($item->company)->name }}">
                                                                {{ optional($item->company)->name }}
                                                            </a></p>
                                                        <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                                                {{ number_format($item->discounted_price, 2) }}</span>
                                                            @if ($item->discounted_price != $item->price)
                                                            <span class="regular_price">
                                                                <del>{!! get_taka_icon() !!}
                                                                    {{ number_format($item->price, 2) }}</del></span>
                                                            @endif
                                                        </h4>

                                                        <!-- add to cart button -->
                                                        <div class="add_to_card d-block d-xl-none mt-2">
                                                            <a class="cart-btn" data-product_slug="{{ $item->slug }}"
                                                                data-unit_id="" href="javascript:void(0)">
                                                                <i class="fa-solid fa-cart-plus"></i>
                                                                <span class="d-block d-xl-none">Add To Cart</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                                {{--
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                @if ($featuredCategories->isNotEmpty())
                <div class="col-12 col-xl-9 feature-product">
                    <div class="row cat-filter-row gx-4 align-items-center justify-content-between">
                        <div class="col-12 col-md-4 col-xxl-3 col-lg-5">
                            <h2 class="title">{{ __('Featured Products') }}</h2>
                        </div>

                        <div class="col-12 col-md-7 col-xxl-8 col-lg-6">
                            <div class="slider-col" uk-slider="finite: true">
                                <div class="uk-position-relative">
                                    <div class="uk-slider-container uk-light">
                                        <ul
                                            class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m cat-list">
                                            <li
                                                class=" active d-flex align-content-center justify-content-center m-auto ">
                                                <a href="javascript:void(0)" class="featured_category"
                                                    data-slug="all">{{ _('All') }}</a>
                                            </li>
                                            @foreach ($featuredCategories as $category)
                                            <li class="d-flex align-content-center justify-content-center m-auto">
                                                <a href="javascript:void(0)" class="featured_category"
                                                    data-slug="{{ $category->slug }}">{{ __($category->name) }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="uk-hidden@s uk-light btn-arrow">
                                        <a class="uk-position-center-left uk-position-small" href uk-slidenav-previous
                                            uk-slider-item="previous"></a>
                                        <a class="uk-position-center-right uk-position-small" href uk-slidenav-next
                                            uk-slider-item="next"></a>
                                    </div>

                                    <div class="uk-visible@s
btn-arrow">
                                        <a class="uk-position-center-left-out uk-position-small" href
                                            uk-slidenav-previous uk-slider-item="previous"></a>
                                        <a class="uk-position-center-right-out uk-position-small" href uk-slidenav-next
                                            uk-slider-item="next"></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="all-products row">
                        @foreach ($products as $product)
                        <div class="single-pdct-wrapper col-xxl-3 col-lg-4 col-md-3 col-sm-4 col-6 py-2 px-2">
                            <div class="single-pdct">
                                <a href="{{ route('product.single_product', $product->slug) }}">
                                    <div class="pdct-img">
                                        @if ($product->discounted_price != $product->price)
                                        <span class="discount_tag">{{
                                            formatPercentageNumber($product->discount_percentage) . '% 0ff' }}</span>
                                        @endif
                                        <img class="w-100" src="{{ $product->image }}" alt="Product Image">
                                    </div>
                                </a>
                                <div class="pdct-info">

                                    <div class="product_title">
                                        <a href="{{ route('product.single_product', $product->slug) }}">
                                            <h3 class="fw-bold" title="{{ $product->attr_title }}">
                                                {{ $product->name }}
                                            </h3>
                                        </a>
                                    </div>
                                    <p><a href="" title="{{ optional($product->pro_sub_cat)->name }}">
                                            {{ optional($product->pro_sub_cat)->name }}
                                        </a></p>
                                    <p><a href="#" class="generic-name" title="{{ optional($product->generic)->name }}">
                                            {{ optional($product->generic)->name }}
                                        </a></p>
                                    <p><a href="#" class="company-name" title="{{ optional($product->company)->name }}">
                                            {{ optional($product->company)->name }}
                                        </a></p>
                                    <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                            {{ number_format($product->discounted_price, 2) }}</span>
                                        @if ($product->discounted_price != $product->price)
                                        <span class="regular_price"> <del>{!! get_taka_icon() !!}
                                                {{ number_format($product->price, 2) }}</del></span>
                                        @endif
                                    </h4>

                                    <!-- add to cart button -->

                                    <div class="add_to_card">
                                        <a class="cart-btn" data-product_slug="{{ $product->slug }}" data-unit_id=""
                                            href="javascript:void(0)">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            <span class="d-block d-xl-none">Add To Cart</span>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>


                    <div class="row show-more mt-3 mt-lg-4" @if (count($products) < 8) style="display:none;" @endif>
                        <a class="all-pdct-btn text-center"
                            href="{{ route('category.products', ['category' => 'all']) }}">{{ __('All Products') }}</a>
                    </div>
                </div>
                @endif
            </div>
        </section>
        <!--====== Delivery Slider Section ======-->
        <section class="delivery-slider-section">
            <div class="row">
                <div class="col">
                    <div uk-slideshow>
                        <ul class="uk-slideshow-items">
                            <li>
                                <img src="{{ asset('frontend/asset/img/slider-bg-02.jpg') }}" alt="" uk-cover>
                                <div class="carousel-caption">
                                    <h2>Shop Online or In store Get</h2>
                                    <a href="#">Free</a>
                                    <h3>Delivery</h3>
                                    <h4>at Your Door</h4>
                                </div>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/asset/img/slider-bg-01.jpg') }}" alt="" uk-cover>
                                <div class="carousel-caption">
                                    <h2>Shop Online or In store Get</h2>
                                    <a href="#">Free</a>
                                    <h3>Delivery</h3>
                                    <h4>at Your Door</h4>
                                </div>
                            </li>
                            <li>
                                uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                <img src="{{ asset('frontend/asset/img/slider-bg-01.jpg') }}" alt="" uk-cover>
                                <div class="carousel-caption">
                                    <h2>Shop Online or In store Get</h2>
                                    <a href="#">Free</a>
                                    <h3>Delivery</h3>
                                    <h4>at Your Door</h4>
                                </div>
                            </li>
                        </ul>
                        <ul class="uk-slideshow-nav uk-dotnav uk-flex-center "></ul>
                    </div>
                </div>
            </div>
            <div class="row delivery-bike">
                <img src="{{ asset('frontend/asset/img/inner-jbanner.png') }}" alt="">
            </div>
        </section>
    </div>
    <!--=========== Main Content Section End ==============-->
</div>
@endsection
@push('js')
<script>
    const datas = {
            'featured_products': `{{ route('home.featured_products', ['category' => 'slug']) }}`,
            'all_products': `{{ route('category.products', ['category' => 'slug']) }}`,
            'single_product': `{{ route('product.single_product', ['slug']) }}`,
        };
        const taka_icon = `{!! get_taka_icon() !!}`;
</script>
<script src="{{ asset('frontend/asset/js/home.js') }}"></script>
@endpush