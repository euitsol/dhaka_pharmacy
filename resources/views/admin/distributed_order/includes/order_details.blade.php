<table class="table table-striped">
    <tr>
        <td class="fw-bold">{{ __('Order ID') }}</td>
        <td>:</td>
        <td>{{ $od->order->order_id }}</td>
        <td class="fw-bold">{{ __('Preparation Time') }}</td>
        <td>:</td>
        <td>{!! remainingTime($od->pharmacy_prep_time, true) !!}</td>

    </tr>
    <tr>
        <td class="fw-bold">{{ __('Order Date') }}</td>
        <td>:</td>
        <td>{{ timeFormate($od->order->created_at) }}</td>
        <td class="fw-bold">{{ __('Order Status') }}</td>
        <td>:</td>
        <td><span class="{{ $od->order->statusBg() }}">{{ $od->order->statusTitle() }}</span>
        </td>

    </tr>
    <tr>
        <td class="fw-bold">{{ __('Order Type') }}</td>
        <td>:</td>
        <td>{{ $od->order->orderType() }}</td>
        <td class="fw-bold">{{ __('Process By') }}</td>
        <td>:</td>
        <td>{{ isset($od->order->od->creater) ? $od->order->od->creater->name : '--' }}
        </td>

    </tr>
    <tr>
        <td class="fw-bold">{{ __('Delivery Address') }}</td>
        <td>:</td>
        <td colspan="4" class="user-location"
            data-location="[{{ optional($od->order->address)->longitude }},{{ optional($od->order->address)->latitude }} ]">
            {!! optional($od->order->address)->address !!}</td>
    </tr>
</table>
