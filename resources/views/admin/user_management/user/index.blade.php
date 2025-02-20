@extends('admin.layouts.master', ['pageSlug' => 'user'])
@section('title', 'User List')
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
                            <h4 class="card-title">{{ __('User List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'um.user.user_create',
                                'className' => 'btn-primary',
                                'label' => 'Add User',
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
                            @foreach ($users as $user)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->phone }} </td>
                                    <td>
                                        <span class="{{ $user->getStatusBadgeClass() }}">{{ $user->getStatus() }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $user->getKycStatusClass() }}">{{ $user->getKycStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $user->getPhoneVerifyClass() }}">{{ $user->getPhoneVerifyStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($user->created_at) }}</td>

                                    <td> {{ c_user_name($user->creater) }} </td>
                                    <td>
                                        @php
                                            $actions = [
                                                [
                                                    'routeName' => 'um.user.user_profile',
                                                    'params' => [$user->id],
                                                    'label' => 'Profile',
                                                ],
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$user->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $user->id,
                                                ],
                                                [
                                                    'routeName' => 'um.user.user_edit',
                                                    'params' => [$user->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'um.user.status.user_edit',
                                                    'params' => [$user->id],
                                                    'label' => $user->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'um.user.user_delete',
                                                    'params' => [$user->id],
                                                    'label' => 'Delete',
                                                    'delete' => true,
                                                ],
                                            ];
                                            if ($user->is_verify == 1) {
                                                array_unshift($actions, [
                                                    'routeName' => 'um.user.login_as.user_profile',
                                                    'params' => [$user->id],
                                                    'label' => 'Login As',
                                                    'target' => '_blank',
                                                ]);
                                            }
                                        @endphp

                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => $actions,
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

    {{-- User Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('User Details') }}</h5>
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
                let url = ("{{ route('um.user.details.user_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status == 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status == 1 ? 'badge-success' :
                            'badge-danger';
                        let kycStatus = data.kyc_status == 1 ? 'Complete' : 'Pending';
                        let kycStatusClass = data.kyc_status == 1 ? 'badge-info' :
                            'badge-warning';
                        let verifyStatus = data.is_verify == 1 ? 'Success' : 'Pending';
                        let verifyStatusClass = data.is_verify == 1 ? 'badge-primary' :
                            'badge-dark';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                     <tr>
                                        <th class="text-nowrap">Father Name</th>
                                        <th>:</th>
                                        <td>${data.father_name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Mother Name</th>
                                        <th>:</th>
                                        <td>${data.mother_name}</td>
                                    </tr>
                                     <tr>
                                        <th class="text-nowrap">Occupation</th>
                                        <th>:</th>
                                        <td>${data.occupation}</td>
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
                                        <th class="text-nowrap">Phone</th>
                                        <th>:</th>
                                        <td>${data.phone}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Emergency Phone</th>
                                        <th>:</th>
                                        <td>${data.emergency_phone}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email ? data.email : '--'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">KYC Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${kycStatusClass}">${kycStatus}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Phone Verify</th>
                                        <th>:</th>
                                        <td><span class="badge ${verifyStatusClass}">${verifyStatus}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Date of Birth</th>
                                        <th>:</th>
                                        <td>${data.dob}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Identifiation Type</th>
                                        <th>:</th>
                                        <td>${data.identificationType}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Identifiation No</th>
                                        <th>:</th>
                                        <td>${data.identification_no}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Identifiation File</th>
                                        <th>:</th>
                                        <td>${data.identification_file_url ? `<a class='btn btn-primary' target='_blank' href='${data.identification_file_url}'><i
                                                        class='fa-solid fa-download'></i></a>` : `null`}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Gender</th>
                                        <th>:</th>
                                        <td>${data.getGender}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Bio</th>
                                        <th>:</th>
                                        <td>${data.bio}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Present Address</th>
                                        <th>:</th>
                                        <td>${data.present_address}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Permanent Address</th>
                                        <th>:</th>
                                        <td>${data.permanent_address}</td>
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
                        console.error('Error fetching user data:', error);
                    }
                });
            });
        });
    </script>
@endpush
