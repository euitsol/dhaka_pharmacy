@extends('user.layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="col-left d-flex flex-column">
                <div class="single-box current-order">
                    <div class="processing d-flex align-items-center justify-content-between">
                        <div class="title">
                            <h3>Processing</h3>
                            <h4>Est. Delivery 01 apr 23</h4>
                        </div>
                        <div class="btn">
                            <a href="#">Details</a>
                        </div>
                    </div>
                    <div class="progress-box">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar w-25"></div>
                        </div>
                    </div>
                    <div class="title">
                        <h2>Current Order</h2>
                    </div>
                </div>
                <div class="single-box previous-order">
                    <div class="count">
                        <span>10</span>
                    </div>
                    <div class="title">
                        <h2>Current Order</h2>
                    </div>
                </div>
                <div class="single-box cancel-order">
                    <div class="count">
                        <span>05</span>
                    </div>
                    <div class="title">
                        <h2>Current Order</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="col-mid">
                <div class="tips">
                    <h2>Our Latest Offers</h2>
                    <div class="single-tips d-flex align-items-center justify-content-between">
                        <img src="{{asset('user/asset/img/tips-img.png')}}" alt="">
                        <p>Helps you <span>track if you have missed any medication and aboid taking them too
                                many times</span> accidentally.</p>
                        <h2>Chek of a <br>
                            <span>Calender</span>
                        </h2>
                    </div>
                    <div class="single-tips d-flex align-items-center justify-content-between">
                        <img src="{{asset('user/asset/img/tips-img.png')}}" alt="">
                        <p>Helps you <span>track if you have missed any medication and aboid taking them too
                                many times</span> accidentally.</p>
                        <h2>Chek of a <br>
                            <span>Calender</span>
                        </h2>
                    </div>
                </div>
                <div class="order-cart-wish d-flex justify-content-center">
                    <a href="#">
                        <div class="single d-flex align-items-center justify-content-center">
                            <div class="content text-center">
                                <img src="{{asset('user/asset/img/my-order.png')}}" alt="">
                                <h2>My Orders</h2>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="single  d-flex align-items-center justify-content-center">
                            <div class="content text-center">
                                <img src="{{asset('user/asset/img/my-cart.png')}}" alt="">
                                <h2>My Cart</h2>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="single  d-flex align-items-center justify-content-center">
                            <div class="content text-center">
                                <img src="{{asset('user/asset/img/wishtlist2.png')}}" alt="">
                                <h2>Wishlist</h2>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="medicine-slider">
                    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <h3><span>Napa Extra</span>(500 mg+65 mg)</h3>
                                <p><span>Efficacy:</span> It might be more effective in treating the targeted
                                    condition or symptom compared to other similar medications.</p>
                            </div>
                            <div class="carousel-item active">
                                <h3><span>Napa Extra</span>(500 mg+65 mg)</h3>
                                <p><span>Efficacy:</span> It might be more effective in treating the targeted
                                    condition or symptom compared to other similar medications.</p>
                            </div>
                            <div class="carousel-item active">
                                <h3><span>Napa Extra</span>(500 mg+65 mg)</h3>
                                <p><span>Efficacy:</span> It might be more effective in treating the targeted
                                    condition or symptom compared to other similar medications.</p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <div class="circle"></div>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="my-payment-feedback d-flex">
                    <a href="#" class="single">
                        <div class="my-payment d-flex align-items-center justify-content-center">
                            <div class="img">
                                <img src="{{asset('user/asset/img/my-payment.png')}}" alt="">
                            </div>
                            <h3 class="m-0">My Payment</h3>
                        </div>
                    </a>
                    <a href="#" class="single">
                        <div class="feedback d-flex align-items-center justify-content-center">
                            <div class="img">
                                <img src="{{asset('user/asset/img/feedback.png')}}" alt="">
                            </div>
                            <h3 class="m-0">Feedback</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="col-right">
                <div class="latest-offer">
                    <h2>Our Latest Offers</h2>
                    <div class="slider">
                        <div id="carouselExampleDark" class="carousel carousel-dark slide"
                            data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                                    class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                            </div>

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="items d-flex">
                                        <div class="img-col">
                                            <a href="#"><img src="{{asset('user/asset/img/offer-img01')}}.png"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                        <div class="img-col">
                                            <a href="#"><img src="{{asset('user/asset/img/offter-img02.png')}}"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="items d-flex">
                                        <div class="img-col">
                                            <a href="#"><img src="{{asset('user/asset/img/offer-img01')}}.png"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                        <div class="img-col">
                                            <a href="#"><img src="{{asset('user/asset/img/offter-img02.png')}}"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="google-map">
                    <div class="address d-flex  align-items-center justify-content-between">
                        <div class="title">
                            <h3>Address</h3>
                        </div>
                        <div class="btn">
                            <a href="#">Add Address</a>
                        </div>
                    </div>
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.905936886909!2d90.3623165760301!3d23.750733488762368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf4555329783%3A0xc68ddf0215cbeb8c!2s387%20Jafrabad%20-%20Sanker%20Rd%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1714982430963!5m2!1sen!2sbd"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="address-btn">
                        <a href="https://maps.app.goo.gl/G5nS3cgwC6pLiBH79" target="_blank"><i
                                class="fa-solid fa-location-dot"></i><span>387/B Jafrabdh, Mohammadpur
                                Dhaka-1207</span><i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="customer-supporrt">
                    <a href="#">
                        <div class="single d-flex align-items-center justify-content-center">
                            <div class="support-img">
                                <img src="{{asset('user/asset/img/customer-support.png')}}" alt="">
                            </div>
                            <div class="title">
                                <h3 class="text-center">Customer<br> Support</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="log-out text-center">
                    <a href="javascript:void(0)" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <img src="{{asset('user/asset/img/log-out.png')}}" alt="">
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection