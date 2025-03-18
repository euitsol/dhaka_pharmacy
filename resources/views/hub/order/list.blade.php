@extends('hub.layouts.master', ['pageSlug' => 'order_'.$status])
@section('title', 'Hub Dashboard')
@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">{{ __(slugToTitle($status) . ' Order List') }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <span class="badge {{ $status_bg }}">{{ slugToTitle($status) }}</span>
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
                            <th>{{ __('Delivery Type') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Ordered At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ohs as $oh)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ optional($oh->order)->order_id }}
                                </td>
                                <td>
                                    {{ optional($oh->order)->products->count() }}
                                </td>
                                <td>
                                    {{ ucfirst(optional($oh->order)->delivery_type ?? '--')}}
                                </td>
                                <td>
                                    <span class=" badge {{ $oh->status_bg }}">
                                        {{ ucfirst($oh->status_string) }}
                                    </span>
                                </td>
                                <td>
                                    {{ timeFormate(optional($oh->order)->created_at) }}
                                </td>
                                <td>
                                    @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'hub.order.details',
                                                    'params' => [encrypt($oh->id)],
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
        </div>
    </div>
</div>

@endsection
@include('hub.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5], 'order' => 'asc'])
