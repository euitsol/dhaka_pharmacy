@extends('frontend.layouts.master')
@section('title', 'Order Success')
@section('content')
    <div class="row py-5 my-5 order_success_wrap">
        <div class="col-12">
            <div class="order_success">
                <div class="printer-top"></div>
    
                <div class="paper-container">
                    <div class="printer-bottom"></div>
    
                    <div class="paper">
                        <div class="main-contents">
                            <div class="success-icon bg-danger text-white"><i class="fa-solid fa-xmark"></i></div>
                            <div class="success-title">
                                Payment Failed
                            </div>
                            <div class="success-description">
                                Unfortunately, your payment failed, and the transaction could not be completed.
                            </div>
                            <div class="order-details">
                                <div class="order-number-label">Order Id</div>
                                <div class="order-number">{{$order_id}}</div>
                            </div>
                            <div class="order-footer">You can close this page!</div>
                        </div>
                        <div class="jagged-edge"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
