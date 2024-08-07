@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
    <div class="row pt-4">
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @if ($menuItems->isNotEmpty())
            @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
        @endif
        <!--=========== Sidebar-Category-Section-Include  ==============-->


        <!--=========== Main Content Section Start ==============-->
        <div class="{{ $menuItems->isNotEmpty() ? 'col-md-9 col-lg-10' : 'col-12' }} content-col">
            <!--========= Slider-Section-Include ========-->
            @include('frontend.includes.home.slider')
            <!--========= Slider-Section-Include ========-->

            <!--========= Product-Section-Start ========-->
            <section class="product-section pb-4 mb-5">
                <div class="row">
                    @if ($bsItems->isNotEmpty())
                        <div class="col-3 best-selling-col">
                            <h2 class="title mb-3">{{ __('Best Selling') }}</h2>
                            <div class="best-selling-products">
                                <div class="all-product">
                                    @foreach ($bsItems as $item)
                                        <div class="col-12 single-item">
                                            <div class="row align-items-center">
                                                <div class="col-4 img">
                                                    <a href="{{ route('product.single_product', $item->slug) }}"></a>
                                                    <img height="90" class="w-100 border border-1 rounded-1"
                                                        src="{{ $item->image }}" alt="{{ $item->name }}">
                                                    </a>
                                                </div>
                                                <div class="col-8">
                                                    <h3 class="pdct-title" title="{{ $item->attr_title }}"><a
                                                            href="{{ route('product.single_product', $item->slug) }}">{{ $item->name }}</a>
                                                    </h3>
                                                    <p><a href="">{{ $item->pro_sub_cat->name }}</a>
                                                    </p>
                                                    <p><a href="">{{ $item->generic->name }}</a></p>
                                                    <p><a href="">{{ $item->company->name }}</a></p>
                                                    <h4 class="pdct-price"> <span> {!! get_taka_icon() !!}
                                                            {{ number_format($item->discounted_price, 2) }}</span>
                                                        @if ($item->discounted_price != $item->price)
                                                            <span class="regular_price"> <del>{!! get_taka_icon() !!}
                                                                    {{ number_format($item->price, 2) }}</del></span>
                                                        @endif
                                                    </h4>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($featuredCategories->isNotEmpty())
                        <div class="col-9">
                            <div class="row cat-filter-row gx-4">
                                <div class="col-3">
                                    <h2 class="title">{{ __('Featured Products') }}</h2>
                                </div>

                                <div class="col-8">
                                    <div class="slider-col" uk-slider="finite: true">
                                        <div class="uk-position-relative">
                                            <div class="uk-slider-container uk-light">
                                                <ul
                                                    class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m cat-list">
                                                    <li class="text-right active" style="text-align: right;">
                                                        <a href="javascript:void(0)" class="featured_category"
                                                            data-slug="all">{{ _('All') }}</a>
                                                    </li>
                                                    @foreach ($featuredCategories as $category)
                                                        <li><a href="javascript:void(0)" class="featured_category"
                                                                data-slug="{{ $category->slug }}">{{ __($category->name) }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="uk-hidden@s uk-light btn-arrow">
                                                <a class="uk-position-center-left uk-position-small" href
                                                    uk-slidenav-previous uk-slider-item="previous"></a>
                                                <a class="uk-position-center-right uk-position-small" href uk-slidenav-next
                                                    uk-slider-item="next"></a>
                                            </div>

                                            <div class="uk-visible@s
btn-arrow">
                                                <a class="uk-position-center-left-out uk-position-small" href
                                                    uk-slidenav-previous uk-slider-item="previous"></a>
                                                <a class="uk-position-center-right-out uk-position-small" href
                                                    uk-slidenav-next uk-slider-item="next"></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row all-products mt-3">
                                @foreach ($products as $product)
                                    <div class="col-3 px-2 single-pdct-wrapper">
                                        <div class="single-pdct">
                                            <a href="{{ route('product.single_product', $product->slug) }}">
                                                <div class="pdct-img">
                                                    @if ($product->discounted_price != $product->price)
                                                        <span
                                                            class="discount_tag">{{ formatPercentageNumber($product->discount_percentage) . '% 0ff' }}</span>
                                                    @endif
                                                    <img class="w-100" src="{{ $product->image }}" alt="Product Image">
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
                                                    <a href="{{ route('product.single_product', $product->slug) }}">
                                                        <h3 class="fw-bold" title="{{ $product->attr_title }}">
                                                            {{ $product->name }}
                                                        </h3>
                                                    </a>
                                                </div>

                                                <h4> <span> {!! get_taka_icon() !!}
                                                        {{ number_format($product->discounted_price, 2) }}</span>
                                                    @if ($product->discounted_price != $product->price)
                                                        <span class="regular_price"> <del>{!! get_taka_icon() !!}
                                                                {{ number_format($product->price, 2) }}</del></span>
                                                    @endif
                                                </h4>

                                                <div class="add_to_card">
                                                    <a class="cart-btn" data-product_slug="{{ $product->slug }}"
                                                        data-unit_id="" href="javascript:void(0)">
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row show-more mt-5" @if (count($products) < 8) style="display:none;" @endif>
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
                                    <div class="carousel-caption d-none d-md-block">
                                        <h2>Shop Online or In store Get</h2>
                                        <a href="#">Free</a>
                                        <h3>Delivery</h3>
                                        <h4>at Your Door</h4>
                                    </div>
                                </li>
                                <li>
                                    <img src="{{ asset('frontend/asset/img/slider-bg-01.jpg') }}" alt="" uk-cover>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h2>Shop Online or In store Get</h2>
                                        <a href="#">Free</a>
                                        <h3>Delivery</h3>
                                        <h4>at Your Door</h4>
                                    </div>
                                </li>
                                <li>
                                    uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                    <img src="{{ asset('frontend/asset/img/slider-bg-01.jpg') }}" alt="" uk-cover>
                                    <div class="carousel-caption d-none d-md-block">
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
