<div class="col-mid">
    <div class="my-payment-feedback d-flex gap-4">
        <a href="{{ route('u.payment.list') }}" class="single d-block w-100">
            <div class="my-payment">
                <div class="img">
                    <img src="{{ asset('user/asset/img/my-payment.png') }}" alt="">
                </div>
                <h3 class="m-0">{{ __('My Payments') }}</h3>
            </div>
        </a>
        <a href="{{ route('u.fdk.index') }}" class="single d-block w-100 mt-3 mt-sm-0">
            <div class="feedback">
                <div class="img">
                    <img src="{{ asset('user/asset/img/feedback.png') }}" alt="">
                </div>
                <h3 class="m-0">{{ __('Feedback') }}</h3>
            </div>
        </a>
    </div>
</div>
