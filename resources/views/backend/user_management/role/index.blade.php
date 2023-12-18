@extends('backend.layouts.master', ['pageSlug' => 'role'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Role List</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partial.button', ['routeName' => 'um.role.role_create', 'className' => 'btn-primary', 'label' => 'Add Role'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="">
                        <table class="table tablesorter datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>{{_('Name')}}</th>
                                    <th>{{_('Permission')}}</th>
                                    <th>{{_('Creation Date')}}</th>
                                    <th class="text-center">{{_('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->permissionNames}}</td>
                                    <td>{{date('d M, Y', strtotime($role->created_at))}}</td>
                                    <td>
                                        @include('backend.partial.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'javascript:void(0)',
                                                        'params' => [$role->id],
                                                        'label' => 'View',
                                                        'className' => 'view',
                                                    ],
                                                    [
                                                        'routeName' => 'um.role.role_edit',
                                                        'params' => [$role->id],
                                                        'label' => 'Update',
                                                    ],
                                                    [
                                                        'routeName' => 'um.role.role_delete',
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ _('Role Details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('backend.partial.datatable', ['columns_to_show' => [0,1,2,3]])
@push('js')
<script>
$(document).ready(function() {
    $('.view').on('click', function() {
        let id = $(this).data('id');
        let url = ("{{ route('um.role.details.role_list', ['id']) }}");
        let _url = url.replace('id', id);
        $.ajax({
            url: _url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var result = `
                        <table class="table tablesorter">
                            <tr>
                                <th class="text-nowrap">Name</th>
                                <th>:</th>
                                <td>${data.role.name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Guard Name</th>
                                <th>:</th>
                                <td>${data.role.guard_name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Permissions</th>
                                <th>:</th>
                                <td>${data.role.permissionNames}</td>
                            </tr>

                           
                            <tr>
                                <th class="text-nowrap">Created By</th>
                                <th>:</th>
                                <td>${data.role.created_user}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated By</th>
                                <th>:</th>
                                <td>${data.role.updated_user}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created At</th>
                                <th>:</th>
                                <td>${data.role.created_date}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated At</th>
                                <th>:</th>
                                <td>${data.role.updated_date}</td>
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