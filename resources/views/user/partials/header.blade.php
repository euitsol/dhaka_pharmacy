<header class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-9 flex-row d-flex align-items-center">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img class="w-100" src="{{ asset('user/asset/img/dashboard-logo.png') }}"
                            alt="{{ config('app.name') }}">
                    </a>
                </div>
                <div class="nav-menu ps-5">
                    <ul class="navbar-nav flex-row">
                        <li class="nav-item"><a class="nav-link @if (isset($pageSlug) && $pageSlug == 'dashboard') active @endif"
                                href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="nav-item"><a class="nav-link @if (isset($pageSlug) && $pageSlug == 'address') active @endif"
                                href="{{ route('u.as.list') }}">{{ __('Address') }}</a></li>
                        <li class="nav-item"><a class="nav-link @if (isset($pageSlug) && $pageSlug == 'order') active @endif"
                                href="{{ route('u.order.list') }}">{{ __('Orders') }}</a></li>
                        <li class="nav-item"><a class="nav-link @if (isset($pageSlug) && $pageSlug == 'wishlist') active @endif"
                                href="{{ route('u.wishlist.list') }}">{{ __('Wishlists') }}</a></li>
                        <li class="nav-item"><a class="nav-link @if (isset($pageSlug) && $pageSlug == 'payment') active @endif"
                                href="{{ route('u.payment.list') }}">{{ __('Payments') }}</a></li>
                        <li class="nav-item"><a class="nav-link @if (isset($pageSlug) && $pageSlug == 'review') active @endif"
                                href="{{ route('u.review.list') }}">{{ __('Reviews') }}</a></li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-7">

            </div> -->
            <div class="col-3 d-flex flex-row align-items-center justify-content-end">
                <div class="right-col me-4">
                    <a href="javascript:void(0)" class="cart-icon d-flex" data-bs-toggle="offcanvas"
                        data-bs-target="#cartbtn" aria-controls="offcanvasRight">
                        <img src="{{ asset('user/asset/img/my-cart1.png') }}" alt="">
                        <sup><strong id="cart_btn_quantity"></strong></sup>
                    </a>
                    @include('frontend.includes.add_to_cart_slide')
                </div>
                <div class="setting me-4">
                    <a href="#">
                        <img src="{{ asset('user/asset/img/setting.png') }}" alt="">
                    </a>
                </div>
                <div class="notification me-4">
                    <a href="#">
                        <img src="{{ asset('user/asset/img/notification.png') }}" alt="">
                    </a>
                </div>
                <div class="name me-3">
                    <a href="{{ route('user.dashboard') }}">{{ abbreviateName(user()->name) }}</a>
                </div>
                <div class="profile">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false" id="dropdownMenuButton">
                        <img src="{{ user()->image ? storage_url(user()->image) : asset('user/asset/img/user.png') }}"
                            alt="">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#"><img
                                    src="{{ asset('user/asset/img/manage-account.png') }}" alt="">
                                <span>{{ __('Manage My Account') }}</span></a></li>
                        <li><a class="dropdown-item" href="{{ route('u.order.list') }}"><img
                                    src="{{ asset('user/asset/img/setting.png') }}"
                                    alt=""><span>{{ __('My Orders') }}</span></a></li>
                        <li><a class="dropdown-item" href="{{ route('u.wishlist.list') }}"><img
                                    src="{{ asset('user/asset/img/wishlist.png') }}"
                                    alt=""><span>{{ __('My Wishlist') }}</span></a></li>
                        <li><a class="dropdown-item" href="{{ route('u.review.list') }}"><img
                                    src="{{ asset('user/asset/img/reviews.png') }}"
                                    alt=""><span>{{ __('My Reviews') }}</span></a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><img
                                    src="{{ asset('user/asset/img/logout.png') }}"
                                    alt=""><span>{{ __('Logout') }}</span></a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
