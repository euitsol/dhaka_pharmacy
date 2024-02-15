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
                        <select class="col-4" name="" id="">
                            <option value="volvo">All Category</option>
                            <option value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </select>
                        <button class="sub-btn text-center bg-white col-1" type="submit"><i
                                class="fa-solid fa-magnifying-glass text-dark"></i></button>
                    </form>
                    <div id="suggestionBox" class="suggestion-box"></div>

                </div>
            </div>
            <div class="col-3 right-col">
                <div class="row align-items-center justify-content-end">
                    <div class="item">
                        <button class="cart-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#cartbtn" aria-controls="offcanvasRight">
                            <i class="fa-solid fa-cart-shopping me-1"></i>
                            <span>Cart</span>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="cartbtn"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Cart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <!--======== Cart content here =========-->
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