<div class="order-summary-details">
    <div class="d-flex justify-content-between">
        <h5>{{ __('Sub Total') }}</h5>
        <p>{!! get_taka_icon() !!}
            <span class="amount-a">{{ number_format(ceil($order->sub_total), 2) }}</span> (+)
        </p>
    </div>
    <div class="d-flex justify-content-between">
        <h5>{{ __('Product Discount') }}</h5>
        <p>{!! get_taka_icon() !!}
            <span class="amount-m">{{ number_format($order->product_discount, 2) }}</span> (-)
        </p>
    </div>
    <div class="d-flex justify-content-between">
        <h5>{{ __('Voucher Discount') }}</h5>
        <p>{!! get_taka_icon() !!}
            <span class="amount-m">{{ number_format($order->voucher_discount, 2) }}</span> (-)
        </p>
    </div>
    <div class="total-border d-flex justify-content-between mb-3">
        <h5>{{ __('Delivery Charge') }}</h5>
        <p>{!! get_taka_icon() !!}
            <span class="amount-a" id="delivery_charge">{{ number_format($order->delivery_fee, 2) }}</span> (+)
        </p>
    </div>
    <div class="d-flex justify-content-between">
        <h5>{{ __('Payable Amount') }}</h5>
        <p><span> {!! get_taka_icon() !!} </span>
            <span class="total-amount" id="total_amount">{{ number_format(ceil($order->total_amount), 2) }}</span>
        </p>
    </div>
</div>
