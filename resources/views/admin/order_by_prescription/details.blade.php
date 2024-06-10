@extends('admin.layouts.master', ['pageSlug' => 'ubp'])
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Order From Prescription') }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <a href="javascript:void(0)" class="btn btn-primary item_add_btn">{{ __('Add New ') }}<i
                                    class="fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('obp.obp_order_create', encrypt($up->customer->id)) }}" method="POST">
                        @csrf
                        <input type="hidden" name="aid" value="{{ encrypt($up->address->id) }}">
                        <input type="hidden" name="delivery_type" value="{{ encrypt($up->delivery_type) }}">
                        <input type="hidden" name="up_id" value="{{ encrypt($up->id) }}">
                        <div id="my_product">
                            <div class="card item_card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h4 class="card-title">{{ __('Item-1') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>{{ __('Medicine') }}</label>
                                        <select name="item[1][medicine]"
                                            class="form-control {{ $errors->has('item.1.medicine') ? ' is-invalid' : '' }} medicine">
                                            <option value="" selected hidden>{{ __('Select Medicine') }}</option>
                                            @foreach ($medicines as $medicine)
                                                <option value="{{ $medicine->id }}"
                                                    {{ old('item.1.medicine') == $medicine->id ? 'selected' : '' }}>
                                                    {{ $medicine->name }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.1.medicine'])
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Unit') }}</label>
                                        <select name="item[1][unit]"
                                            class="form-control {{ $errors->has('item.1.unit') ? ' is-invalid' : '' }} unit"
                                            disabled>
                                            <option value="" selected hidden>{{ __('Select Unit') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.1.unit'])
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Quantity') }}</label>
                                        <select name="item[1][quantity]"
                                            class="form-control {{ $errors->has('item.1.quantity') ? ' is-invalid' : '' }}">
                                            <option value="" selected hidden>{{ __('Select Quantity') }}</option>
                                            @for ($i = 1; $i < 1000; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('item.1.quantity' == $i ? 'selected' : '') }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @include('alerts.feedback', ['field' => 'item.1.quantity'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-0">
                            <div class="form-group text-end">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Order By Prescription Details') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{ __('Customart Name') }}</th>
                                <th>:</th>
                                <td>{{ $up->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Customart Phone') }}</th>
                                <th>:</th>
                                <td>{{ $up->customer->phone }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Address') }}</th>
                                <th>:</th>
                                <td>{{ $up->address->address }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Type') }}</th>
                                <th>:</th>
                                <td>{{ ucwords($up->delivery_type) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer w-100">
                    <img src="{{ storage_url($up->image) }}" class="w-100" alt="Prescription">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.order_by_prescription.order_by_presc_js')
@endpush
