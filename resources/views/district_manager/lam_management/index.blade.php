@extends('district_manager.layouts.master', ['pageSlug' => 'lam'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Local Area Manager List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('district_manager.partials.button', [
                                'routeName' => 'dm.lam.create',
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
                                <th>{{ __('Operation Sub Area') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('KYC Status') }}</th>
                                <th>{{ __('Phone Verify') }}</th>
                                <th>{{ __('Created date') }}</th>
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
                                    <td>
                                        @if ($lam->operation_sub_area)
                                            {{ $lam->operation_sub_area->name }}
                                        @else
                                            <span class="badge badge-warning">{{ __('Area not allocated') }}</span>
                                        @endif

                                    </td>
                                    <td>
                                        <span class="{{ $lam->getStatusBadgeClass() }}">{{ $lam->getStatus() }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $lam->getKycStatusClass() }}">{{ $lam->getKycStatus() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $lam->getPhoneVerifyClass() }}">{{ $lam->getPhoneVerifyStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($lam->created_at) }}</td>
                                    <td> {{ c_user_name($lam->creater) }} </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                    href="{{ route('dm.lam.profile', $lam->id) }}">{{ __('Profile') }}</a>
                                                <a class="dropdown-item view" href="javascript:void(0)"
                                                    data-id="{{ $lam->id }}">{{ __('View Details') }}</a>


                                                <a class="dropdown-item"
                                                    href="{{ route('dm.lam.edit', $lam->id) }}">{{ __('Update') }}</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('dm.lam.status.edit', $lam->id) }}">{{ __('Status') }}</a>


                                                <a class="dropdown-item action-delete"
                                                    onclick="return confirm('Are you sure?')"
                                                    href="{{ route('dm.lam.delete', $lam->id) }}">{{ __('Delete') }}</a>

                                            </div>
                                        </div>
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
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
@include('district_manager.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('dm.lam.details.list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status == 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status == 1 ? 'badge-success' : 'badge-warning';
                        let lam_area = data.operation_sub_area ? data.operation_sub_area.name :
                            '-';
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
                                        <th class="text-nowrap">District Manager</th>
                                        <th>:</th>
                                        <td>${data.dm.name}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-nowrap">District Manager Area</th>
                                        <th>:</th>
                                        <td>${data.dm.operation_area.name}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="text-nowrap">Local Area Manager Area</th>
                                        <th>:</th>
                                        <td>${lam_area}</td>
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
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
