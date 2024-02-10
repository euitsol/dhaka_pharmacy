@extends('admin.layouts.master', ['pageSlug' => 'local_area_manager'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Local Area Manager List')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'lam_management.local_area_manager.local_area_manager_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new local area manager',
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
                                <th>{{ __('District Manager') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lams as $lam)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $lam->name }} </td>
                                    <td> {{ $lam->phone }} </td>
                                    <td> {{ $lam->dm->name }} </td>
                                    <td>
                                        <span
                                            class="{{ $lam->getStatusBadgeClass() }}">{{ $lam->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($lam->created_at) }}</td>

                                    <td> {{ $lam->creater->name ?? 'system' }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    ['routeName' => 'lam_management.local_area_manager.login_as.local_area_manager_profile',   'params' => [$lam->id], 'label' => 'Login As'],
                                                    ['routeName' => 'lam_management.local_area_manager.local_area_manager_profile',   'params' => [$lam->id], 'label' => 'Profile'],
                                                    ['routeName' => 'javascript:void(0)',  'params' => [$lam->id], 'label' => 'View Details', 'className' => 'view', 'data-id' => $lam->id ],
                                                    ['routeName' => 'lam_management.local_area_manager.local_area_manager_edit',   'params' => [$lam->id], 'label' => 'Update'],
                                                    ['routeName' => 'lam_management.local_area_manager.status.local_area_manager_edit',   'params' => [$lam->id], 'label' => $lam->getBtnStatus()],
                                                    ['routeName' => 'lam_management.local_area_manager.local_area_manager_delete', 'params' => [$lam->id], 'label' => 'Delete', 'delete' => true],
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

    {{-- Local Area Manager Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Local Area Manager Details') }}</h5>
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
                let url = ("{{ route('lam_management.local_area_manager.details.local_area_manager_list', ['id']) }}");
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
                                        <th class="text-nowrap">Phone</th>
                                        <th>:</th>
                                        <td>${data.phone}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.email ?? 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Role</th>
                                        <th>:</th>
                                        <td>${data.dm.name}</td>
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
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
