<section class="header-section">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-3">
                <div class="row align-items-center">
                    {{-- <div class="col-2">
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
                    </div> --}}
                    <div class="col-6">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img class="w-100"
                                    src="{{ asset('frontend/asset/img/logo.png') }}" alt="Header-logo"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="search-filter col-8 m-auto">
                    <form class="d-flex" action="">
                        <input class="col-7" type="text" id="searchInput" placeholder="Search...">
                        <select class="col-4" name="pro_cat_id" id="categorySelect">
                            <option value="all" selected>{{ __('All Category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                            @endforeach

                        </select>
                        <button class="sub-btn text-center bg-white col-1" type="submit"><i
                                class="fa-solid fa-magnifying-glass text-dark"></i></button>
                    </form>
                    <div id="suggestionBox" class="suggestion-box p-2 pb-0">

                    </div>

                </div>
            </div>
            <div class="col-3 ps-0 right-col">
                <div class="row align-items-center justify-content-end">
                    @if (!Auth::guard('web')->check())
                        <div class="item">
                            <a href="{{ route('login') }}" class="login-btn">
                                <i class="fa-solid fa-user me-1"></i>
                                <span>{{ __('Login') }}</span>
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{ route('use.register') }}" class="login-btn">
                                <i class="fa-solid fa-address-card me-1"></i>
                                <span>{{ __('Register') }}</span>
                            </a>
                        </div>
                    @endif

                    <div class="item">
                        <select name="" id="">
                            <option value="english">{{ __('English') }}</option>
                            <option value="bangla">{{ __('Bangla') }}</option>
                        </select>
                    </div>
                    @if (Auth::guard('web')->check())
                        <div class="item">
                            <button class="wish-btn bg-none" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#wishlist" aria-controls="offcanvasRight">
                                <i class="fa-solid fa-heart me-1"></i>
                                <span>{{ __('Wish List') }}</span>
                            </button>
                            @include('frontend.includes.wishlist_slide')
                        </div>
                        <div class="item">
                            <button class="cart-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartbtn"
                                aria-controls="offcanvasRight">
                                <i class="fa-solid fa-cart-shopping me-1"></i>
                                <span>{{ __('Cart') }}</span><sup><strong id="cart_btn_quantity"></strong></sup>
                            </button>
                            @include('frontend.includes.add_to_cart_slide')
                        </div>
                        <div class="item" style="max-width: 185px; overflow:hidden;">
                            <a href="{{ route('user.dashboard') }}" class="login-btn d-flex align-items-center">
                                <img style="height: 35px; width: 35px; object-fit: cover; border-radius: 50%;"
                                    src="{{ user()->image ? storage_url(user()->image) : asset('user/asset/img/user.png') }}"
                                    alt="">
                                <span class="ms-1">{{ abbreviateName(user()->name) }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
