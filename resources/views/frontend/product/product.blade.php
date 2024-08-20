@extends('frontend.layouts.master')
@section('title', 'Products')
@section('content')
    <div class="row pt-4">
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @if ($menuItems->isNotEmpty())
            @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
        @endif
        <!--=========== Sidebar-Category-Section-Include  ==============-->


        <!--=========== Main Content Section Start ==============-->
        <div class="{{ $menuItems->isNotEmpty() ? 'col-md-9 col-lg-10' : 'col-12' }} content-col">
            <!--========= Product-Section-Start ========-->
            <section class="product-section pb-4 mb-5">
                <div class="row">
                    {{-- @if ($featuredItems->isNotEmpty()) --}}
                    <div class="col-12">
                        <div class="row cat-filter-row gx-4">
                            <div class="col-12">
                                <h2 class="title">{{ __(isset($category) ? $category->name : 'All Products') }}</h2>
                            </div>
                            @if (isset($sub_categories) && $sub_categories->isNotEmpty())
                                <div class="col-12">
                                    <div class="sub_categories my-5" uk-slider="finite: true">
                                        <div class="uk-position-relative">
                                            <div class="uk-slider-container uk-light">
                                                <ul class="uk-slider-items cat-list">
                                                    @foreach ($sub_categories as $key => $sub_cats)
                                                        @foreach ($sub_cats as $sub_cat)
                                                            <li
                                                                class="sub_cat_item {{ $key == 0 ? 'uk-slide-active active' : '' }}">
                                                                <a href="javascript:void(0)" class="sub_cat_link"
                                                                    data-cat_slug="{{ isset($category) ? $category->slug : 'all' }}"
                                                                    data-sub_cat_slug="{{ $sub_cat->slug }}">
                                                                    <div
                                                                        class="card {{ isset($sub_category) && $sub_category->id == $sub_cat->id ? ' active' : '' }}">
                                                                        <img class="sub_cat_img"
                                                                            src="{{ storage_url($sub_cat->image) }}"
                                                                            alt="{{ $sub_cat->name }}">
                                                                        <div class="category_name"
                                                                            title="{{ $sub_cat->pro_cat->name }}">
                                                                            <h3>{{ str_limit($sub_cat->pro_cat->name, 12, '..') }}
                                                                            </h3>
                                                                        </div>
                                                                        <div class="sub_category_name"
                                                                            title="{{ $sub_cat->name }}">
                                                                            <h3>{{ str_limit($sub_cat->name, 12, '..') }}
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="uk-hidden@s uk-light btn-arrow">
                                                <a class="uk-position-center-left uk-position-small" href
                                                    uk-slidenav-previous uk-slider-item="previous"></a>
                                                <a class="uk-position-center-right uk-position-small" href uk-slidenav-next
                                                    uk-slider-item="next"></a>
                                            </div>

                                            <div class="uk-visible@sbtn-arrow">
                                                <a class="uk-position-center-left-out uk-position-small" href
                                                    uk-slidenav-previous uk-slider-item="previous"></a>
                                                <a class="uk-position-center-right-out uk-position-small" href
                                                    uk-slidenav-next uk-slider-item="next"></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="row all-products mt-3">
                            @foreach ($products as $product)
                                @php
                                    $proDisPrice = proDisPrice($product->price, $product->discounts);
                                @endphp
                                <div class="col-2 px-2 single-pdct-wrapper">
                                    <div class="single-pdct">
                                        <a href="{{ route('product.single_product', $product->slug) }}">
                                            <div class="pdct-img">
                                                @if ($proDisPrice != $product->price)
                                                    <span
                                                        class="discount_tag">{{ formatPercentageNumber($product->discount_percentage) . '% 0ff' }}</span>
                                                @endif
                                                <img class="w-100" src="{{ $product->image }}" alt="Product Image">
                                            </div>
                                        </a>
                                        <div class="pdct-info">
                                            <a href="generic-name" class="generic-name">
                                                {{ $product->generic->name }}
                                            </a>
                                            <a href="" class="company-name">
                                                {{ $product->company->name }}
                                            </a>

                                            <div class="product_title">
                                                <a href="{{ route('product.single_product', $product->slug) }}">
                                                    <h3 class="fw-bold" title="{{ $product->attr_title }}">
                                                        {{ $product->name }}
                                                    </h3>
                                                </a>
                                            </div>
                                            <h4> <span> {!! get_taka_icon() !!} {{ number_format($proDisPrice, 2) }}</span>
                                                @if ($proDisPrice != $product->price)
                                                    <span class="regular_price"> <del>{!! get_taka_icon() !!}
                                                            {{ number_format($product->price, 2) }}</del></span>
                                                @endif
                                            </h4>
                                            <div class="add_to_card">
                                                <a class="cart-btn" data-product_slug="{{ $product->slug }}"
                                                    data-unit_id="{{ $product->units[0]['id'] }}"
                                                    href="javascript:void(0)">
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (count($products) >= 1)
                            <div class="row show-more mt-5">
                                <a class="all-pdct-btn text-center more"
                                    data-cat_slug="{{ isset($category) ? $category->slug : 'all' }}"
                                    data-sub_cat_slug="{{ isset($sub_category) ? $sub_category->slug : '' }}"
                                    data-offset="1" href="javascript:void(0)">{{ __('SEE MORE') }}</a>
                            </div>
                        @endif
                    </div>
                    {{-- @endif --}}
                </div>
            </section>

        </div>
        <!--=========== Main Content Section End ==============-->
    </div>
@endsection
@push('js')
    <script>
        const datas = {
            'single_product': `{{ route('product.single_product', ['slug']) }}`,
            'cat_products': `{{ route('category.products', ['category' => 'cat_slug', 'sub-category' => 'sub_cat_slug']) }}`,
            'more_products': `{{ route('category.products', ['category' => 'cat_slug', 'offset' => '_offset', 'sub-category' => 'sub_cat_slug']) }}`,
        };
        const taka_icon = `{!! get_taka_icon() !!}`;
    </script>
    <script src="{{ asset('frontend/asset/js/products.js') }}"></script>
@endpush
