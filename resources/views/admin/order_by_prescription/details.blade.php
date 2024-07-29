@extends('admin.layouts.master', ['pageSlug' => 'ubp_' . $up->statusTitle()])
@section('content')
    <div class="row">
        @if ($up->status == 0)
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
                        <form action="{{ route('obp.obp_order_create', encrypt($up->id)) }}" method="POST">
                            @csrf
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
                                            <select name="item[1][medicine]" class="form-control medicine">
                                                <option value=" " selected hidden>{{ __('Select Medicine') }}</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'item.*.medicine'])
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Unit') }}</label>
                                            <select name="item[1][unit]" class="form-control unit" disabled>
                                                <option value=" " selected hidden>{{ __('Select Unit') }}</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'item.*.unit'])
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Quantity') }}</label>
                                            <input type="text" name="item[1][quantity]" class="form-control"
                                                placeholder="Enter item quantity">
                                            @include('alerts.feedback', ['field' => 'item.*.quantity'])
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
        @endif
        <div class="{{ $up->status == 0 ? 'col-md-6' : 'col-12' }}">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Order By Prescription Details') }}</h4>
                        </div>
                        @if ($up->status == 0)
                            <div class="col-4">
                                <div class="buttons text-end">
                                    @include('admin.partials.button', [
                                        'routeName' => 'obp.status_update',
                                        'className' => 'btn-primary',
                                        'params' => ['status' => 'cancel', 'id' => Crypt::encrypt($up->id)],
                                        'label' => 'Cancel',
                                    ])
                                </div>
                            </div>
                        @endif
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
                                <th>{{ __('Delivery Fee') }}</th>
                                <th>:</th>
                                <td>{!! get_taka_icon() !!}{{ number_format(ceil($up->delivery_fee)) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Type') }}</th>
                                <th>:</th>
                                <td>{{ $up->deliveryType() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer {{ $up->status == 0 ? 'w-100' : 'w-50 mx-auto' }}">
                    <img src="{{ storage_url($up->image) }}" class="w-100" alt="Prescription">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.order_by_prescription.order_by_presc_js')
@endpush
