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
                                                        src="{{ storage_url($item->image) }}" alt="{{ $item->name }}">
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
                                                   
                                                        <h4 class="pdct-price"> <span> &#2547; {{ number_format($item->price,2) }}</span>
                                                            @if (productDiscountPercentage($item->id))
                                                             <span class="regular_price"> <del>&#2547; {{ number_format($item->regular_price,2) }}</del></span> 
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
                    @if ($featuredItems->isNotEmpty())
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
                                                        <a href="javascript:void(0)" class="featured_item"
                                                            data-id="all">{{ _('All') }}</a>
                                                    </li>
                                                    @foreach ($featuredItems as $item)
                                                        <li><a href="javascript:void(0)" class="featured_item"
                                                                data-slug="{{ $item->slug }}">{{ __($item->name) }}</a>
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
                                                    @if (productDiscountPercentage($product->id))
                                                    <span class="discount_tag">{{  number_format($product->discount_percentage)."% 0ff"}}</span>
                                                    @endif
                                                    <img class="w-100" src="{{ storage_url($product->image) }}"
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
                                                    <a href="{{ route('product.single_product', $product->slug) }}">
                                                        <h3 class="fw-bold" title="{{ $product->attr_title }}">
                                                            {{ $product->name }}
                                                        </h3>
                                                    </a>
                                                </div>
                                                
                                                <h4> <span> &#2547; {{ number_format($product->price,2) }}</span> 
                                                    @if (productDiscountPercentage($product->id))
                                                        <span class="regular_price"> <del>&#2547; {{ number_format($product->regular_price,2) }}</del></span> 
                                                    @endif
                                                </h4>
                                                
                                                <div class="add_to_card">
                                                    <a class="cart-btn" data-product_slug="{{ $product->slug }}" data-unit_id="{{$product->units[0]['id']}}"
                                                        href="javascript:void(0)">
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if (count($products) >= 8)
                                <div class="row show-more mt-5">
                                    <a class="all-pdct-btn text-center"
                                        href="{{ route('category.products', ['category' => 'all']) }}">{{ __('All Products') }}</a>
                                </div>
                            @endif
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

        function numberFormat(value, decimals) {
            return parseFloat(value).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        $(document).ready(function() {
            $('.featured_item').on('click', function() {
                $('.cat-list li').removeClass('active');
                $('.cat-list li').removeClass('uk-slide-active');
                $(this).parent('li').addClass('active');
                let slug = $(this).data('slug');
                let url = ("{{ route('home.featured_products', ['category' => 'slug']) }}");
                let _url = url.replace('slug', slug);

                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let slug = data.product_cat ? data.product_cat.slug : 'all';
                        let all_product_route = (
                            "{{ route('category.products', ['category' => 'slug']) }}");
                        let _all_product_route = all_product_route.replace('slug', slug);
                        $('.all-pdct-btn').attr('href', _all_product_route);
                       
                        
                        var result = '';
                        data.products.forEach(function(product) {
                            let discount_percentage = '';
                            let discount_amount = '';
                            if(product.discount_percentage){
                                discount_percentage = `<span class="discount_tag">${numberFormat(product.discount_percentage)}% 0ff</span>`
                            }
                            
                            if(product.discount_percentage){
                                discount_amount = `<span class="regular_price"> <del>&#2547; ${numberFormat(product.regular_price,2)}</del></span>`
                            }
                            let route = (
                                "{{ route('product.single_product', ['slug']) }}");
                            let _route = route.replace('slug', product.slug);
                            result += `
                                <div class="col-3 px-2">
                                    <div class="single-pdct">
                                            <a href="${_route}">
                                                <div class="pdct-img">
                                                    ${discount_percentage}
                                                    <img class="w-100"
                                                        src="${product.image}"
                                                        alt="Product Image">
                                                </div>
                                            </a>
                                            <div class="pdct-info">
                                                <a href="#" class="generic-name">
                                                    ${product.generic.name}
                                                </a>
                                                <a href="#" class="company-name">
                                                    ${product.company.name}
                                                </a>

                                                <div class="product_title">
                                                    <a href="${_route}">
                                                    <h3 class="fw-bold">
                                                        ${product.name}
                                                    </h3>
                                                </a>
                                                </div>
                                                <h4> <span> &#2547; ${numberFormat(product.price,2)}</span>  ${discount_amount}</h4>
                                                <div class="add_to_card">
                                                    <a class="cart-btn" data-product_slug="${product.slug}" data-unit_id="${product.units[0]['id']}" href="javascript:void(0)">
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                            `;
                        });
                        $('.all-products').html(result);
                        if (data.products.length >= 8) {
                            $('.show-more').show();
                        } else {
                            $('.show-more').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });

            var featured_pro_height = $('.all-products').height();
            $('.best-selling-products').height(featured_pro_height + "px")
        });
    </script>
@endpush
