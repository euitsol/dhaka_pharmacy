@extends('admin.layouts.master', ['pageSlug' => 'vouchers'])
@section('title', 'Voucher Details')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Voucher Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'vm.vouchers.voucher_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="vouchers-table">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">{{ __('Code') }}</td>
                                    <td>{{ $voucher->code }}</td>
                                    <td class="fw-bold">{{ __('Type') }}</td>
                                    <td>
                                        <span class="badge {{ $voucher->type_badge_class }}">
                                            {{ $voucher->type_string }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Discount') }}</td>
                                    <td>
                                        @if ($voucher->type === 1)
                                            {{ $voucher->discount_amount }}%
                                        @elseif($voucher->type === 2)
                                            {!! get_taka_icon() !!} {{ number_format($voucher->discount_amount, 2) }}
                                        @else
                                            {{ __('Free Shipping') }}
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ __('Validity Period') }}</td>
                                    <td>
                                        {{ $voucher->starts_at }} -
                                        {{ $voucher->expires_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Usage Limits') }}</td>
                                    <td>
                                        {{ $voucher->redemptions_count }}/{{ $voucher->usage_limit }}<br>
                                        ({{ $voucher->user_usage_limit }} per user)
                                    </td>
                                    <td class="fw-bold">{{ __('Status') }}</td>
                                    <td>
                                        <span class="badge {{ $voucher->status_badge_class }}">
                                            {{ $voucher->status_string }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Created At') }}</td>
                                    <td>{{ timeFormate($voucher->created_at) }}</td>
                                    <td class="fw-bold">{{ __('Created By') }}</td>
                                    <td>{{ c_user_name($voucher->created_user) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">{{ __('Updated At') }}</td>
                                    <td>{{ $voucher->updated_at != $voucher->created_at ? timeFormate($voucher->updated_at) : 'null' }}
                                    </td>
                                    <td class="fw-bold">{{ __('Updated By') }}</td>
                                    <td>{{ u_user_name($voucher->updated_user) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Redemption List') }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Order Amount') }}</th>
                                <th>{{ __('Redeemed') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Created By') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($voucher->redemptions as $redemption)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ optional($redemption->user)->name }}</td>
                                    <td>
                                        {{ optional($redemption->order)->order_id }}
                                    </td>
                                    <td>
                                        {!! get_taka_icon() !!} {{ optional($redemption->order)->sub_total }}

                                    </td>
                                    <td>
                                        {!! get_taka_icon() !!} {{ optional($redemption->order)->voucher_discount }}

                                    </td>

                                    <td>{{ timeFormate($voucher->created_at) }}</td>
                                    <td>{{ c_user_name($voucher->created_user) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6]])
