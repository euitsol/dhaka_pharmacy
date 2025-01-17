@extends('admin.layouts.master', ['pageSlug' => 'pharmacy'])
@section('title', 'Pharmacy List')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Pharmacy List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'pm.pharmacy.pharmacy_create',
                                'className' => 'btn-primary',
                                'label' => 'Add Pharmacy',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('KYC Status') }}</th>
                                <th>{{ __('Email Verify') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pharmacies as $pharmacy)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $pharmacy->name }} </td>
                                    <td> {{ $pharmacy->email }} </td>
                                    <td>
                                        <span
                                            class="{{ $pharmacy->getStatusBadgeClass() }}">{{ $pharmacy->getStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $pharmacy->getKycStatusClass() }}">{{ $pharmacy->getKycStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $pharmacy->getEmailVerifyClass() }}">{{ $pharmacy->getEmailVerifyStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($pharmacy->created_at) }}</td>

                                    <td> {{ c_user_name($pharmacy->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'pm.pharmacy.login_as.pharmacy_profile',
                                                    'params' => [encrypt($pharmacy->id)],
                                                    'label' => 'Login As',
                                                    'target' => '_blank',
                                                ],
                                                [
                                                    'routeName' => 'pm.pharmacy.pharmacy_profile',
                                                    'params' => [encrypt($pharmacy->id)],
                                                    'label' => 'Profile',
                                                ],
                                                [
                                                    'routeName' => 'pm.pharmacy.pharmacy_discount',
                                                    'params' => [encrypt($pharmacy->id)],
                                                    'label' => 'Pharmacy Discount',
                                                ],
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => encrypt($pharmacy->id),
                                                ],
                                                [
                                                    'routeName' => 'pm.pharmacy.pharmacy_edit',
                                                    'params' => [encrypt($pharmacy->id)],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'pm.pharmacy.status.pharmacy_edit',
                                                    'params' => [encrypt($pharmacy->id)],
                                                    'label' => $pharmacy->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'pm.pharmacy.pharmacy_delete',
                                                    'params' => [encrypt($pharmacy->id)],
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
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Pharmacy Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Pharmacy Details') }}</h5>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('pm.pharmacy.details.pharmacy_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Image</th>
                                        <th>:</th>
                                        <td><div id="lightbox" class="lightbox">
                                                <div class="lightbox-content">
                                                    <img src="${data.image}"
                                                        class="lightbox_image">
                                                </div>
                                                <div class="close_button fa-beat">X</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Pharmacy / Responsible Person Phone</th>
                                        <th>:</th>
                                        <td>${data.phone ?? 'null'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Emergency Phone</th>
                                        <th>:</th>
                                        <td>${data.emergency_phone ?? 'null'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Identification Type</th>
                                        <th>:</th>
                                        <td>${data.identificationType ?? 'null'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Identifiation File</th>
                                        <th>:</th>
                                        <td>${data.identification_file_url ? `<a class='btn btn-primary' target='_blank' href='${data.identification_file_url}'><i class='fa-solid fa-download'></i></a>` : `null`}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">KYC Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.kycStatusBg}">${data.kycStatusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email Verify</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.verifyStatusBg}">${data.verifyStatusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Operational Area</th>
                                        <th>:</th>
                                        <td>${data.operation_area ? data.operation_area.name : 'null'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Operational Sub Area</th>
                                        <th>:</th>
                                        <td>${data.operation_sub_area ? data.operation_sub_area.name : 'null'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created Date</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated Date</th>
                                        <th>:</th>
                                        <td>${data.updating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.updated_by}</td>
                                    </tr>
                                </table>
                                `;
                        $('.modal_data').html(result);
                        $('.view_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching pharmacy data:', error);
                    }
                });
            });
        });
    </script>
@endpush
