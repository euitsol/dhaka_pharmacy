@extends('admin.layouts.master', ['pageSlug' => 'order_' . titleToSlug($status, '_')])
@section('title', slugToTitle($status) . ' Order List')
@section('content')
{{ 'order_' . titleToSlug($status, '_') }}
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(slugToTitle($status) . ' Order List') }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <span class="badge {{ $status_bg_color }}">{{ slugToTitle($status) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Total Product') }}</th>
                                <th>{{ __('Total Payable') }}</th>
                                <th>{{ __('Delivery Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Ordered At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $order->order_id }}
                                    </td>
                                    <td>
                                        {{ $order->products->count() }}
                                    </td>
                                    <td>
                                        {!! get_taka_icon() !!}
                                        {{ number_format(ceil($order->total_amount)) }}
                                    </td>
                                    <td>
                                        {{ $order->delivery_type ?? '--'}}
                                    </td>
                                    <td>
                                        <span class=" badge {{ $order->getStatusBg() }}">
                                            {{ $order->status_string }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ timeFormate($order->created_at) }}
                                    </td>
                                    <td>
                                        {{-- @if ($order->status == 1)
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'om.order.order_details',
                                                        'params' => [encrypt($order->id)],
                                                        'label' => 'Details',
                                                    ],
                                                    [
                                                        'routeName' => 'om.order.order_distribution',
                                                        'params' => [encrypt($order->id)],
                                                        'label' => 'Order Distribution',
                                                    ],
                                                ],
                                            ])
                                        @else
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'om.order.order_details',
                                                        'params' => [encrypt($order->id)],
                                                        'label' => 'Details',
                                                    ],
                                                ],
                                            ])
                                        @endif --}}

                                        @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'om.order.order_details',
                                                        'params' => [encrypt($order->id)],
                                                        'label' => 'Details',
                                                    ],
                                                ],
                                            ])
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5], 'order' => 'asc'])
