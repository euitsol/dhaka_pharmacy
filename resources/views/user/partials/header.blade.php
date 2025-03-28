<header class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-3">
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img class="w-100" src="{{ storage_url(settings('site_logo')) }}"
                                    alt="{{ config('app.name') }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu ps-xl-5">
                            <ul class="navbar-nav flex-row align-items-center">
                                <li class="nav-item"><a
                                        class="nav-link @if (isset($pageSlug) && $pageSlug == 'dashboard') active @endif"
                                        href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="nav-item"><a
                                        class="nav-link @if (isset($pageSlug) && $pageSlug == 'address') active @endif"
                                        href="{{ route('u.as.list') }}">{{ __('Address') }}</a></li>
                                <li class="nav-item"><a
                                        class="nav-link @if (isset($pageSlug) && $pageSlug == 'order') active @endif"
                                        href="{{ route('u.order.list') }}">{{ __('Orders') }}</a></li>
                                <li class="nav-item"><a
                                        class="nav-link @if (isset($pageSlug) && $pageSlug == 'wishlist') active @endif"
                                        href="{{ route('u.wishlist.list') }}">{{ __('Wishlists') }}</a></li>
                                <li class="nav-item"><a
                                        class="nav-link @if (isset($pageSlug) && $pageSlug == 'payment') active @endif"
                                        href="{{ route('u.payment.list') }}">{{ __('Payments') }}</a></li>
                                <li class="nav-item"><a
                                        class="nav-link @if (isset($pageSlug) && $pageSlug == 'review') active @endif"
                                        href="{{ route('u.review.list') }}">{{ __('Reviews') }}</a></li>
                                <li class="nav-item d-lg-none d-block">
                                    <a class="nav-link text-danger" href="javascript:void(0)"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-9 d-flex flex-row align-items-center justify-content-end">
                <div class="right-col me-4">
                    <a href="javascript:void(0)" id="cart_icon_btn" class="cart-icon cart-btn d-flex" data-bs-toggle="offcanvas"
                        data-bs-target="#cartbtn" aria-controls="offcanvasRight" type="button">
                        <img src="{{ asset('user/asset/img/my-cart1.png') }}" alt="">
                        <sup><strong id="cart_btn_quantity"></strong></sup>
                    </a>
                    @include('frontend.includes.add_to_cart_slide')
                </div>
                <div class="notification {{ user()->unreadNotifications->count() > 0 ? 'active' : '' }} me-4">
                    <a href="javascript:void(0)" class="dropdown-toggle d-flex" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownNotification">
                        <img src="{{ asset('user/asset/img/notification.png') }}" alt="">
                        <sup>
                            <strong class="notification_count">
                                {{ user()->unreadNotifications->count() > 99 ? '99+' : user()->unreadNotifications->count() }}
                            </strong>
                        </sup>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownNotification">
                        <li>
                            <div class="notification-top d-flex justify-content-between align-items-center px-3">
                                <div class="count">
                                    <span>{{ __('Notifications') }}</span>
                                    (<span class="notification_quantity">
                                        {{ user()->unreadNotifications->count() > 99 ? '99+' : user()->unreadNotifications->count() }}
                                    </span>)
                                </div>
                                <div class="mark-as-read">
                                    <span id="read_all">{{ __('Mark all as read') }}</span>
                                </div>
                            </div>
                            <hr class="my-1">
                        </li>

                        <li>
                            <ul class="notification-list">
                                @forelse (user()->notifications as $notification)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center notification-item {{ $notification->read_at ? '' : 'active' }}"
                                    href="javascript:void(0)" data-id="{{ $notification->id }}"
                                    data-url="{{ $notification->data['url'] ?? null }}">
                                        <div class="notification-icon">
                                            <i class="fa-regular fa-bell fs-3 me-3" style="width: 50px; text-align: center"></i>
                                        </div>
                                        <div class="details px-2">
                                            <p class="fw-semibold">{{ $notification->data['title'] }}</p>
                                            <span class="notification-title d-block">
                                                {{ Str::limit($notification->data['message'], 60) }}
                                            </span>
                                            <span class="notify-time d-block mt-1 text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li class="text-center notification-empty">
                                    <span class="text-muted">{{ __('You have no notifications') }}</span>
                                </li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- user dashboard html code here-->
                <div class="name me-3 d-none d-sm-block">
                    <a href="{{ route('user.dashboard') }}">{{ abbreviateName(user()->name) }}</a>
                </div>
                <!-- profile html code here -->
                <div class="profile position-relative">
                    <a href="#" class="dropdown-toggle d-inline-block" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton"
                    onclick="return false;"> <!-- Added onclick to prevent default behavior -->
                        <img src="{{ auth_storage_url(user()->image, user()->gender) }}" alt="Profile"
                            class="rounded-circle img-fluid" style="object-fit: cover; height: 50px; width: 50px">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'profile') active @endif"
                                href="{{ route('u.profile.index') }}">
                                <i class="fa-solid fa-user-gear fs-5 me-3" style="width: 24px; text-align: center"></i>
                                <span>{{ __('Manage My Account') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'kyc_verification') active @endif"
                                href="{{ route('u.kyc.verification') }}">
                                <i class="fa-solid fa-shield-halved fs-5 me-3" style="width: 24px; text-align: center"></i>
                                <span>{{ __('KYC Verification Center') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'order') active @endif"
                                href="{{ route('u.order.list') }}">
                                <i class="fa-solid fa-truck-fast fs-5 me-3" style="width: 24px; text-align: center"></i>
                                <span>{{ __('My Orders') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'wishlist') active @endif"
                                href="{{ route('u.wishlist.list') }}">
                                <i class="fa-solid fa-heart fs-5 me-3" style="width: 24px; text-align: center"></i>
                                <span>{{ __('My Wishlist') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center @if (isset($pageSlug) && $pageSlug == 'review') active @endif"
                                href="{{ route('u.review.list') }}">
                                <i class="fa-regular fa-star-half-alt fs-5 me-3" style="width: 24px; text-align: center"></i>
                                <span>{{ __('My Reviews') }}</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" 
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket fs-5 me-3" style="width: 24px; text-align: center"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

                <div class="toggle_bar ms-3">
                    {{-- <i class="fa-solid fa-bars-staggered fs-1"></i> --}}
                    <i class="fa-solid fa-bars fs-1 toggle_icon"></i>
                </div>
            </div>

        </div>
    </div>
</header>
