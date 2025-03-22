@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
    <div class="row pt-3 pt-lg-4">

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



            <!--========= Product-Section-Start ========-->
            <section class="product-section mb-4 mb-lg-5">
                <div class="row align-items-baseline">
                    @if ($bsItems->isNotEmpty())
                        <div class="col-12 col-xl-3 best-selling-col mb-3 mb-xl-0">
                            <h2 class="title mb-0 mb-lg-2 mb-xl-3">{{ __('Medical Devices') }}</h2>
                            <div class="best-selling-products">
                                <div class="all-product">
                                    <div class="row medical-devices">
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
                                                                <h3 class="pdct-title mb-0" title="{{ $item->attr_title }}">
                                                                    <a
                                                                        href="{{ route('product.single_product', $item->slug) }}">{{ $item->formatted_name }}</a>
                                                                </h3>


                                                                <div class="all-product-containt">
                                                                    <p title="{{ optional($item->strength)->name }}"><a
                                                                            href="">{{ $item->strength_info }}</a>
                                                                    </p>
                                                                    <p class="d-block d-xl-none"><a href=""
                                                                            title="{{ optional($item->pro_sub_cat)->name }}">
                                                                            {{ $item->formatted_sub_cat }}
                                                                        </a></p>
                                                                    <p><a href=""
                                                                            title="{{ optional($item->generic)->name }}">
                                                                            {{ $item->generic_info }}
                                                                        </a></p>
                                                                    <p><a href=""
                                                                            title="{{ optional($item->company)->name }}">
                                                                            {{ $item->company_info }}
                                                                        </a>
                                                                    </p>
                                                                </div>

                                                                @if ($item->is_tba)
                                                                    <h4><span>{{ __('TBA') }}</span></h4>
                                                                    <div class="add_to_card d-block d-xl-none mt-2">
                                                                        <a class="cart-btn no-cart"
                                                                            href="{{ route('product.single_product', $item->slug) }}">
                                                                            <i class="fa-solid fa-info"></i>
                                                                            <span
                                                                                class="d-block d-xl-none">{{ __('Details') }}</span>
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                                                            {{ number_format($item->discounted_price, 2) }}</span>
                                                                        @if ($item->discount_percentage > 0)
                                                                            <span class="regular_price">
                                                                                <del>{!! get_taka_icon() !!}
                                                                                    {{ number_format($item->price, 2) }}</del></span>
                                                                        @endif
                                                                    </h4>
                                                                    <!-- add to cart button -->
                                                                    <div class="add_to_card d-block d-xl-none mt-2">
                                                                        <a class="cart-btn"
                                                                            data-product_slug="{{ $item->slug }}"
                                                                            data-unit_id="" href="javascript:void(0)">
                                                                            <i class="fa-solid fa-cart-plus"></i>
                                                                            <span
                                                                                class="d-block d-xl-none">{{ __('Add To Cart') }}</span>
                                                                        </a>
                                                                    </div>
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
                    @endif
                    @if ($featuredCategories->isNotEmpty())
                        <div class="col-12 col-xl-9 feature-product">
                            <div class="row cat-filter-row gx-4 align-items-center justify-content-between">
                                <div class="col-12 ">
                                    <h2 class="title">{{ __('Featured Products') }}</h2>
                                </div>

                                <div class="col-12 col-md-7 col-xxl-8 col-lg-6 d-none">
                                    <div class="slider-col" uk-slider="finite: true">
                                        <div class="uk-position-relative">
                                            <div class="uk-slider-container uk-light">
                                                <ul
                                                    class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s
uk-child-width-1-5@m cat-list">
                                                    <li
                                                        class=" active d-flex align-content-center justify-content-center m-auto ">
                                                        <a href="javascript:void(0)" class="featured_category"
                                                            data-slug="all">{{ __('All') }}</a>
                                                    </li>
                                                    @foreach ($featuredCategories as $category)
                                                        <li
                                                            class="d-flex align-content-center justify-content-center m-auto">
                                                            <a href="javascript:void(0)" class="featured_category"
                                                                data-slug="{{ $category->slug }}">{{ __($category->name) }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>


                                            </div>

                                            <div class="uk-light btn-arrow">
                                                <a class="uk-position-center-left uk-position-small" href
                                                    uk-slidenav-previous uk-slider-item="previous"></a>
                                                <a class="uk-position-center-right uk-position-small" href uk-slidenav-next
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
                                                    @if ($product->discount_percentage > 0)
                                                        <span
                                                            class="discount_tag">{{ formatPercentageNumber($product->discount_percentage) . '% 0ff' }}</span>
                                                    @endif
                                                    <img class="w-100" src="{{ $product->image }}" alt="Product Image">
                                                </div>
                                            </a>
                                            <div class="pdct-info">

                                                <div class="product_title">
                                                    <a href="{{ route('product.single_product', $product->slug) }}">
                                                        <h3 class="fw-bold mb-0" title="{{ $product->attr_title }}">
                                                            {{ $product->formatted_name }}
                                                        </h3>
                                                    </a>
                                                </div>

                                                <div class="all-product-containt">

                                                    <p>
                                                        <a href=""
                                                            title="{{ optional($product->strength)->name }}">{{ $product->strength_info }}</a>
                                                    </p>
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
                                                    <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                                            {{ number_format($product->discounted_price, 2) }}</span>
                                                        @if ($product->discount_percentage > 0)
                                                            <span class="regular_price"> <del>{!! get_taka_icon() !!}
                                                                    {{ number_format($product->price, 2) }}</del></span>
                                                        @endif
                                                    </h4>
                                                    <!-- add to cart button -->

                                                    <div class="add_to_card">
                                                        <a class="cart-btn" data-product_slug="{{ $product->slug }}"
                                                            data-unit_id="" href="javascript:void(0)">
                                                            <i class="fa-solid fa-cart-plus"></i>
                                                            <span class="d-block d-xl-none">{{ __('Add To Cart') }}</span>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row show-more mt-3 mt-lg-4"
                                @if (count($products) < 8) style="display:none;" @endif>
                                <a class="all-pdct-btn text-center"
                                    href="{{ route('category.products', ['category' => 'all', 'featured' => true]) }}">{{ __('All Products') }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
            <!--====== Delivery Slider Section ======-->
            <section class="delivery-slider-section">
                <div class="uk-position-relative uk-visible-toggle uk-light delivery-main-slide" tabindex="-1"
                    uk-slider="">

                    <div class="uk-slider-items uk-child-width-1-1 uk-grid-remove">
                        <!-- Slide 1 -->
                        <div class="bottom-slide-items">
                            <div class="uk-panel">
                                <img src="{{ asset('frontend/asset/img/bottom-slider/slider-1.jpg') }}"
                                    alt="slider image">
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="bottom-slide-items">
                            <div class="uk-panel">
                                <img src="{{ asset('frontend/asset/img/bottom-slider/newslider-1.jpg') }}"
                                    alt="slider image">
                            </div>
                        </div>
                    </div>

                    <!-- Navigation arrows -->
                    <a class="uk-position-center-left uk-slider-arrow" href uk-slidenav-previous
                        uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-slider-arrow" href uk-slidenav-next uk-slider-item="next"></a>

                    <!-- Slider dots navigation -->
                    <ul class="uk-slider-nav uk-dotnav uk-flex-center"></ul>
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
