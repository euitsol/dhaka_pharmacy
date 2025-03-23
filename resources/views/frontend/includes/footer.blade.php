<section class="footer-section">
    <!--======== Footer Deivery Row ===========-->
    <div class="delivery-row p-3 p-md-5">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-6 col-md-3">
                    <div class="row row-gap-2 align-items-center">
                        <div class="col-12 col-xxl-2 text-xxl-start text-center">
                            <img class="w-auto" src="{{ asset('frontend/asset/img/delivery.png') }}" alt="">
                        </div>
                        <div class="col-12 col-xxl-10  text-xxl-start text-center">
                            <h3>{{ __('Quick Delivery') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="row row-gap-2 align-items-center">
                        <div class="col-12 col-xxl-2 text-xxl-start text-center">
                            <img src="{{ asset('frontend/asset/img/clock.png') }}" alt="">
                        </div>
                        <div class="col-12 col-xxl-10  text-xxl-start text-center">
                            <h3>{{ __('24/7 Help Center') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="row row-gap-2 align-items-center">
                        <div class="col-12 col-xxl-2 text-xxl-start text-center">
                            <img src="{{ asset('frontend/asset/img/setisfide.png') }}" alt="">
                        </div>
                        <div class="col-12 col-xxl-10  text-xxl-start text-center">
                            <h3>{{ __('Satisfied or Refunder') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="row row-gap-2 align-items-center">
                        <div class="col-12 col-xxl-2 text-xxl-start text-center">
                            <img src="{{ asset('frontend/asset/img/card.png') }}" alt="">
                        </div>
                        <div class="col-12 col-xxl-10  text-xxl-start text-center">
                            <h3>{{ __('Secured Payment') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--======== Footer newsletter row ===========-->
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
                                <input type="text" placeholder="{{ __('Enter your email address') }}">
                                <input type="submit" value="{{ __('Subscribe') }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======== Footer Main Row =========-->
    <div class="main-footer-row py-3 py-sm-5">
        <div class="container">
            <div class="row row-gap-2 row-gap-sm-4">
                <div class="col-12 col-lg-3 col-md-2 col-sm-6">
                    <div class="footer-logo mb-4">
                        <a href="{{ route('home') }}"> <img src="{{ storage_url(settings('site_logo')) }}"
                                alt="Footer logo"></a>
                    </div>
                    <div class="footer-followus">
                        <div class="social-info mb-4">
                            <h3 class="title">{{ __('Follow Us') }}</h3>
                            <div class="icons d-flex">
                                <a href="https://www.facebook.com/dhakapharmacybangladesh" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="https://x.com/DhakaPharmacy24" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                <a href="https://www.instagram.com/dakapharmacy/" target="_blank" class="d-none"><i class="fa-brands fa-instagram"></i></i></a>
                                <a href="https://www.linkedin.com/in/nazmul-hasan-b527079b/" class="d-none"><i class="fa-brands fa-linkedin"></i></a>
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
                </div>
                <div class="col-6 col-lg-3 col-md-2 col-sm-6">
                    <h2 class="title">{{ __('Information') }}</h2>
                    <div class="footer-menu">
                        <ul class="footer-nav">
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('about_us') }}">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('contact_us') }}">{{ __('Contact Us') }}</a></li>
                            @if (!Auth::guard('web')->check())
                                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-3 col-sm-6">
                    <h2 class="title">{{ __('Customer Service') }}</h2>
                    <div class="footer-menu">
                        <ul class="footer-nav">
                            <li><a href="{{ route('faq') }}">{{ __('FAQ') }}</a></li>
                            <li><a href="{{ route('terms_and_conditions') }}">{{ __('Terms and Conditions') }}</a>
                            </li>
                            <li><a href="{{ route('privacy_policy') }}">{{ __('Privacy Policy') }}</a></li>
                            <li><a href="{{ route('data_deletion') }}">{{ __('Request Data Deletion') }}</a></li>
                            @if (!Auth::guard('web')->check())
                                {{-- <li><a href="{{ route('use.register') }}">{{ __('Register') }}</a></li> --}}
                                <li><a href="{{ route('login') }}">{{ __('Sign In') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-5 col-sm-6">
                    <h2 class="title">{{ __('Your trusted online medicine supplier') }}</h2>
                    <div class="footer-contact">
                        <ul class="footer-nav">
                            <li><a class="map" href="javascript:void(0)">
                                    {{ __('4th Floor, Noor Mansion, Plot-4, Main Road, Mirpur-10, Dhaka-1216') }}
                                </a>
                            </li>
                            <li><a class="phn" href="tel:+8801901636068">{{ __('+880 190 163 6068') }}</a></li>
                            <li>
                                <a class="mail"
                                    href="mailto:contact@dhakapharmacy.com.bd">{{ __('contact@dhakapharmacy.com.bd') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =========== Mobile footer design =========== -->
    <div class="mobile-footer ">
        <div class="container">
            <div class="row header-section p-0 justify-content-center gap-2">
                <div class="col text-center">
                    <a href="{{ route('home') }}"><img class="icon" src="{{ asset('frontend/asset/icons/nav/home-icon.svg') }}" alt="Home"></a>
                </div>
                <div class="col text-center">
                    <a href="{{ route('category.products', ['category' => 'all']) }}">
                        <img class="icon" src="{{ asset('frontend/asset/icons/nav/products-icon.svg') }}" alt="Products">
                    </a>
                </div>
                <div class="col">
                    <div class="right-col">
                        <a href="javascript:void(0)" class="cart-btn text-center d-block" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#cartbtn" aria-controls="offcanvasRight" >
                            <span>
                                <img class="icon" src="{{ asset('frontend/asset/icons/nav/cart-icon.svg') }}" alt="Cart">
                            </span>
                            <sup>
                                <strong id="cart_btn_quantity"></strong>
                            </sup>
                        </a>
                    </div>
                </div>
                <div class="col text-center">
                    <div class="upload_prescription w-100">
                        <a href="javascript:void(0)" class="cat-title  text-center" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
                            <img class="icon" src="{{ asset('frontend/asset/icons/nav/upload-prescription.svg') }}" alt="Upload upload-prescription">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======== Socket Row =========-->
    <div class="socket-row p-3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-center m-0">
                        {{ date('Y') }} &copy{{ __('All rights reserved by Dhaka Pharmacy') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
