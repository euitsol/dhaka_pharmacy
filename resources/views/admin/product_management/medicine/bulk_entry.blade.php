@extends('admin.layouts.master', ['pageSlug' => 'bulk_entry'])
@section('title', 'Bulk Medicine Entry')

@push('css')
<style>
.bulk-entry-form  td th{
    vertical-align: unset !important;
}
.bulk-entry-form .form-check input[type="checkbox"], .bulk-entry-form .radio input[type="radio"] {
    opacity: 1 !important;
    visibility: visible !important;
}

.bulk-entry-form td{
    max-width: 20rem !important;
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
                        <h4 class="card-title">{{ __('Bulk Medicine Entry') }}</h4>
                    </div>
                    <div class="col-4 text-right">
                        @include('admin.partials.button', [
                            'routeName' => 'product.medicine.medicine_list',
                            'className' => 'btn-primary',
                            'label' => 'Back',
                        ])
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('product.medicine.store.bulk_entry') }}" class="bulk-entry-form" enctype="multipart/form-data" method="post">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="medicineTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px;"></th>
                                    <th>Name*</th>
                                    <th>Generic*</th>
                                    <th>Category*</th>
                                    <th>Sub Category</th>
                                    <th>Company*</th>
                                    <th style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button id="addNewRow" type="button" class="btn btn-info text-white">+ Add New Row</button>
                        <button id="saveAll" type="submit" class="btn btn-primary">Save All</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.product_management.medicine.includes.progress-modal')
@endsection

@push('js_link')
<script src="{{ asset('admin/js/medecine/bulk-entry.js') }}"></script>
@endpush
