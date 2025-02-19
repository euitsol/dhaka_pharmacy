<div class="card">
    <div class="card-header">
        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                <h4 class="color-1 mb-0">{{ __('Order Details') }}</h4>
            </div>
            <div class="col-auto"> {{ __('Current Status :') }} <span
                    class="badge {{ $order->getStatusBg() }}">{{ $order->status_string }}</span></div>
        </div>
    </div>
    <div class="card-body order_details">
        <table class="table table-striped">
            <tr>
                <td class="fw-bolder">{{ __('Order ID') }}</td>
                <td>:</td>
                <td>{{ $order->order_id ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Order Date') }}</td>
                <td>:</td>
                <td>{{ timeFormate($order->created_at) }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Delivery Type') }}</td>
                <td>:</td>
                <td>{{ $order->delivery_type ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Total Amount') }}</td>
                <td>:</td>
                <td>
                    <span>
                        {!! get_taka_icon() !!}
                        {{ number_format($order->sub_total, 2) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Product Discount') }}</td>
                <td>:</td>
                <td>
                    <span>
                        {!! get_taka_icon() !!}
                        {{ number_format($order->product_discount, 2) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Sub Total Amout') }}</td>
                <td>:</td>
                <td>
                    <span>
                        {!! get_taka_icon() !!}
                        {{ number_format($order->sub_total - $order->product_discount, 2) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Voucher Discount') }}</td>
                <td>:</td>
                <td>
                    <span>
                        {!! get_taka_icon() !!}
                        {{ number_format($order->voucher_discount, 2) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Delivery Fee Discount') }}</td>
                <td>:</td>
                <td>
                    <span>
                        {!! get_taka_icon() !!}
                        {{ number_format($order->delivery_fee_discount, 2) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Total Payable Amount') }}</td>
                <td>:</td>
                <td>
                    <span>{!! get_taka_icon() !!}
                        {{ number_format($order->total_amount) }}</span>
                </td>
            </tr>
        </table>
    </div>
</div>
