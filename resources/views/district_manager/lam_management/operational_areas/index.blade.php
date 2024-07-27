@extends('district_manager.layouts.master', ['pageSlug' => 'lam_area'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Operation Area List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm.lam_area.create',
                                'className' => 'btn-primary',
                                'label' => 'Add new operation sub area',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table bordered datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Operation Areas') }}</th>
                                <th>{{ __('Operation Sub Areas') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operational_areas as $key => $area)
                                @forelse ($area->operation_sub_areas as $sub_area)
                                    <tr>
                                        @if ($loop->first)
                                            <td rowspan="{{ count($area->operation_sub_areas) }}">{{ ++$key }}</td>
                                            <td rowspan="{{ count($area->operation_sub_areas) }}">{{ $area->name }}</td>
                                        @endif
                                        <td>{{ $sub_area->name }}</td>
                                        <td>
                                            <span class="{{ $sub_area->getMultiStatusClass() }}">
                                                {{ $sub_area->status == 1 ? 'Operational' : ($sub_area->status == 0 ? 'Pending' : 'Not Operational') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item view" href="javascript:void(0)"
                                                        data-id="{{ $sub_area->id }}">{{ __('View Details') }}</a>
                                                    @if ($sub_area->status != 1 && $sub_area->creater(lam()))
                                                        <a class="dropdown-item"
                                                            href="{{ route('dm.lam_area.edit', $sub_area->slug) }}">{{ __('Update') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $area->name }}</td>
                                        <td>{{ 'empty' }}</td>
                                        <td>{{ 'empty' }}</td>
                                        <td>{{ 'empty' }}</td>
                                    </tr>
                                @endforelse
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

    {{-- District Manager Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Operation Sub Area Details') }}</h5>
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
{{-- @include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]]) --}}
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = (
                    "{{ route('dm.lam_area.details.list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status === 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status === 1 ? 'badge-success' :
                            'badge-warning';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">District Manager Area</th>
                                        <th>:</th>
                                        <td>${data.operation_area.name}</td>
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
                        console.error('Error fetching district manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
