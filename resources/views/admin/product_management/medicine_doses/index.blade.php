@extends('admin.layouts.master', ['pageSlug' => 'medicine_dose'])
@section('title', 'Medicine Dose List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Medicine Dose List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_dose.medicine_dose_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new medicine dose',
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
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicine_doses as $medicine_dose)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $medicine_dose->name }} </td>
                                    <td> {{ $medicine_dose->slug }} </td>
                                    <td> <img height="70px" width="70px" style="object-fit: contain"
                                            src="{{ storage_url($medicine_dose->icon) }}"> </td>
                                    <td>
                                        <span
                                            class="{{ $medicine_dose->getStatusBadgeClass() }}">{{ $medicine_dose->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($medicine_dose->created_at) }}</td>

                                    <td> {{ c_user_name($medicine_dose->created_user) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$medicine_dose->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $medicine_dose->id,
                                                ],
                                                [
                                                    'routeName' => 'product.medicine_dose.medicine_dose_edit',
                                                    'params' => [$medicine_dose->slug],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine_dose.status.medicine_dose_edit',
                                                    'params' => [$medicine_dose->id],
                                                    'label' => $medicine_dose->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'product.medicine_dose.medicine_dose_delete',
                                                    'params' => [$medicine_dose->id],
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
    <div class="modal view_modal fade" id="medicineDoseModal" tabindex="-1" role="dialog"
        aria-labelledby="medicineDoseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medicineDoseModalLabel">{{ __('Medicine Dose Details') }}</h5>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6]])
@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view', function() {
                let id = $(this).data('id');
                let url = (
                    "{{ route('product.medicine_dose.details.medicine_dose_list', ['id']) }}");
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
                                        <th class="text-nowrap">Slug</th>
                                        <th>:</th>
                                        <td>${data.slug}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Image</th>
                                        <th>:</th>
                                        <td><img height='100px' width='100px' class='border p-2' src="${data.image}"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Description</th>
                                        <th>:</th>
                                        <td><span class="badge ${data.description}">${data.description}</span></td>
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
