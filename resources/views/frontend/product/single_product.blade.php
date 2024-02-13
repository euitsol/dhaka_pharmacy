@extends('frontend.layouts.master')
@section('title', 'Home')

@push('css')
    <style>
        .single_product_section .single_product{
            
        }
        .single_product_section .single_product .breadcrumb{
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .single_product_section .single_product .breadcrumb a,
        .single_product_section .single_product .product_content h1,
        .single_product_section .related_products h2{
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            line-height: 35px;
            font-weight: 500;
            color: var(--text-color-black);
            transition: .4s;
            cursor: pointer;
        }
        .single_product_section .single_product .breadcrumb a:hover,
        .single_product_section .single_product .product_content h1:hover,
        .single_product_section .related_products h2:hover{
            color: var(--text-primary-color);
        }
        .single_product_section .single_product .breadcrumb i{
            font-size: 17px;
        }
        .single_product_section .single_product .product_image{

        }
        .single_product_section .single_product .product_image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .single_product_section .single_product .product_content{

        }
        .single_product_section .single_product .product_content p {
            margin-bottom: 5px;
            font-size: 18px;
            color: var(--text-color-black);
        }
        .single_product_section .single_product .product_content .product_price{

        }
        .single_product_section .single_product .product_content .product_price select{
            text-align: center;
            color: var(--text-color-black);
        }
        .single_product_section .single_product .product_content .product_price p{

        }
        .single_product_section .single_product .product_content .product_price a{

        }
        .single_product_section .single_product .product_details{

        }






        .single_product_section .related_products .single-item .img img {
            height: 100%;
            object-fit: cover;
            padding: 15px 5px;
        }

        .single_product_section .related_products .single-item img{
            border-color: var(--text-color-black) !important;
        }
        .single_product_section .related_products .single-item .content{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .single_product_section .related_products .single-item .pdct-title{
            margin: 0;
            padding: 0;
        }
        .single_product_section .related_products .single-item .pdct-title{
            font-family: "Open Sans", sans-serif;
            font-size: 15px;
            line-height: 23px;
            font-weight: 500;
            display: block;
            text-decoration: none;
            color: var(--text-color-black);
            transition: 0.4s;
        }
        .single_product_section .related_products .single-item .pdct-title:hover{
            color: var(--asent-color);
        }
        .single_product_section .related_products .single-item .pdct-price{
            font-family: "Open Sans", sans-serif;
            font-size: 17px;
            line-height: 25px;
            font-weight: 500;
            color: var(--secundary-color);
            margin: 0;
        }

        
    </style>
@endpush
@section('content')
    <div class="row pt-4">
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @if($menuItems->isNotEmpty())
            @include('frontend.includes.home.sidebar',['menuItems'=>$menuItems])
        @endif
        <!--=========== Sidebar-Category-Section-Include  ==============-->


        <!--=========== Main Content Section Start ==============-->
        <div class="{{($menuItems->isNotEmpty() ? 'col-md-9 col-lg-10' : 'col-12')}} content-col">
            <section class="single_product_section pb-4">
                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="single_product">
                                    <h2 class="breadcrumb mb-4">
                                        <a href="#">{{__($single_product->pro_cat->name)}}</a> <i class="fa-solid fa-angle-right"></i>
                                        <a href="#">{{__($single_product->pro_sub_cat->name)}}</a> <i class="fa-solid fa-angle-right"></i>
                                        <a href="#">{{__($single_product->medicine_cat->name)}}</a>
                                    </h2>
                                    <div class="row gx-4">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="product_image">
                                                        <img src="{{ asset('no_img/no_img.png') }}" alt="Product Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product_content">
                                                <h1>{{__($single_product->name)}}</h1>
                                                <p>{{__($single_product->medicine_cat->name)}}</p>
                                                <p>{{__($single_product->generic->name)}}</p>
                                                <p>{{__($single_product->company->name)}}</p>
                                                <form action="">
                                                <div class="product_price mt-4">
                                                    <p><strong>{{__('MRP: Tk')}} <span class="total_price">{{__(number_format($single_product->price,2))}} </span></strong> {{__('/piece')}}</p>
                                                    <div class="form-group my-4">
                                                        <select name="price" class="form-select form-select-lg price_select_box" aria-label=".form-select-lg example">
                                                            <option value="{{$single_product->price}}">{{__('Price')}}</option>
                                                            @foreach ($units as $unit)
                                                            
                                                                <option value="{{($single_product->price*$unit->quantity)}}">{{__($unit->name)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="add_to_card">
                                                    <a class="cart-btn" type="submit" href="#"><img src="{{ asset('frontend/asset/img/cart-icon.svg') }}" alt="">{{__('Add to Cart')}}</a>
                                                </div>
                                            </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="product_details">
                                                <div class="taps">
                                                    <ul>
                                                        <li>Description</li>
                                                        <li>Information</li>
                                                        <li>Review</li>
                                                    </ul>
                                                </div>
                                                <div class="tab_content">
                                                    This is tab content
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="related_products">
                                    <h2 class="mb-4">{{__('Related Products')}}</h2>
                                    <div class="products">
                                        <div class="row">
                                            @foreach ($related_products as $product)
                                            <div class="col-12 mb-3">
                                                <div class="single-item">
                                                    <a href="{{route('product.single_product',$product->id)}}">
                                                        <div class="row">
                                                        
                                                            <div class="col-4 img">
                                                                <img class="w-100 border border-1 rounded-1"
                                                                    src="{{ $product->image ? storage_url($product->image) : asset('no_img/no_img.png') }}"
                                                                    alt="{{__($product->name)}}">
                                                            </div>
                                                            <div class="col-8 content">
                                                                <h3 class="pdct-title">{{__($product->name)}}</h3>
                                                                <h4 class="pdct-price"><span>&#2547;</span>{{__(number_format($product->price,2))}}</h4>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                        
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
@push('js')
    <script>
        function numberFormat(value, decimals) {
            return parseFloat(value).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        $(document).ready(function(){
            

            $('.price_select_box').on('change',function(){
                console.log($(this).val());
                var formattedNumber = numberFormat($(this).val(), 2);
                $('.total_price').html(formattedNumber);
            });





            var single_product = $('.sidebar-cat-section').height();
            $('.related_products').css('min-height',single_product + "px")
        });
    </script>
@endpush