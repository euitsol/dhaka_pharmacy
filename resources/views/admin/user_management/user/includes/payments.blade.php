<table class="table table-striped payment_datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Customer') }}</th>
            <th>{{ __('Tran ID') }}</th>
            <th>{{ __('Order ID') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Created date') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td>{{ $payment->customer->name }}</td>
                <td>{{ $payment->transaction_id }}</td>
                <td>
                    @if (!auth()->user()->can('order_details'))
                        {{ $payment->order->order_id }}
                    @else
                        @if ($payment->order->status == 0 || $payment->order->status == 1)
                            <a class="btn btn-sm btn-success" target="_blank"
                                href="{{ route('om.order.order_details', encrypt($payment->order_id)) }}">{{ $payment->order->order_id }}</a>
                        @else
                            <a class="btn btn-sm btn-success" target="_blank"
                                href="{{ route('om.order.details.order_distribution', encrypt($payment->order->od->id)) }}">{{ $payment->order->order_id }}</a>
                        @endif
                    @endif
                </td>
                <td>{!! get_taka_icon(). number_format(ceil($payment->amount),2) !!}
                </td>
                <td><span class="{{ $payment->statusBg() }}">{{ $payment->statusTitle() }}</span></td>
                <td>{{ timeFormate($payment->created_at) }}</td>
                <td>
                    @include('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'pym.payment.payment_details',
                                'params' => [encrypt($payment->id)],
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
@include('admin.partials.datatable', [
    'columns_to_show' => [0, 1, 2, 3, 4, 5, 6],
    'mainClass' => 'payment_datatable',
])
