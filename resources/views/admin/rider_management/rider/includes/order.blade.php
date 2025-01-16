<table class="table table-striped datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Order ID') }}</th>
            <th>{{ __('Priority') }}</th>
            <th>{{ __('Delivery Address') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($dors as $dor)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $dor->od->order->order_id }} </td>
                <td> {{ $dor->priority() }} </td>
                <td> {{ str_limit($dor->od->order->address->address, 30) }} </td>
                <td>
                    <span
                        class="{{ $dor->statusBg() }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $dor->statusTitle())))) }}</span>
                </td>
                <td>
                    @include('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'om.order.details.order_distribution',
                                'params' => [encrypt($dor->id)],
                                'target' => '_blank',
                                'label' => 'Details',
                            ],
                        ],
                    ])
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
