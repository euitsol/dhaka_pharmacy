<header class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-9 flex-row d-flex align-items-center">
                <div class="logo">
                    <a href="#">
                        <img class="w-100" src="asset/img/dashboard-logo.png" alt="">
                    </a>
                </div>
                <div class="nav-menu ps-5">
                    <ul class="navbar-nav flex-row">
                        <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Payments</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Analutics</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Cards</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">History</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-7">

            </div> -->
            <div class="col-3 d-flex flex-row align-items-center justify-content-end">
                <div class="setting me-4">
                    <a href="#">
                        <img src="asset/img/setting.png" alt="">
                    </a>
                </div>
                <div class="notification me-4">
                    <a href="#">
                        <img src="asset/img/notification.png" alt="">
                    </a>
                </div>
                <div class="name me-3">
                    <a href="#">Robin</a>
                </div>
                <div class="profile">
                    <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="asset/img/user.png" alt="">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><img src="asset/img/manage-account.png" alt="">
                                <span>Manage My Account</span></a></li>
                        <li><a class="dropdown-item" href="#"><img src="asset/img/setting.png" alt=""><span>My
                                    Orders</span></a></li>
                        <li><a class="dropdown-item" href="#"><img src="asset/img/wishlist.png" alt=""><span>My
                                    Wishlist</span></a></li>
                        <li><a class="dropdown-item" href="#"><img src="asset/img/reviews.png" alt=""><span>My
                                    Reviews</span></a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><img src="asset/img/logout.png"
                                    alt=""><span>Logout</span></a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>
        </div>
    </div>
</header>