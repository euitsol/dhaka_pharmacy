@extends('admin.layouts.master', ['pageSlug' => 'medicine'])
@section('title', 'Product List')
@push('css_link')
    <link rel="stylesheet" href="{{ asset('plugin/datatable/datatables.min.css') }}">
@endpush

@push('css')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
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
                    <div class="row">
                        <div class="col-md-2">
                            <select id="categoryFilter" class="select2">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="companyFilter" class="select2">
                                <option value="">Select Company</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="genericNameFilter" class="select2">
                                <option value="">Select Generic Name</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select id="statusFilter" class="select2">
                                <option disabled selected>Status</option>
                                <option value="1">Active</option>
                                <option value="2">Pending</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select id="featuredFilter" class="select2">
                                <option disabled selected>Featured</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select id="bestSellingFilter" class="select2">
                                <option disabled selected>Medical Device</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="dateFilter" placeholder="Created Date"
                                class="form-control datepicker" />
                        </div>
                        <div class="col-md-1">
                            <button id="filterBtn" class="btn btn-primary" type="button"><i
                                    class="fa fa-filter"></i></button>
                        </div>
                        <div class="col-md-12 mt-3">
                            <table class="table table-striped medicinesTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('SL') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Product Category') }}</th>
                                        <th title="{{ __('Maximum Retail Price') }}">{{ __('MRP') }}</th>
                                        <th>{{ __('Discount') }} </th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Medical Device') }}</th>
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
        </div>
    </div>
    </div>
@endsection
@push('js_link')
    <script src="{{ asset('plugin/datatable/datatables.min.js') }}"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#categoryFilter').select2({
                placeholder: 'Select Category',
                allowClear: true,
                ajax: {
                    url: '{{ route('product.product_category.search.product_category_list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(category) {
                                return {
                                    id: category.id,
                                    text: category.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#companyFilter').select2({
                placeholder: 'Select Company',
                allowClear: true,
                ajax: {
                    url: '{{ route('product.company_name.search.company_name_list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        console.log(data);

                        return {
                            results: data.map(function(company) {
                                return {
                                    id: company.id,
                                    text: company.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#genericNameFilter').select2({
                placeholder: 'Select Generic Name',
                allowClear: true,
                ajax: {
                    url: '{{ route('product.generic_name.search.generic_name_list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        console.log(data);

                        return {
                            results: data.map(function(generic_name) {
                                return {
                                    id: generic_name.id,
                                    text: generic_name.name
                                };
                            })
                        };
                    },
                    cache: true,

                }
            });

            $('#filterBtn').click(function() {
                console.log('clicked');

                $('.medicinesTable').DataTable().draw();
            });

            $('.medicinesTable').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ request()->url() }}',
                    type: 'GET',
                    data: function(d) {
                        d.company_id = $('#companyFilter').val();
                        d.generic_id = $('#genericNameFilter').val();
                        d.status = $('#statusFilter').val();
                        d.category_id = $('#categoryFilter').val();
                        d.date = $('#dateFilter').val();
                        d.is_featured = $('#featuredFilter').val();
                        d.is_best_selling = $('#bestSellingFilter').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pro_cat.name',
                        name: 'pro_cat.name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'discounted_price',
                        name: 'discounted_price'
                    },
                    {
                        data: 'best_selling',
                        name: 'best_selling'
                    },
                    {
                        data: 'featured',
                        name: 'featured'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'created_user',
                        name: 'created_user'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc'],
                    // [3, 'desc'],
                    // [9, 'desc']
                ],
                buttons: [{
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'potrait',
                        pagesize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                        },
                    }, 'excel', 'csv', 'pageLength',
                ]
            });
        });
    </script>
@endpush
