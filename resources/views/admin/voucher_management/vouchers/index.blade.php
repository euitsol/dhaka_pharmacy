@extends('admin.layouts.master', ['pageSlug' => 'vouchers'])
@section('title', 'Voucher List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Voucher List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'vm.vouchers.voucher_create',
                                'className' => 'btn-primary',
                                'label' => 'Add New Voucher',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __('Validity Period') }}</th>
                                <th>{{ __('Usage Limits') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $voucher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $voucher->code }}</td>
                                    <td>
                                        <span class="badge {{ $voucher->type_badge_class }}">
                                            {{ $voucher->type_string }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($voucher->type === 1)
                                            {{ $voucher->discount_amount }}%
                                        @elseif($voucher->type === 2)
                                            ৳{{ number_format($voucher->discount_amount, 2) }}
                                        @else
                                            Free Shipping
                                        @endif
                                    </td>
                                    <td>
                                        {{ $voucher->starts_at }} -
                                        {{ $voucher->expires_at }}
                                    </td>
                                    <td>
                                        {{ $voucher->redemptions_count }}/{{ $voucher->usage_limit }}<br>
                                        ({{ $voucher->user_usage_limit }} per user)
                                    </td>
                                    <td>
                                        <span class="badge {{ $voucher->status_badge_class }}">
                                            {{ $voucher->status_string }}
                                        </span>
                                    </td>
                                    <td>{{ timeFormate($voucher->created_at) }}</td>
                                    <td>{{ c_user_name($voucher->created_user) }}</td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'vm.vouchers.details.voucher_list',
                                                    'params' => [$voucher->id],
                                                    'label' => 'View Details',
                                                ],
                                                [
                                                    'routeName' => 'vm.vouchers.voucher_edit',
                                                    'params' => [$voucher->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'vm.vouchers.status.voucher_edit',
                                                    'params' => [$voucher->id],
                                                    'label' => $voucher->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'vm.vouchers.voucher_delete',
                                                    'params' => [$voucher->id],
                                                    'label' => 'Delete',
                                                    'delete' => true,
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

@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7, 8]])
