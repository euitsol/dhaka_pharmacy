<footer>
    <section class="footer-section">

        <!--======== Footer Deivery Row ===========-->
        <div class="delivery-row p-5">
            <div class="container">
                <div class="row row-gap-4">
                    <div class="col-6 col-md-3">
                        <div class="row row-gap-2">
                            <div class="col-12 col-xxl-2">
                                <img class="w-auto" src="{{ asset('frontend/asset/img/delivery.png') }}" alt="">
                            </div>
                            <div class="col-12 col-xxl-10">
                                <h3>{{ __('Quick Delivery') }}</h3>
                                <h4>{{ __('Varius sit amet mattis vulputat') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="row row-gap-2">
                            <div class="col-12 col-xxl-2">
                                <img src="{{ asset('frontend/asset/img/clock.png') }}" alt="">
                            </div>
                            <div class="col-12 col-xxl-10">
                                <h3>{{ __('24/7 Help Center') }}</h3>
                                <h4>{{ __('Dedicated 24/7 support') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="row row-gap-2">
                            <div class="col-12 col-xxl-2">
                                <img src="{{ asset('frontend/asset/img/setisfide.png') }}" alt="">
                            </div>
                            <div class="col-12 col-xxl-10">
                                <h3>{{ __('Satisfied or Refunder') }}</h3>
                                <h4>{{ __('Free returns within 14 days') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="row row-gap-2">
                            <div class="col-12 col-xxl-2">
                                <img src="{{ asset('frontend/asset/img/card.png') }}" alt="">
                            </div>
                            <div class="col-12 col-xxl-10">
                                <h3>{{ __('Secured Payment') }}</h3>
                                <h4>{{ __('Pharetra magna ac placerat vestibu') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--======== Footer newsletter row ===========-->
        <!-- <div class="newsletter-row">
            <div class="container">
                <div class="row">
                    <div class="col-8 m-auto">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h3 class="title text-white m-0 text-center">
                                    {{ __('Subscribe to get the Latest News') }}</h3>
                            </div>
                            <div class="col-8">
                                <form action="" class="d-flex align-items-center">
                                    <input type="text" placeholder="Enter Your Email">
                                    <input type="submit" value="Subscribe">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="newsletter-row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="newsletter-main-row align-items-center">
                            <div class="newsletter-headign">
                                <h3 class="title text-white m-0 text-center">
                                    {{ __('Subscribe to get the Latest News') }}</h3>
                            </div>
                            <div class="newsletter-content">
                                <form action="" class="d-flex align-items-center">
                                    <input type="text" placeholder="Enter Your Email">
                                    <input type="submit" value="Subscribe">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--======== Footer Main Row =========-->
        <div class="main-footer-row py-5">
            <div class="container">
                <div class="row row-gap-4">
                    <div class="col-4 col-lg-3 col-6 col-md-4 col-6 col-sm-6">
                        <div class="footer-logo mb-4">
                            <a href="#"> <img src="{{ asset('frontend/asset/img/logo.png') }}"
                                    alt="Footer logo"></a>
                        </div>
                        <div class="social-info mb-4">
                            <h3 class="title">{{ __('Follow Us') }}</h3>
                            <div class="icons d-flex">
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="pay-info">
                            <h3 class="title">{{ __('We Accept') }}</h3>
                            <div class="payment">
                                <img src="{{ asset('frontend/asset/img/card-update-logo.png') }}"
                                    alt="Payment card image">
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-3 col-6 col-md-4 col-12 col-sm-6">
                        <h2 class="title">{{ __('Information') }}</h2>
                        <div class="footer-menu">
                            <ul class="footer-nav">
                                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                <li><a href="#">{{ __('About Us') }}</a></li>
                                <li><a href="#">{{ __('Contact Us') }}</a></li>
                                @if (!Auth::guard('web')->check())
                                    <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-4 col-lg-3 col-6 col-md-4 col-12 col-sm-6">
                        <h2 class="title">{{ __('Customer Service') }}</h2>
                        <div class="footer-menu">
                            <ul class="footer-nav">
                                <li><a href="{{ route('faq') }}">{{ __('FAQ') }}</a></li>
                                <li><a href="{{ route('terms_and_conditions') }}">{{ __('Terms and Conditions') }}</a>
                                </li>
                                <li><a href="{{ route('privacy_policy') }}">{{ __('Privacy Policy') }}</a></li>
                                @if (!Auth::guard('web')->check())
                                    <li><a href="{{ route('use.register') }}">{{ __('Register') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-6 col-md-6 col-12 col-sm-6">
                        <h2 class="title">{{ __('Your trusted online medicine supplier') }}</h2>
                        <div class="footer-contact">
                            <ul class="footer-nav">
                                <li><a class="map" href="https://maps.app.goo.gl/UPWoFht1PicYMHdR8" target="_blank">
                                        {{ __('Road -4, 11 Gulshan Avenue, Dhaka BangladeshFree Consultation') }}
                                    </a>
                                </li>
                                <li><a class="phn" href="tel:01714 432 534">{{ __('01714 432 534') }}</a></li>
                                <li>
                                    <a class="mail"
                                        href="mailto:admin@dhakapharmacy.com.bd">{{ __('admin@dhakapharmacy.com.bd') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--======== Socket Row =========-->
    <div class="socket-row p-3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-center m-0">
                        {{ date('Y') }} &copy{{ __(' all rights reserved by Dhaka Pharmacy') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- =========== Mobile footer design =========== -->
    <div class="mobile-footer">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">
                    <div class="main-mobile-col text-center">
                        <ul>
                            <li><a href="#"><i class="fas fa-home"></i></a></li>
                            <li><a href="#"><i class="fas fa-th-large"></i></a></li>
                            <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
                            <li><a href="#"><i class="fas fa-user"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
