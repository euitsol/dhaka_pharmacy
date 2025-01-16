@extends('admin.layouts.master', ['pageSlug' => 'admin'])
@section('title', 'Admin List')
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
                            <h4 class="card-title">{{ __('Admin List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'am.admin.admin_create',
                                'className' => 'btn-primary',
                                'label' => 'Add admin',
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
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $admin->name }} </td>
                                    <td> {{ $admin->email }} </td>
                                    <td> {{ $admin->role->name }} </td>
                                    <td>
                                        <span class="{{ $admin->getStatusBadgeClass() }}">{{ $admin->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($admin->created_at) }}</td>

                                    <td> {{ c_user_name($admin->created_user) }} </td>
                                    <td>
                                        @php
                                            $profile = [];
                                        @endphp
                                        @if ($admin->id == admin()->id)
                                            @php
                                                $profile = [
                                                    'routeName' => 'am.admin.admin_profile',
                                                    'params' => [$admin->id],
                                                    'label' => 'Profile',
                                                ];
                                            @endphp
                                        @endif
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                $profile,
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$admin->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $admin->id,
                                                ],
                                                [
                                                    'routeName' => 'am.admin.admin_edit',
                                                    'params' => [$admin->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'am.admin.status.admin_edit',
                                                    'params' => [$admin->id],
                                                    'label' => $admin->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'am.admin.admin_delete',
                                                    'params' => [$admin->id],
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

    {{-- Admin Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Admin Details') }}</h5>
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
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('am.admin.details.admin_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status == 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status == 1 ? 'badge-success' :
                            'badge-warning';
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
                                        <td>
                                            <div id="lightbox" class="lightbox">
                                                <div class="lightbox-content">
                                                    <img src="${data.image}" class="lightbox_image">
                                                </div>
                                                <div class="close_button fa-beat">X</div>
                                            </div>
                                        </td>
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
                                        <th class="text-nowrap">Designation</th>
                                        <th>:</th>
                                        <td>${data.designation}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Role</th>
                                        <th>:</th>
                                        <td>${data.role.name}</td>
                                    </tr>
                                     <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email}</td>
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
                                        <th class="text-nowrap">Date Of Birth</th>
                                        <th>:</th>
                                        <td>${data.dob}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">IP Address</th>
                                        <th>:</th>
                                        <td>${data.ips}</td>
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
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        });
    </script>
@endpush
