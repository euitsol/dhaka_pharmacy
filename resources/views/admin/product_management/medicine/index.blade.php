@extends('admin.layouts.master', ['pageSlug' => 'medicine'])
@section('title', 'Product List')
@push('css_link')
    <link rel="stylesheet" href="{{ asset('plugin/datatable/datatables.min.css') }}">
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">{{ __('Product List') }}</h4>
                    </div>
                    <div class="col-4 text-right">
                        @include('admin.partials.button', [
                        'routeName' => 'product.medicine.medicine_create',
                        'className' => 'btn-primary',
                        'label' => 'Add new medicine',
                        ])
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped medicinesTable">
                    <thead>
                        <tr>
                            <th>{{ __('SL') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Product Category') }}</th>
                            <th title="{{ __('Maximum Retail Price') }}">{{ __('MRP') }}</th>
                            <th>{{ __('Discount') }} </th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Best Selling') }}</th>
                            <th>{{ __('Featured') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created date') }}</th>
                            <th>{{ __('Created by') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js_link')
    <script src="{{ asset('plugin/datatable/datatables.min.js') }}"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function () {
            $('.medicinesTable').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ request()->url() }}',
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'pro_cat.name', name: 'pro_cat.name' },
                    { data: 'price', name: 'price' },
                    { data: 'discount', name: 'discount' },
                    { data: 'discounted_price', name: 'discounted_price' },
                    { data: 'best_selling', name: 'best_selling'},
                    { data: 'featured', name: 'featured'},
                    { data: 'status', name: 'status'},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'created_user', name: 'created_user' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[1, 'asc'], [3, 'desc'], [9, 'desc']],
                buttons: [{
                            extend: 'pdfHtml5',
                            download: 'open',
                            orientation: 'potrait',
                            pagesize: 'A4',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6,7,8,9,10],
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6,7,8,9,10],
                            },
                        }, 'excel', 'csv', 'pageLength',
                    ]
            });
        });

    </script>
@endpush
