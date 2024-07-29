<table class="table table-striped">
    <tr>
        <td class="fw-bold">{{ __('Order ID') }}</td>
        <td>:</td>
        <td>{{ $order->order_id }}</td>
        <td class="fw-bold">{{ __('Delivery Type') }}</td>
        <td>:</td>
        <td>{{ $order->deliveryType() }}</td>
    </tr>
    <tr>
        <td class="fw-bold">{{ __('Order Date') }}</td>
        <td>:</td>
        <td>{{ timeFormate($order->created_at) }}</td>
        <td class="fw-bold">{{ __('Order Status') }}</td>
        <td>:</td>
        <td><span class="{{ $order->statusBg() }}">{{ $order->statusTitle() }}</span>
        </td>

    </tr>
    <tr>
        <td class="fw-bold">{{ __('Order Type') }}</td>
        <td>:</td>
        <td>{{ $order->orderType() }}</td>
        <td class="fw-bold">{{ __('Payable Amount') }}</td>
        <td>:</td>
        <td class="fw-bold" colspan="4"><span>{!! get_taka_icon() !!}
            </span>{{ number_format(ceil($order->totalDiscountPrice + $order->delivery_fee)) }}
        </td>

    </tr>
    <tr>
        <td class="fw-bold">{{ __('Delivery Address') }}</td>
        <td>:</td>
        <td colspan="4" class="user-location"
            data-location="[{{ optional($order->address)->longitude }},{{ optional($order->address)->latitude }} ]">
            {!! optional($order->address)->address !!}</td>
    </tr>
</table>
