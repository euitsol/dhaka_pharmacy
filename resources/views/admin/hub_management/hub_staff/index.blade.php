@extends('admin.layouts.master', ['pageSlug' => 'hub_staff'])
@section('title', 'Hub Staff List')
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
                            <h4 class="card-title">{{ __('Hub Staff List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'hm.hub_staff.hub_staff_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new hub staff',
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
                                <th>{{ __('Hub') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Email Verify') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hub_staffs as $hub_staff)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $hub_staff->name }} </td>
                                    <td> {{ $hub_staff->hub->name }} </td>
                                    <td> {{ $hub_staff->email }} </td>
                                    <td>
                                        <span
                                            class="{{ $hub_staff->getStatusBadgeClass() }}">{{ $hub_staff->getStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $hub_staff->getEmailVerifyClass() }}">{{ $hub_staff->getEmailVerifyStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($hub_staff->created_at) }}</td>

                                    <td> {{ c_user_name($hub_staff->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'hm.hub_staff.login_as.hub_staff_profile',
                                                    'params' => [encrypt($hub_staff->id)],
                                                    'label' => 'Login As',
                                                    'target' => '_blank',
                                                ],
                                                // [
                                                //     'routeName' => 'hm.hub_staff.hub_staff_profile',
                                                //     'params' => [encrypt($hub_staff->id)],
                                                //     'label' => 'Profile',
                                                // ],
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$hub_staff->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $hub_staff->id,
                                                ],
                                                [
                                                    'routeName' => 'hm.hub_staff.hub_staff_edit',
                                                    'params' => [$hub_staff->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'hm.hub_staff.status.hub_staff_edit',
                                                    'params' => [$hub_staff->id],
                                                    'label' => $hub_staff->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'hm.hub_staff.hub_staff_delete',
                                                    'params' => [$hub_staff->id],
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

    {{-- Hub Staff Details Modal  --}}
    <div class="modal view_modal fade" id="hubStaffModal" tabindex="-1" role="dialog" aria-labelledby="hubStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hubStaffModalLabel">{{ __('Hub Staff Details') }}</h5>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = (
                    "{{ route('hm.hub_staff.details.hub_staff_list', ['id']) }}"
                );
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status == 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status == 1 ? 'badge-success' :
                            'badge-danger';
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
                                        <th class="text-nowrap">Gender</th>
                                        <th>:</th>
                                        <td>${data.gender_label}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Age</th>
                                        <th>:</th>
                                        <td>${data.age}</td>
                                    </tr>

                                    <tr>
                                        <th class="text-nowrap">Bio</th>
                                        <th>:</th>
                                        <td>${data.bio}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Phone Verify</th>
                                        <th>:</th>
                                        <td><span class="badge ${verifyStatusClass}">${verifyStatus}</span></td>
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
                        console.error('Error fetching Hub Staff data:', error);
                    }
                });
            });
        });
    </script>
@endpush
