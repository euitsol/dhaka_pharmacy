@extends('admin.layouts.master', ['pageSlug' => 'permission'])
@section('title', 'Permission List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="card-title">{{ __('Permission List') }}</h4>
                        </div>
                        <div class="col-md-5 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'export.permissions',
                                'className' => 'btn-primary',
                                'label' => 'Export Permissions',
                            ])
                            @include('admin.partials.button', [
                                'routeName' => 'am.permission.permission_create',
                                'className' => 'btn-primary',
                                'label' => 'Add Permission',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="">
                        <table class="table table-striped datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Prefix') }}</th>
                                    <th>{{ __('Permisson') }}</th>
                                    <th>{{ __('Created Date') }}</th>
                                    <th>{{ __('Creadted by') }}</th>
                                    <th class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $permission->prefix }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ timeFormate($permission->created_at) }}</td>
                                        <td>{{ c_user_name($permission->created_user) }}</td>
                                        <td>
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'javascript:void(0)',
                                                        'params' => [$permission->id],
                                                        'label' => 'View Details',
                                                        'className' => 'view',
                                                        'data-id' => $permission->id,
                                                    ],
                                                    [
                                                        'routeName' => 'am.permission.permission_edit',
                                                        'params' => [$permission->id],
                                                        'label' => 'Update',
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
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Permission Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Permission Details') }}</h5>
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

@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2]])
@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view', function() {
                let id = $(this).data('id');
                let url = ("{{ route('am.permission.details.permission_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = `
                        <table class="table table-striped">
                            <tr>
                                <th class="text-nowrap">Prefix</th>
                                <th>:</th>
                                <td>${data.prefix}</td>
                            </tr>
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
