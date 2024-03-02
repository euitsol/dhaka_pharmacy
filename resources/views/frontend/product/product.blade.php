@extends('frontend.layouts.master')
@section('title', 'Home')
@push('css')
    <style>
        .product-section .sub_categories .cat-list{
            left: -10px;
        }
        .product-section .sub_categories .uk-position-center-left-out {
            right: 95.5%;
        }
        .product-section .sub_categories .uk-position-center-right-out {
            left: 95.5%;
        }
        .product-section .sub_categories svg {
            background: var(--secondary-bg);
            color: var(--text-color-white);
            border: 1px solid var(--text-color-white);
            height: 40px;
            width: 40px;
            border-radius: 50%;
            padding: 3px;
        }
        .product-section .sub_categories .sub_cat_item{
            padding: 0 10px;
            overflow: hidden;
            transition: .4s;
        }
        
        .product-section .sub_categories .sub_cat_link {
            display: inline-block;
        }
        .product-section .sub_categories .sub_cat_link .sub_cat_img {
            height: 100px;
            width: 140px;
            object-fit: contain;
            transition: .4s;
        }
        .product-section .sub_categories .sub_cat_link .card-title {
            transition: .4s;
        }
        .product-section .sub_categories .sub_cat_item:hover .card{
            border-color: var(--asent-color);
        }
        .product-section .sub_categories .sub_cat_item:hover .card-title{
            transform: scale(1.1);
            font-weight: bold;
            
        }
        .product-section .sub_categories .sub_cat_item .card.active{
            border-color: var(--asent-color);
        }
        .product-section .sub_categories .sub_cat_item .card.active .card-title{
            transform: scale(1.1);
            font-weight: bold;
            
        }
        .product-section .sub_categories .card{
            transition: .4s;
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
            <!--========= Product-Section-Start ========-->
            <section class="product-section pb-4 mb-5">
                <div class="row">
                    {{-- @if ($featuredItems->isNotEmpty()) --}}
                        <div class="col-12">
                            <div class="row cat-filter-row gx-4">
                                <div class="col-12">
                                    <h2 class="title">{{ __($category->name) }}</h2>
                                </div>
                                @if ($sub_categories->isNotEmpty())
                                    <div class="col-12">
                                        <div class="sub_categories my-5" uk-slider="finite: true">
                                            <div class="uk-position-relative">
                                                <div class="uk-slider-container uk-light">
                                                    <ul class="uk-slider-items cat-list">
                                                        @foreach ($sub_categories as $key=>$sub_cat)
                                                            <li class="sub_cat_item {{($key == 0) ? 'uk-slide-active active' : ''}}">
                                                                <a href="{{route('category.products',[$category->slug,$sub_cat->slug])}}" class="sub_cat_link" data-id="{{$sub_cat->id}}">
                                                                    <div class="card {{ (isset($sub_category) && ($sub_category->id == $sub_cat->id)) ? ' active' : ''}}">
                                                                        <img class="sub_cat_img" src="{{storage_url($sub_cat->image)}}" alt="{{$sub_cat->name}}">
                                                                        <div class="card-title">
                                                                            {{ __(str_limit($sub_cat->name,12,'..')) }}
                                                                        </div>
                                                                    </div>
                                                                </a>
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
                                    <div class="col-2 px-2 single-pdct-wrapper">
                                        <div class="single-pdct">
                                            <a href="{{ route('product.single_product', $product->slug) }}">
                                                <div class="pdct-img">
                                                    <img class="w-100"
                                                        src="{{ storage_url($product->image)}}"
                                                        alt="Product Image">
                                                </div>
                                            </a>
                                            <div class="pdct-info">
                                                {{-- <p><a
                                                        href="">{{ str_limit($product->pro_sub_cat->name, 25, '..') }}</a>
                                                </p> --}}
                                                <a href="generic-name" class="generic-name">
                                                    {{ str_limit($product->generic->name, 30, '..') }}
                                                </a>
                                                <a href="" class="company-name">
                                                    {{ str_limit($product->company->name, 30, '..') }}
                                                </a>

                                                <div class="product_title">
                                                    <a href="{{ route('product.single_product', $product->slug) }}">
                                                        <h3 class="fw-bold">
                                                            {{ str_limit(Str::ucfirst(Str::lower($product->name)), 30, '..') }}
                                                            <span class="strength">
                                                                ({{ $product->pro_sub_cat->name }})
                                                            </span>
                                                        </h3>
                                                    </a>
                                                </div>
                                                <h4> <span> &#2547; </span> {{ number_format($product->price) }}</h4>
                                                <div class="add_to_card">
                                                    <a class="cart-btn" href="#">
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if (count($products) >= 18)
                                <div class="row show-more mt-5">
                                    <a class="all-pdct-btn text-center" href="#">{{ __('SEE MORE') }}</a>
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
        $(document).ready(function() {
            $('.featured_item').on('click', function() {
                $('.cat-list li').removeClass('active');
                $('.cat-list li').removeClass('uk-slide-active');
                $(this).parent('li').addClass('active');
                let id = $(this).data('id');
                let url = ("{{ route('home.featured_products', ['id']) }}");
                let _url = url.replace('id', id);

                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        data.products.forEach(function(product) {
                            let route = (
                                "{{ route('product.single_product', ['slug']) }}");
                            let _route = route.replace('slug', product.slug);
                            result += `
                                <div class="col-3 px-2">
                                    <div class="single-pdct">
                                            <a href="${_route}">
                                                <div class="pdct-img">
                                                    <img class="w-100"
                                                        src="${product.image}"
                                                        alt="Product Image">
                                                </div>
                                            </a>
                                            <div class="pdct-info">
                                                <a href="generic-name" class="generic-name">
                                                    ${product.generic.name}
                                                </a>
                                                <a href="" class="company-name">
                                                    ${product.company.name}
                                                </a>

                                                <div class="product_title">
                                                    <a href="${_route}">
                                                    <h3 class="fw-bold">
                                                        ${product.name}
                                                        
                                                    </h3>
                                                </a>
                                                </div>
                                                <h4> <span> &#2547; </span> ${product.price}</h4>
                                                <div class="add_to_card">
                                                    <a class="cart-btn" href="#">
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
