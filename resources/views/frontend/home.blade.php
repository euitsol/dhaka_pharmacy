@extends('frontend.layouts.master')
@section('title', 'Home')

@section('content')
    <div class="row pt-4">
        @if($menuItems->isNotEmpty())
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @include('frontend.includes.home.sidebar',['menuItems'=>$menuItems])
        <!--=========== Sidebar-Category-Section-Include  ==============-->
        @endif


        <!--=========== Main Content Section Start ==============-->
        <div class="{{($menuItems->isNotEmpty() ? 'col-md-9 col-lg-10' : 'col-12')}} content-col">
            <!--========= Slider-Section-Include ========-->
            @include('frontend.includes.home.slider')
            <!--========= Slider-Section-Include ========-->

            <!--========= Product-Section-Start ========-->
            <section class="product-section pb-4 mb-5">
                <div class="row">
                    <div class="col-3 best-selling-col">
                        <h2 class="title mb-4">{{__('Best Selling')}}</h2>
                        <div class="all-product">
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/jumper-jpd-500d-oled-version.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">Jumper Pulse Oximeter JPD-500
                                                D Device</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>1500</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product01.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">glipita m 50/500</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>14</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product02.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">ORAL-C 125ML Mouth Wash</a>
                                        </h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>75</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product03.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">SENSODYNE FRESH MINT 150 GM
                                                Toiletries</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>185</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product04.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">Savlon Baby Wipes</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>14</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product03.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">SENSODYNE FRESH MINT 150 GM
                                                Toiletries</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>185</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product04.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">Savlon Baby Wipes</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>14</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 single-item">
                                <div class="row">
                                    <div class="col-4 img">
                                        <img class="w-100 border border-1 rounded-1"
                                            src="{{ asset('frontend/asset/img/product03.png') }}"
                                            alt="Product Image">
                                    </div>
                                    <div class="col-8">
                                        <h3 class="pdct-title"><a href="#">SENSODYNE FRESH MINT 150 GM
                                                Toiletries</a></h3>
                                        <h4 class="pdct-price"><span>&#2547;</span>185</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="row cat-filter-row gx-4">
                            <div class="col-3">
                                <h2 class="title">{{__('Featured Products')}}</h2>
                            </div>
                            <div class="col-8">
                                <div class="slider-col" uk-slider="finite: true">
                                    <div class="uk-position-relative">
                                        <div class="uk-slider-container uk-light">
                                            <ul
                                                class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m cat-list">
                                                <li class="text-right active" style="text-align: right;">
                                                    <a href="javascript:void(0)" class="featured_item" data-id="all">{{_('All')}}</a>
                                                </li>
                                                @foreach ($featuredItems as $item)
                                                    <li><a href="javascript:void(0)" class="featured_item" data-id="{{$item->id}}">{{__($item->name)}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                
                                        <div class="uk-hidden@s uk-light btn-arrow">
                                            <a class="uk-position-center-left uk-position-small" href
                                                uk-slidenav-previous uk-slider-item="previous"></a>
                                            <a class="uk-position-center-right uk-position-small" href
                                                uk-slidenav-next uk-slider-item="next"></a>
                                        </div>
                
                                        <div class="uk-visible@s btn-arrow">
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
                                <div class="col-3">
                                    <div class="single-pdct">
                                        <div class="pdct-img">
                                            <img class="w-100" src="{{ asset('frontend/asset/img/pdct01.png') }}"
                                                alt="Product Image">
                                        </div>
                                        <div class="pdct-info">
                                            <h3>glipita m 50/500</h3>
                                            <h3>Metformin Hydrochloride</h3>
                                            <h4><span>&#2547;</span>14</h4>
                                            <a class="cart-btn" href="#"><img
                                                    src="{{ asset('frontend/asset/img/cart-icon.svg') }}"
                                                    alt="">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        </div>
                        @if(count($products) >=8)
                        <div class="row show-more mt-5">
                            <a class="all-pdct-btn text-center" href="#">{{__('All Products')}}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            <!--====== Delivery Slider Section ======-->
            <section class="delivery-slider-section">
                <div class="row">
                    <div class="col">
                        <div uk-slideshow>
                            <ul class="uk-slideshow-items">
                                <li>
                                    <img src="{{ asset('frontend/asset/img/slider-bg-02.jpg') }}" alt=""
                                        uk-cover>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h2>Shop Online or In store Get</h2>
                                        <a href="#">Free</a>
                                        <h3>Delivery</h3>
                                        <h4>at Your Door</h4>
                                    </div>
                                </li>
                                <li>
                                    <img src="{{ asset('frontend/asset/img/slider-bg-01.jpg') }}" alt=""
                                        uk-cover>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h2>Shop Online or In store Get</h2>
                                        <a href="#">Free</a>
                                        <h3>Delivery</h3>
                                        <h4>at Your Door</h4>
                                    </div>
                                </li>
                                <li>
                                    uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                                    <img src="{{ asset('frontend/asset/img/slider-bg-01.jpg') }}" alt=""
                                        uk-cover>
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
        $(document).ready(function() {
            $('.cat-filter-row .uk-slidenav-next, .cat-filter-row .uk-slidenav-previous').on('click',function(){
                $('.cat-list li').removeClass('active');
            })

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
                            result += `
                                <div class="col-3">
                                    <div class="single-pdct">
                                        <div class="pdct-img">
                                            <img class="w-100" src="{{ asset('frontend/asset/img/pdct01.png') }}"
                                                alt="Product Image">
                                        </div>
                                        <div class="pdct-info">
                                            <h3>glipita m 50/500</h3>
                                            <h3>Metformin Hydrochloride</h3>
                                            <h4><span>&#2547;</span>14</h4>
                                            <a class="cart-btn" href="#"><img
                                                    src="{{ asset('frontend/asset/img/cart-icon.svg') }}"
                                                    alt="">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        $('.all-products').html(result);
                        if(data.products.length >=8){
                            $('.show-more').show();
                        }else{
                            $('.show-more').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush