@extends('admin.layouts.master', ['pageSlug' => 'medicine_unit'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Medicine Unit List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_unit.medicine_unit_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new medicine unit',
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
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicine_units as $medicine_unit)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $medicine_unit->name }} </td>
                                    <td> <img height="60px" width="60px" style="object-fit: cover"
                                            src="{{ storage_url($medicine_unit->image) }}" alt=""> </td>
                                    <td> {{ $medicine_unit->quantity }} </td>
                                    <td> {{ $medicine_unit->type ? $medicine_unit->type : '-' }} </td>
                                    <td>
                                        <span
                                            class="{{ $medicine_unit->getStatusBadgeClass() }}">{{ $medicine_unit->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($medicine_unit->created_at) }}</td>

                                    <td> {{ c_user_name($medicine_unit->created_user) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$medicine_unit->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $medicine_unit->id,
                                                ],
                                                [
                                                    'routeName' => 'product.medicine_unit.medicine_unit_edit',
                                                    'params' => [$medicine_unit->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine_unit.status.medicine_unit_edit',
                                                    'params' => [$medicine_unit->id],
                                                    'label' => $medicine_unit->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'product.medicine_unit.medicine_unit_delete',
                                                    'params' => [$medicine_unit->id],
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

    {{-- District Manager Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Medicine Unit Details') }}</h5>
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
                let url = ("{{ route('product.medicine_unit.details.medicine_unit_list', ['id']) }}");
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
                                        <th class="text-nowrap">Image</th>
                                        <th>:</th>
                                        <td> 
                                            <img height='100px' width='100px' class='border p-2' src="${data.image}">   
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Quantity</th>
                                        <th>:</th>
                                        <td>${data.quantity}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Type</th>
                                        <th>:</th>
                                        <td>${data.type}</td>
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
