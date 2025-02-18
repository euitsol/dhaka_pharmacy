<div class="card">
    <div class="card-header">
        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                <h4 class="color-1 mb-0">{{ __('Order Details') }}</h4>
            </div>
            <div class="col-auto"> {{ __('Current Status :') }} <span
                    class="badge {{ $order_hub->status_bg }}">{{ $order_hub->status_string }}</span></div>
        </div>
    </div>
    <div class="card-body order_details">
        <table class="table table-striped">
            <tr>
                <td class="fw-bolder">{{ __('Order ID') }}</td>
                <td>:</td>
                <td>{{ optional($order_hub->order)->order_id ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Order Date') }}</td>
                <td>:</td>
                <td>{{ timeFormate(optional($order_hub->order)->created_at) }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Delivery Type') }}</td>
                <td>:</td>
                <td>{{ optional($order_hub->order)->delivery_type ?? '--' }}</td>
            </tr>
        </table>
    </div>
</div>
