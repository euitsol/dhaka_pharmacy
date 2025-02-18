@extends('admin.layouts.master', ['pageSlug' => "ubp_$details->status_string"])
@section('title', 'Order By Prescription Details')

@push('css_link')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush

@push('css')
    <style>
        .borderless td,
        .borderless th {
            border: none;
        }
        .scrollable_content{
            max-height: 10rem;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
@php
    $editable = ($details->status == App\Models\OrderPrescription::STATUS_PENDING)
@endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">{{ __('Order By Prescription') }}</h4>
                    <div class="">
                        @if ($editable)
                            @include('admin.partials.button', [
                                'routeName' => 'obp.obp_cancel',
                                'className' => 'btn-danger cancel',
                                'params' => encrypt($details->id),
                                'label' => 'Reject',
                            ])
                        @endif

                        @include('admin.partials.button', [
                            'routeName' => 'obp.obp_list',
                            'className' => 'btn-primary back ml-2',
                            'params' => strtolower($details->status_string),
                            'label' => 'Back',
                        ])
                    </div>
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
                                            <td>
                                                {{ optional($details->creater)->name ?? '--' }}
                                            </td>
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

                                                <span class="ml-2 badge bg-{{ optional($details->creater)->verified ? 'success' : 'secondary' }}">
                                                    {{ optional($details->creater)->verified ? 'Verified' : 'Unverified'}}
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
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('Prescription Images') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="image-container d-flex align-items-center">
                                        @if (optional($details->prescription) && $details->prescription->images->count() > 0)
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
                                            <td>{{ __('Order Prescription ID') }}</td>
                                            <td>:</td>
                                            <td>{{ $details->id ?? '--' }}</td>
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
                                            <td>
                                                <span class="badge {{ $details->statusBg() }}">
                                                    {{ $details->status_string ?? '--' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Additional Information') }}</td>
                                            <td>:</td>
                                            <td>
                                                <div class="scrollable_content">
                                                    {{ optional($details->prescription)->information ?? '--' }}
                                                </div>
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
                                                    class="badge {{ optional($details->order)->getStatusBg() ?? 'bg-secondary' }}">
                                                    {{ optional($details->order)->status_string ?? '--' }}
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

                                    @if ($editable)
                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-primary" id="add-medicine-row">
                                            <i class="fas fa-plus"></i> {{ __('Add Medicine') }}
                                        </button>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('obp.store.obp_details') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id" value="{{ encrypt(optional($details->creater)->id ?? '') }}" class="d-none">
                                        <input type="hidden" name="prescription_id" value="{{ encrypt(optional($details->prescription)->id ?? '') }}" class="d-none">

                                        @if ($editable)
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
                                        @else
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Medicine') }}</th>
                                                    <th>{{ __('Unit') }}</th>
                                                    <th>{{ __('Quantity') }}</th>
                                                    <th>{{ __('Price') }}</th>
                                                </tr>
                                                @if (optional($details->order)->products)
                                                @foreach (optional($details->order)->products as $product)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ optional($product->pivot)->unit_name ?? $product->pivot->unit_name }}</td>
                                                        <td>{{ optional($product->pivot)->quantity ?? $product->pivot->quantity }}</td>
                                                        <td>
                                                            <small>Unit Price: {{ optional($product->pivot)->unit_price ?? $product->pivot->unit_price }} BDT</small><br>
                                                            <small>Quantity: {{ optional($product->pivot)->quantity ?? $product->pivot->quantity }}</small><br>
                                                            <small>Sub Total: {{ optional($product->pivot)->unit_price * $product->pivot->quantity ?? $product->pivot->unit_price * $product->pivot->quantity }} BDT</small><br>
                                                            <small>Discount: {{ optional($product->pivot)->unit_discount * $product->pivot->quantity ?? $product->pivot->unit_discount * $product->pivot->quantity }} BDT</small><br>
                                                            <small>Total Price: {{ optional($product->pivot)->total_price ?? $product->pivot->total_price }} BDT</small><br>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endIf
                                            </table>
                                        @endif


                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h5>{{ __('Delivery Information') }}</h5>
                                                            </div>
                                                            @if ($editable)
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-primary float-end" id="add-delivery-address" data-bs-toggle="modal" data-bs-target="#address_add_modal"><i class="fas fa-plus"></i> {{ __('Add Delivery Address') }}</button>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if ($editable)
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>{{ __('Select Delivery Address') }}</label>
                                                            <select class="form-control" id="delivery-address" style="" name="address_id" required>
                                                                <option value="">{{ __('Select Address') }}</option>
                                                                @foreach ($addresses as $address)
                                                                    <option value="{{ $address['id'] }}">{{ $address['address'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>{{ __('Delivery Type') }}</label>
                                                            <select class="form-control" id="delivery-type" style="" disabled name="delivery_type" required>
                                                                <option value="">{{ __('Select Delivery Type') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="card-body">
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <td>{{ __('Full Address') }}</td>
                                                                <td>:</td>
                                                                <td>{{ optional($details->order)->address->address ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('City') }}</td>
                                                                <td>:</td>
                                                                <td>{{ optional($details->order)->address->city ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('Delivery Type') }}</td>
                                                                <td>:</td>
                                                                <td>{{ optional($details->order)->delivery_type ?? '--' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    @endif

                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>{{ __('Payment Information') }}</h5>
                                                    </div>
                                                    @if ($editable)
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="payemt_method">{{ __('Payment Method') }}</label>
                                                                <select class="form-control" id="payemt_method" style="" name="payment_method" required>
                                                                    <option value="">{{ __('Select Payment Method') }}</option>
                                                                    <option value="cod">{{ __('Cash On Delivery') }}</option>
                                                                    <option value="bkash">{{ __('Bkash') }}</option>
                                                                    <option value="nagad">{{ __('Nagad') }}</option>
                                                                    <option value="rocket">{{ __('Rocket') }}</option>
                                                                    <option value="ssl">{{ __('SSLCOMMERZ') }}</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="card-body">
                                                            <table class="table table-striped">
                                                                <tr>
                                                                    <th>{{ __('SL') }}</th>
                                                                    <th>{{ __('Transaction ID') }}</th>
                                                                    <th>{{ __('Amount') }}</th>
                                                                    <th>{{ __('Payment Method') }}</th>
                                                                    <th>{{ __('Status') }}</th>
                                                                    <th>{{ __('Date') }}</th>
                                                                </tr>
                                                                @if (optional($details->order)->payments)
                                                                @foreach (optional($details->order)->payments as $payment)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $payment->transaction_id }}</td>
                                                                        <td>{{ $payment->amount }}</td>
                                                                        <td>{{ $payment->payment_method }}</td>
                                                                        <td>
                                                                            <span class="{{ $payment->statusBg() }}">
                                                                                {{ $payment->statusTitle() }}
                                                                            </span>
                                                                        </td>
                                                                        <td>{{ timeFormate($payment->created_at) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                @endIf

                                                            </table>
                                                        </div>
                                                    @endIf
                                                </div>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">
                                                @if ($editable)
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
                                                @else
                                                <table class="table table-striped">
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Total Amount') }}</td>
                                                        <td>:</td>
                                                        <td><span>{{ optional($details->order)->sub_total  }}</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Product Discount') }}</td>
                                                        <td>:</td>
                                                        <td><span>{{ optional($details->order)->product_discount }}</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Sub Total Amount') }}</td>
                                                        <td>:</td>
                                                        <td><span>{{ optional($details->order)->sub_total - optional($details->order)->product_discount }}</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Voucher Discount') }}</td>
                                                        <td>:</td>
                                                        <td><span>{{ optional($details->order)->voucher_discount }}</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Delivery Charge') }}</td>
                                                        <td>:</td>
                                                        <td><span>{{ optional($details->order)->delivery_fee }}</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bolder">{{ __('Payable Amount') }}</td>
                                                        <td>:</td>
                                                        <td><span>{{ optional($details->order)->total_amount }}</span> {{ __('BDT') }}</td>
                                                    </tr>
                                                </table>
                                                @endif

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

    @if ($editable)
        @include('admin.order_by_prescription.partials.modal.create_address', ['cities' => $cities, 'user' => $details->creater])
    @endif
@endsection

@push('js_link')
    {{-- <script src="{{ asset('admin/js/ordermanagement.js') }}"></script> --}}
    <script src="{{ asset('admin/js/on.js') }}"></script>
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
