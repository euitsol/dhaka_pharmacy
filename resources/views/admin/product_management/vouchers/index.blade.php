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
                        'routeName' => 'product.vouchers.voucher_create',
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
                                @if($voucher->type === 1)
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
                            <td>{{ $voucher->created_by ? $voucher->created_user->name : 'System' }}</td>
                            <td>
                                @include('admin.partials.action_buttons', [
                                    'menuItems' => [
                                        [
                                            'routeName' => 'javascript:void(0)',
                                            'params' => [$voucher->id],
                                            'label' => 'View Details',
                                            'className' => 'view',
                                            'data-id' => $voucher->id,
                                        ],
                                        [
                                            'routeName' => 'product.vouchers.voucher_edit',
                                            'params' => [$voucher->id],
                                            'label' => 'Update',
                                        ],
                                        [
                                            'routeName' => 'product.vouchers.status.voucher_edit',
                                            'params' => [$voucher->id],
                                            'label' => $voucher->getBtnStatus(),
                                        ],
                                        [
                                            'routeName' => 'product.vouchers.voucher_delete',
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

{{-- Voucher Details Modal --}}
<div class="modal view_modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherModalLabel">{{ __('Voucher Details') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal_data">
                <!-- AJAX content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7, 8]])

@push('js')
<script>
    $(document).ready(function() {
        $('.view').on('click', function() {
            let id = $(this).data('id');
            let url = "{{ route('product.vouchers.details.voucher_list', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    let result = `
                        <table class="table table-striped">
                            <tr>
                                <th class="text-nowrap">Code</th>
                                <td>${data.code}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><span class="badge ${data.type_badge_class}">${data.type_string}</span></td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>${data.discount_amount}</td>
                            </tr>
                            <tr>
                                <th>Minimum Order</th>
                                <td>৳${data.min_order_amount}</td>
                            </tr>
                            <tr>
                                <th>Validity</th>
                                <td>${data.starts_at} to ${data.expires_at}</td>
                            </tr>
                            <tr>
                                <th>Usage Limits</th>
                                <td>${data.usage_limit}/${data.user_usage_limit} per user</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge ${data.status_badge_class}">${data.status_string}</span></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>${data.creating_time}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>${data.created_by}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>${data.updating_time}</td>
                            </tr>
                            <tr>
                                <th>Last Updated  By</th>
                                <td>${data.updated_by}</td>
                            </tr>
                        </table>
                    `;

                    $('.modal_data').html(result);
                    $('#voucherModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
