@extends('district_manager.layouts.master', ['pageSlug' => 'user'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">User List</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm.user.create',
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
                                        <span
                                            class="badge {{ $user->status == 1 ? 'badge-success' : 'badge-warning' }}">{{ $user->status == 1 ? 'Active' : 'Disabled' }}</span>
                                    </td>
                                    <td>{{ timeFormate($user->created_at) }}</td>

                                    <td> {{ c_user_name($user->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'dm.user.profile',
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
                                                    'routeName' => 'dm.user.edit',
                                                    'params' => [$user->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'dm.user.status.edit',
                                                    'params' => [$user->id],
                                                    'label' => $user->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'dm.user.delete',
                                                    'params' => [$user->id],
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
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('dm.user.details.list', ['id']) }}");
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
                                        <th class="text-nowrap">Phone</th>
                                        <th>:</th>
                                        <td>${data.phone}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
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
