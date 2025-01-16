<div class="card order_details_card">
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <td class="fw-bold">{{ __('Order ID') }}</td>
                <td>:</td>
                <td>{{ $order->order_id }}</td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Order Status') }}</td>
                <td>:</td>
                <td>
                    <span class="{{ $order->statusBg() }}">{{ slugToTitle($order->statusTitle()) }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Order Type') }}</td>
                <td>:</td>
                <td>{{ $order->orderType() }}</td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Delivery Type') }}</td>
                <td>:</td>
                <td>{{ $order->deliveryType() }}</td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Submitted At') }}</td>
                <td>:</td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Total Product') }}</td>
                <td>:</td>
                <td>
                    <span class="badge badge-info">{{ $products->count() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Payable Amount') }}</td>
                <td>:</td>
                <td class="fw-bold" colspan="4"><span>{!! get_taka_icon() !!}
                    </span>{{ number_format(ceil($order->totalDiscountPrice + $order->delivery_fee)) }}
                </td>
            </tr>
            <tr>
                <td class="fw-bold">{{ __('Delivery Address') }}</td>
                <td>:</td>
                <td>{!! optional($order->address)->address !!}</td>
            </tr>
        </table>
    </div>
</div>
