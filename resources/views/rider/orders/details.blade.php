@extends('rider.layouts.master', ['pageSlug' => $dor->statusTitle() . '_orders'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __(ucwords($dor->statusTitle()) . ' Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            @include('admin.partials.button', [
                                'routeName' => 'rider.order_management.index',
                                'className' => 'btn-primary',
                                'params' => $dor->statusTitle(),
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>{{ __('Customer Name') }}</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->address->name }}</th>
                                <td>|</td>
                                <th>{{ __('Customer Contact') }}</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->address->phone }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Address') }}</th>
                                <td>:</td>
                                <th>{!! $dor->od->order->address->address !!}</th>
                                <td>|</td>
                                <th>{{ __('Order ID') }}</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->order_id }}</th>

                            </tr>
                            <tr>
                                <th>{{ __('Priority') }}</th>
                                <td>:</td>
                                <th>{{ $dor->priority() }}</th>
                                <td>|</td>
                                <th>{{ __('Total Price') }}</th>
                                <td>:</td>
                                <th>{!! get_taka_icon() !!}{{ number_format(ceil($dor->od->order->totalDiscountPrice + $dor->od->order->delivery_fee)) }}
                                </th>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Instraction') }}</th>
                                <td>:</td>
                                <th colspan="5">{{ $dor->instraction }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Pharmacies Details') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-center">
                        @foreach ($dor->pharmacy as $pharmacy)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ $pharmacy->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped datatable">
                                            <tbody>
                                                <tr>
                                                    <th>{{ __('Pharmacy Name') }}</th>
                                                    <td>:</td>
                                                    <th>{{ $pharmacy->name }}</th>
                                                    <td>|</td>
                                                    <th>{{ __('Pharmacy Contact') }}</th>
                                                    <td>:</td>
                                                    <th>{{ $pharmacy->phone }}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Operational Area') }}</th>
                                                    <td>:</td>
                                                    <th>{{ optional($pharmacy->operation_area)->name }}</th>
                                                    <td>|</td>
                                                    <th>{{ __('Operational Sub Area') }}</th>
                                                    <td>:</td>
                                                    <th>{{ optional($pharmacy->operation_sub_area)->name }}</th>

                                                </tr>
                                                <tr>
                                                    <th>{{ __('Pharmacy Address') }}</th>
                                                    <td>:</td>
                                                    <th colspan="5">{{ $pharmacy->present_address }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @php
                                            $pharmacyOtp = App\Models\DistributionOtp::where(
                                                'order_distribution_id',
                                                $dor->od->id,
                                            )
                                                ->where('otp_author_id', $pharmacy->id)
                                                ->where('otp_author_type', get_class($pharmacy))
                                                ->first();
                                        @endphp
                                        @if ($pharmacyOtp)
                                            @if ($pharmacyOtp->status == 1)
                                                @if ($dor->od->status == 5)
                                                    <h4 class="text-success m-0 py-3">
                                                        {{ __('Order successfully delivered.') }}</h4>
                                                @elseif($dor->od->status == 6)
                                                    <h4 class="text-success m-0 py-3">
                                                        {{ __('Order successfully finished.') }}</h4>
                                                @else
                                                    <h4 class="text-success m-0 py-3">
                                                        {{ __('Order successfully collected.') }}</h4>
                                                @endif
                                            @else
                                                @if ($dor->status != 0 && $dor->status != -1)
                                                    <form
                                                        class="mt-3 form collect_form d-flex justify-content-between align-items-center"
                                                        action="{{ route('rider.order_management.pharmacy.otp_verify') }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group collect_otp">
                                                            <input type="text" name="collect_otp" class="form-control"
                                                                placeholder="Enter pharmacy verify otp">
                                                            <input type="hidden" name="pid" class="form-control"
                                                                value="{{ encrypt($pharmacy->id) }}">
                                                            <input type="hidden" name="od_id" class="form-control"
                                                                value="{{ encrypt($dor->od->id) }}">
                                                        </div>
                                                        @include('alerts.feedback', [
                                                            'field' => 'collect_otp',
                                                        ])
                                                        @include('alerts.feedback', ['field' => 'pid'])
                                                        @include('alerts.feedback', ['field' => 'od_id'])
                                                        <div class="form-group text-end">
                                                            <input type="submit" class="btn btn-secondary" value="Collect">
                                                        </div>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer ms-auto">
                    @if ($dor->status == 1)
                        <div class="buttons text-end">
                            <a href="javascript:void(0)" class="btn btn-danger dispute" data-name="dispute_reason"
                                data-action="{{ route('rider.order_management.dispute', encrypt($dor->od->id)) }}"
                                data-placeholder="Enter dispute reason" data-title="Dispute Form">{{ __('Dispute') }}</a>
                        </div>
                    @endif
                    @if ($dor->status == 2)
                        <a href="javascript:void(0)" class="btn btn-danger cancel" data-name="cancel_reason"
                            data-action="javascript:void(0)" data-placeholder="Enter cancel reason"
                            data-title="Cancel Form">{{ __('Cancel') }}</a>
                        <a href="javascript:void(0)" class="btn btn-primary delivered" data-name="delivered_otp"
                            data-action="{{ route('rider.order_management.customer.otp_verify', encrypt($dor->od->id)) }}"
                            data-placeholder="Enter user verify otp" data-title="Delivered Form">{{ __('Delivered') }}</a>
                    @endif
                    @if ($dor->status == 3)
                        <a href="javascript:void(0)" class="btn btn-success finish" data-name="trans_id"
                            data-action="javascript:void(0)" data-placeholder="Enter transaction details"
                            data-title="Delivery Finish Form">{{ __('Delivery Finish') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>



    {{-- Admin Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function showForm(element) {
            var title = element.data('title');
            var name = element.data('name');
            var action = element.data('action');
            var placeholder = element.data('placeholder');
            $('#modal_title').html(title);
            var data_form = `<form id="myForm">
                                @csrf
                                <div class="form-group">
                                    <textarea name="${name}" placeholder="${placeholder}" class="form-control"></textarea>
                                </div>
                                @include('alerts.feedback', ['field' => '${name}'])
                                <div class="form-group text-end">
                                    <span type="submit" data-action="${action}" id="updateEmailTemplate"  class="btn btn-primary formSubmit">{{ __('Submit') }}</span>
                                </div>
                            </form>`;
            $('.modal_data').html(data_form);
            $('.view_modal').modal('show');
        }
        $(document).ready(function() {


            $(document).on('click', '.formSubmit', function() {
                var form = $('#myForm');
                let _url = $(this).data('action');
                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: form.serialize(),
                    success: function(response) {
                        $('.view_modal').modal('hide');
                        // toastr.success(response.message);
                        window.location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Handle validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                // Display validation errors
                                var errorHtml = '';
                                $.each(messages, function(index, message) {
                                    errorHtml +=
                                        '<span class="invalid-feedback d-block" role="alert">' +
                                        message + '</span>';
                                });
                                $('[name="' + field + '"]').next('.invalid-feedback')
                                    .remove();
                                $('[name="' + field + '"]').after(errorHtml);
                            });
                        } else {
                            // Handle other errors
                            console.log('An error occurred.');
                        }
                    }
                });
            });

            $(document).on('click', '.dispute, .cancel, .delivered, .finish', function() {
                showForm($(this));
            });


        });
    </script>
@endpush
