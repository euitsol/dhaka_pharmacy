
<section class="header-section">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <a class="menu-btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                            aria-controls="offcanvasExample">
                            <i class="fa-solid fa-bars fs-4 text-white"></i>
                        </a>
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                            aria-labelledby="offcanvasExampleLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <!--========= Burger Menu data here =======-->
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="logo">
                            <a href="{{route('home')}}"><img class="w-100" src="{{asset('frontend/asset/img/logo.png')}}" alt="Header-logo"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="search-filter col-8 m-auto">
                    <form class="d-flex" action="">
                        <input class="col-7" type="text" id="searchInput" placeholder="Search...">
                        <select class="col-4" name="pro_cat_id" id="categorySelect">
                            <option value="all" selected>{{__('All Category')}}</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{__($category->name)}}</option>
                            @endforeach
                            
                        </select>
                        <button class="sub-btn text-center bg-white col-1" type="submit"><i
                                class="fa-solid fa-magnifying-glass text-dark"></i></button>
                    </form>
                    <div id="suggestionBox" class="suggestion-box p-2 pb-0">
                        
                    </div>

                </div>
            </div>
            <div class="col-3 right-col">
                <div class="row align-items-center justify-content-end">
                    <div class="item">
                        <button class="cart-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#cartbtn" aria-controls="offcanvasRight">
                            <i class="fa-solid fa-cart-shopping me-1"></i>
                            <span>Cart</span><sup id="cart_btn_quantity"><strong>{{$total_cart_item ?? ''}}</strong></sup>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="cartbtn"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Cart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                @foreach ($cart_products as $product)
                                    <div class="card add_to_cart_item mb-2">
                                        <div class="card-body py-2">
                                            <div class="row align-items-center product_details mb-2">
                                                <div class="image col-2">
                                                    <a href="">
                                                        <img class="border border-1 rounded-1"
                                                        src="{{storage_url($product->image)}}"
                                                        alt="{{$product->name}}">
                                                    </a>
                                                </div>
                                                <div class="col-8 info">
                                                    <a href=""><h4 class="product_title" title="{{$product->attr_title}}">{{$product->name}}</h4></a>
                                                    <a href=""><p >{{$product->pro_sub_cat->name}}</p></a>
                                                    <a href=""><p>{{{$product->generic->name}}}</p></a>
                                                    <a href=""><p>{{$product->company->name}}</p></a>
                                                </div>
                                                <div class="item_price col-2">
                                                    <h4 class="text-center"> <span> &#2547; </span> {{ number_format($product->price) }}</h4>
                                                </div>
                                            </div>
                                            <div class="row align-items-center atc_functionality">
                                                
                                                <div class="item_units col-9">
                                                    <div class="form-group my-1 boxed">
                                                        @foreach ($product->units as $key=>$unit)
                                                            <input type="radio" data-name="{{$unit->name}}"
                                                                @if ($key == 0) checked @endif
                                                                class="item_quantity" id="android-{{ $key }}"
                                                                name="data"
                                                                value="{{ $product->price * $unit->quantity }}">
                                                            <label for="android-{{ $key }}">
                                                                <img src="{{storage_url($unit->image)}}">
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="plus_minus col-3">
                                                    <div class="form-group">
                                                        <div class="input-group" role="group">
                                                            <a href="javascript:void(0)" class="btn btn-sm minus_btn"><i class="fa-solid fa-minus"></i></a>
                                                            <input type="text" class="form-control text-center item_quantity" value="1" >
                                                            <a href="javascript:void(0)" class="btn btn-sm plus_btn"><i class="fa-solid fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <a href="{{route('login')}}" class="login-btn">
                            <i class="fa-regular fa-user me-1"></i>
                            <span>Login/Register</span>
                        </a>
                    </div>
                    <div class="item">
                        <button class="wish-btn bg-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#wishlist" aria-controls="offcanvasRight">
                            <i class="fa-regular fa-heart me-1"></i>
                            <span>Wish List</span>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="wishlist"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Wish List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <!--========= wishlist content here ========-->
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <select name="" id="">
                            <option value="english">English</option>
                            <option value="bangla">Bangla</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>