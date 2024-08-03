<table class="table table-striped datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Order ID') }}</th>
            <th>{{ __('Payment Type') }}</th>
            <th>{{ __('Distribution Type') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($ods as $od)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $od->order->order_id }} </td>
                <td> {{ $od->paymentType() }} </td>
                <td> {{ $od->distributionType() }} </td>
                <td>
                    <span class="{{ $od->statusBg() }}">{{ $od->statusTitle() }}</span>
                </td>
                <td>
                    @include('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'om.order.details.order_distribution',
                                'params' => [encrypt($od->id)],
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
