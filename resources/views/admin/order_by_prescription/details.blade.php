@extends('admin.layouts.master', ['pageSlug' => "ubp_$details->status_string"])
@section('title', 'Order By Prescription Details')

@push('css_link')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush

@push('css')
<style>
    .borderless td, .borderless th {
        border: none;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Order By Prescription') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('User Information') }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>{{ __('Name') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->creater)->name ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Phone') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->prescription)->phone ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Type') }}</td>
                                            <td>:</td>
                                            <td>
                                                <span
                                                    class=" badge bg-{{ optional($details->creater)->name ? 'success' : 'secondary' }}">
                                                    {{ optional($details->creater)->name ? 'Authenticated' : 'Not Authenticated' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Joined at') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->creater) ? timeFormate($details->creater->created_at) : '--' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Current Status') }}</td>
                                            <td>:</td>
                                            <td>
                                                <span
                                                    class="{{ optional($details->creater)->getStatusBadgeClass() ?? 'secondary' }}">
                                                    {{ optional($details->creater)->getStatus() ?? '--' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Delivery Address') }}</td>
                                            <td>:</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    onclick="">{{ __('View Address') }}</button>
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#address_add_modal">{{ __(key: 'Create New Address') }}</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('Prescription Images') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="image-container d-flex align-items-center">
                                        @if ($details->prescription->images->count() > 0)
                                            @foreach ($details->prescription->images as $image)
                                                <div id="lightbox" class="lightbox mr-2">
                                                    <div class="lightbox-content">
                                                        <img src="{{ storage_url($image->path) }}" class="lightbox_image">
                                                    </div>
                                                    <div class="close_button fa-beat">X</div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No images available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('Prescription Information') }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>{{ __('Prescription ID') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->prescription)->id ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Submitted At') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->prescription) ? timeFormate($details->prescription->created_at) : '--' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Prescription status') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->prescription)->prescription ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Additional Information') }}</td>
                                            <td>:</td>
                                            <td style="height: 5rem; overflow-y: scroll">
                                                {{ optional($details->prescription)->additional_information ?? '--' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Order Information') }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>{{ __('Order ID') }}</td>
                                            <td>:</td>
                                            <td>{{ optional($details->order)->order_id ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Order Status') }}</td>
                                            <td>:</td>
                                            <td>
                                                <span
                                                    class="{{ optional($details->order)->getStatusBadgeClass() ?? 'secondary' }}">
                                                    {{ optional($details->order)->getStatus() ?? '--' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Submit Order') }}</h5>

                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-primary" id="add-medicine-row">
                                            <i class="fas fa-plus"></i> {{ __('Add Medicine') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST">
                                        @csrf

                                        <table class="table" id="medicine-order-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Medicine') }}</th>
                                                    <th>{{ __('Unit') }}</th>
                                                    <th>{{ __('Quantity') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>{{ __('Delivery Information') }}</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>{{ __('Delivery Address') }} <small class="text-danger">*</small></label>
                                                            <select name="delivery_address" id="delivery_address" class="form-control" required>
                                                                <option value="">{{ __('Select Delivery Address') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3 p-2">
                                                <table class="table borderless">
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Total Amount') }}</td>
                                                        <td>:</td>
                                                        <td><span id="total-amount">0</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Product Discount') }}</td>
                                                        <td>:</td>
                                                        <td><span id="product-discount">0</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Sub Total Amount') }}</td>
                                                        <td>:</td>
                                                        <td><span id="sub-total-amount">0</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Voucher Discount') }}</td>
                                                        <td>:</td>
                                                        <td><span id="voucher-discount">0</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Delivery Charge') }}</td>
                                                        <td>:</td>
                                                        <td><span id="delivery-charge">0</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Payable Amount') }}</td>
                                                        <td>:</td>
                                                        <td><span id="payable-amount">0</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-primary w-100">{{ __('Submit Order') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.order_by_prescription.partials.modal.create_address', ['cities' => $cities])
@endsection

@push('js_link')
    <script src="{{ asset('admin/js/ordermanagement.js') }}"></script>
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
