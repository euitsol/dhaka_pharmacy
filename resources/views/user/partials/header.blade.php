<header class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-8 flex-row d-flex align-items-center">
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
            <div class="col-4 d-flex flex-row align-items-center justify-content-end">
                <div class="right-col me-4">
                    <a href="javascript:void(0)" class="cart-icon d-flex" data-bs-toggle="offcanvas"
                        data-bs-target="#cartbtn" aria-controls="offcanvasRight">
                        <img src="{{ asset('user/asset/img/my-cart1.png') }}" alt="">
                        <sup><strong id="cart_btn_quantity"></strong></sup>
                    </a>
                    @include('frontend.includes.add_to_cart_slide')
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
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle d-inline-block" type="button"
                        data-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton">
                        <img src="{{ auth_storage_url(user()->image, user()->gender) }}" alt=""
                            class="rounded-circle img-fluid" style="object-fit: fill; height: 50px; width: 50px">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'profile') active @endif"
                                href="{{ route('u.profile.index') }}">
                                <i class="fa-solid fa-user-gear fs-3 me-3" style="width: 30px"></i>
                                <span>{{ __('Manage My Account') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'kyc_verification') active @endif"
                                href="{{ route('u.kyc.verification') }}">
                                <i class="fa-solid fa-shield-halved fs-3 me-3" style="width: 30px"></i>
                                <span>{{ __('KYC Verification Center') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'order') active @endif"
                                href="{{ route('u.order.list') }}">
                                <i class="fa-solid fa-truck-fast fs-3 me-3" style="width: 30px"></i>
                                <span>{{ __('My Orders') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'wishlist') active @endif"
                                href="{{ route('u.wishlist.list') }}">
                                <i class="fa-solid fa-heart fs-3 me-3" style="width: 30px"></i>
                                <span>{{ __('My Wishlist') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'review') active @endif"
                                href="{{ route('u.review.list') }}">
                                <i class="fa-regular fa-star-half-alt  fs-3 me-3" style="width: 30px"></i>
                                <span>{{ __('My Reviews') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <img src="{{ asset('user/asset/img/logout.png') }}" alt="">
                                <span>{{ __('Logout') }}</span>
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
