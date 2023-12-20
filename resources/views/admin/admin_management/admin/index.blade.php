@extends('admin.layouts.master', ['pageSlug' => 'admin'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Admin List</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'am.admin.admin_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new admin',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ _('Name') }}</th>
                                <th>{{ _('Email') }}</th>
                                <th>{{ _('Role') }}</th>
                                <th>{{ _('Status') }}</th>
                                <th>{{ _('Creation date') }}</th>
                                <th>{{ _('Created by') }}</th>
                                <th>{{ _('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td> {{ $admin->name }} </td>
                                    <td> {{ $admin->email }} </td>
                                    <td> {{ $admin->role->name }} </td>
                                    <td>
                                        <span
                                            class="badge {{ $admin->status == 1 ? 'badge-success' : 'badge-warning' }}">{{ $admin->status == 1 ? 'Active' : 'Disabled' }}</span>
                                    </td>
                                    <td>{{ timeFormate($admin->created_at) }}</td>

                                    <td> {{ $admin->createdBy->name ?? 'system' }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    ['routeName' => 'am.admin.status.admin_edit',   'params' => [$admin->id], 'label' => $admin->getBtnStatus()],
                                                    ['routeName' => 'javascript:void(0)',  'params' => [$admin->id], 'label' => 'View Details', 'className' => 'view', 'data-id' => $admin->id ],
                                                    ['routeName' => 'am.admin.admin_edit',   'params' => [$admin->id], 'label' => 'Update'],
                                                    ['routeName' => 'am.admin.admin_delete', 'params' => [$admin->id], 'label' => 'Delete', 'delete' => true],
                                                ]
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
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _('Admin Details') }}</h5>
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
                let url = ("{{ route('am.admin.details.admin_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status = 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status = 1 ? 'badge-success' :
                            'badge-warning';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email}</td>
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
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
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
