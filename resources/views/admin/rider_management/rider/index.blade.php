@extends('admin.layouts.master', ['pageSlug' => 'rider'])
@section('title', 'Rider List')
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
                            <h4 class="card-title">{{ __('Rider List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'rm.rider.rider_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new rider',
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
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('KYC Status') }}</th>
                                <th>{{ __('Phone Verify') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riders as $rider)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $rider->name }} </td>
                                    <td> {{ $rider->phone }} </td>
                                    <td>
                                        <span class="{{ $rider->getStatusBadgeClass() }}">{{ $rider->getStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $rider->getKycStatusClass() }}">{{ $rider->getKycStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $rider->getPhoneVerifyClass() }}">{{ $rider->getPhoneVerifyStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($rider->created_at) }}</td>

                                    <td> {{ c_user_name($rider->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'rm.rider.login_as.rider_profile',
                                                    'params' => [$rider->id],
                                                    'label' => 'Login As',
                                                    'target' => '_blank',
                                                ],
                                                [
                                                    'routeName' => 'rm.rider.rider_profile',
                                                    'params' => [$rider->id],
                                                    'label' => 'Profile',
                                                ],
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$rider->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $rider->id,
                                                ],
                                                [
                                                    'routeName' => 'rm.rider.rider_edit',
                                                    'params' => [$rider->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'rm.rider.status.rider_edit',
                                                    'params' => [$rider->id],
                                                    'label' => $rider->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'rm.rider.rider_delete',
                                                    'params' => [$rider->id],
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

    {{-- Rider Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Rider Details') }}</h5>
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
                let url = ("{{ route('rm.rider.details.rider_list', ['_id']) }}");
                let _url = url.replace('_id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // let status = data.status == 1 ? 'Active' : 'Deactive';
                        // let statusClass = data.status == 1 ? 'badge-success' :
                        //     'badge-danger';
                        // let kycStatus = data.kyc_status == 1 ? 'Complete' : 'Pending';
                        // let kycStatusClass = data.kyc_status == 1 ? 'badge-info' :
                        //     'badge-warning';
                        // let verifyStatus = data.is_verify == 1 ? 'Success' : 'Pending';
                        // let verifyStatusClass = data.is_verify == 1 ? 'badge-primary' :
                        //     'badge-dark';
                        let oa = data.operation_area ? data.operation_area.name :
                            '<span class="badge badge-warning">{{ __('Area not allocated') }}</span>';
                        let osa = data.operation_sub_area ? data.operation_sub_area.name : '--';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Phone</th>
                                        <th>:</th>
                                        <td>${data.phone}</td>
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
                                        <td>${data.email ?? '--'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Gender</th>
                                        <th>:</th>
                                        <td>${data.getGender ?? '--'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Operation Area</th>
                                        <th>:</th>
                                        <td>${oa}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-nowrap">Operation Sub Area</th>
                                        <th>:</th>
                                        <td>${osa}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.statusBg}">${data.statusTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">KYC Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.kycVerifyBg}">${data.kycVerifyTitle}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Phone Verify</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.phoneVerifyBg}">${data.phoneVerifyTitle}</span></td>
                                    </tr>
                                     <tr>
                                        <th class="text-nowrap">Identification Type</th>
                                        <th>:</th>
                                        <td>${data.identificationType}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Identification No</th>
                                        <th>:</th>
                                        <td>${data.identification_no}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">CV</th>
                                        <th>:</th>
                                        <td>${data.cv ? `<a class='btn btn-primary' target='_blank' href='${data.cv}'><i
                                                                            class='fa-solid fa-download'></i></a>` : `null`}</td>
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
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
