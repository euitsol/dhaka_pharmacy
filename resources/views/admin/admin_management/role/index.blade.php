@extends('admin.layouts.master', ['pageSlug' => 'role'])
@section('title', 'Role List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Role List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'am.role.role_create',
                                'className' => 'btn-primary',
                                'label' => 'Add Role',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead class=" text-primary">
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Guard Name') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Update Date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ timeFormate($role->created_at) }}</td>
                                    <td>{{ timeFormate($role->updated_at) }}</td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$role->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $role->id,
                                                ],
                                                [
                                                    'routeName' => 'am.role.role_edit',
                                                    'params' => [$role->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'am.role.role_delete',
                                                    'params' => [$role->id],
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

    {{-- Role Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Role Details') }}</h5>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('am.role.details.role_list', ['id']) }}");
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
                                <th class="text-nowrap">Guard Name</th>
                                <th>:</th>
                                <td>${data.guard_name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Permissions</th>
                                <th>:</th>
                                <td>${data.permissionNames}</td>
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
                        console.error('Error fetching role data:', error);
                    }
                });
            });
        });
    </script>
@endpush
