@extends('admin.layouts.master', ['pageSlug' => 'operation_sub_area'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('LAM Area List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm_management.operation_sub_area.operation_sub_area_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new lam area',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('DM Area') }}</th>
                                <th>{{ __('LAM Area') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($op_sub_areas as $op_sub_area)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $op_sub_area->operation_area->name }} </td>
                                    <td> {{ $op_sub_area->name }} </td>
                                    <td>
                                        <span class="{{$op_sub_area->getMultiStatusClass()}}">{{$op_sub_area->getMultiStatus()}}</span>
                                    </td>
                                    <td>{{ $op_sub_area->created_date() }}</td>

                                    <td> {{ $op_sub_area->creater_name() }} </td>
                                    <td>
                                        {{-- {{dd($op_sub_area->getMultiStatusBtn($op_sub_area->id, $op_sub_area->slug))}} --}}
                                        @include('admin.partials.action_buttons', 
                                            $op_sub_area->getMultiStatusBtn($op_sub_area->id, $op_sub_area->slug)
                                        )
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

    {{-- District Manager Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('LAM Area Details') }}</h5>
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
                let url = (
                    "{{ route('dm_management.operation_sub_area.details.operation_sub_area_list', ['id']) }}");
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
                                        <th class="text-nowrap">Category Name</th>
                                        <th>:</th>
                                        <td>${data.operation_area.name}</td>
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
                        console.error('Error fetching district manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
