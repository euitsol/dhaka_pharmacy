<table class="table table-striped datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Order ID') }}</th>
            <th>{{ __('Total Product') }}</th>
            <th>{{ __('Total Price') }}</th>
            <th>{{ __('Delivery Type') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Order date') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->products->count() }}</td>
                <td>{!! get_taka_icon() !!}{{ number_format(ceil($order->totalDiscountPrice + $order->delivery_fee)) }}
                </td>
                <td>{{ slugToTitle($order->delivery_type) }}</td>
                <td><span class="{{ $order->statusBg() }}">{{ $order->statusTitle() }}</span></td>
                <td>{{ timeFormate($order->created_at) }}</td>
                <td>
                    @if ($order->status == 0 || $order->status == 1)
                        @include('admin.partials.action_buttons', [
                            'menuItems' => [
                                [
                                    'routeName' => 'om.order.order_details',
                                    'params' => [encrypt($order->id)],
                                    'target' => '_blank',
                                    'label' => 'Details',
                                ],
                            ],
                        ])
                    @else
                        @include('admin.partials.action_buttons', [
                            'menuItems' => [
                                [
                                    'routeName' => 'om.order.details.order_distribution',
                                    'params' => [encrypt($order->od->id)],
                                    'target' => '_blank',
                                    'label' => 'Details',
                                ],
                            ],
                        ])
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 7]])
