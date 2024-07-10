@extends('admin.layouts.master', ['pageSlug' => 'order_' . $order->statusTitle()])
@push('css_link')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
@endpush
@section('content')
    <div class="order_details_wrap">
        <div class="row px-3">
            <div class="card px-0">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row mb-3">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <h4 class="color-1 mb-0">{{ __('Order Details') }}</h4>
                                            @include('admin.partials.button', [
                                                'routeName' => URL::previous(),
                                                'className' => 'btn-primary',
                                                'label' => 'Back',
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body order_details">
                                    <div class="row">
                                        <div class="col-12">
                                            @include('admin.order_management.includes.order_details', [
                                                'od' => $order->od,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('om.order.order_distribution', encrypt($order->id)) }}" method="POST"
                            class="px-0">
                            @csrf
                            <div class="col-md-12 ">
                                <div class="card ">
                                    <div class="card-header">
                                        <div class="row justify-content-between mb-3">
                                            <div class="col-auto">
                                                <h4 class="color-1 mb-0">{{ __('Process') }}</h4>
                                            </div>
                                            <div class="col-auto  ">{{ __(' Process Status :') }} <span
                                                    class="{{ isset($order->od) ? $order->od->statusBg() : 'badge badge-danger' }}">{{ isset($order->od) ? 'Distributed' : 'Not processed' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body order_items">

                                        <div class="row">
                                            @foreach ($order->products as $key => $product)
                                                <div class="col-12">
                                                    <input type="hidden" name="datas[{{ $key }}][op_id]"
                                                        value="{{ $product->pivot->id }}">
                                                    <div class="card card-2 mb-3">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-9">
                                                                    <div class="media">
                                                                        <div class="sq align-self-center "> <img
                                                                                class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                                                src="{{ storage_url($product->image) }}"
                                                                                width="135" height="135" /> </div>
                                                                        <div class="media-body my-auto text-center">
                                                                            <div
                                                                                class="row  my-auto flex-column flex-md-row px-3">
                                                                                <div class="col my-auto">
                                                                                    <h6 class="mb-0 text-start">
                                                                                        {{ $product->name }}</h6>
                                                                                </div>
                                                                                <div class="col-auto my-auto">
                                                                                    <small>{{ $product->pro_cat->name }}
                                                                                    </small>
                                                                                </div>
                                                                                <div class="col my-auto">
                                                                                    <small>{{ __('Qty :') }}
                                                                                        {{ $product->pivot->quantity }}</small>
                                                                                </div>
                                                                                <div class="col my-auto">
                                                                                    <small>{{ __('Pack :') }}
                                                                                        {{ $product->pivot->unit->name ?? 'Piece' }}</small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        @if (isset($order->od) && $order->od->status == 0)
                                                                            @php
                                                                                $area = $order->od->odps[$key]->pharmacy
                                                                                    ->operation_area
                                                                                    ? ($order->od->odps[$key]->pharmacy
                                                                                        ->operation_sub_area
                                                                                        ? '( ' .
                                                                                            $order->od->odps[$key]
                                                                                                ->pharmacy
                                                                                                ->operation_area->name .
                                                                                            ' - '
                                                                                        : '( ' .
                                                                                            $order->od->odps[$key]
                                                                                                ->pharmacy
                                                                                                ->operation_area->name .
                                                                                            ' )')
                                                                                    : '';
                                                                                $sub_area = $order->od->odps[$key]
                                                                                    ->pharmacy->operation_sub_area
                                                                                    ? ($order->od->odps[$key]->pharmacy
                                                                                        ->operation_area
                                                                                        ? $order->od->odps[$key]
                                                                                                ->pharmacy
                                                                                                ->operation_sub_area
                                                                                                ->name . ' )'
                                                                                        : '( ' .
                                                                                            $order->od->odps[$key]
                                                                                                ->pharmacy
                                                                                                ->operation_sub_area
                                                                                                ->name .
                                                                                            ' )')
                                                                                    : '';
                                                                            @endphp

                                                                            <input type="text"
                                                                                value="{{ $order->od->odps[$key]->pharmacy->name }}"
                                                                                disabled class="form-control">
                                                                        @else
                                                                            <select
                                                                                name="datas[{{ $key }}][pharmacy_id]"
                                                                                class="form-control {{ $errors->has('datas.' . $key . '.pharmacy_id') ? ' is-invalid' : '' }} pharmacies">
                                                                                <option selected hidden value=" ">
                                                                                    {{ __('Select Pharmacy') }}</option>
                                                                                @foreach ($pharmacies as $pharmacy)
                                                                                    @php
                                                                                        $area = $pharmacy->operation_area
                                                                                            ? ($pharmacy->operation_sub_area
                                                                                                ? '( ' .
                                                                                                    $pharmacy
                                                                                                        ->operation_area
                                                                                                        ->name .
                                                                                                    ' - '
                                                                                                : '( ' .
                                                                                                    $pharmacy
                                                                                                        ->operation_area
                                                                                                        ->name .
                                                                                                    ' )')
                                                                                            : '';
                                                                                        $sub_area = $pharmacy->operation_sub_area
                                                                                            ? ($pharmacy->operation_area
                                                                                                ? $pharmacy
                                                                                                        ->operation_sub_area
                                                                                                        ->name . ' )'
                                                                                                : '( ' .
                                                                                                    $pharmacy
                                                                                                        ->operation_sub_area
                                                                                                        ->name .
                                                                                                    ' )')
                                                                                            : '';
                                                                                    @endphp
                                                                                    <option
                                                                                        @if (old('datas.' . $key . '.pharmacy_id') == $pharmacy->id) selected @endif
                                                                                        value="{{ $pharmacy->id }}"
                                                                                        data-location="[{{ optional($pharmacy->address)->longitude }}, {{ optional($pharmacy->address)->latitude }}]">
                                                                                        {{ $pharmacy->name . $area . $sub_area }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        @endif

                                                                        @include('alerts.feedback', [
                                                                            'field' =>
                                                                                'datas.' . $key . '.pharmacy_id',
                                                                        ])
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-12">
                                                <div class="row mt-3">
                                                    <div class="form-group col-md-4">
                                                        <label>{{ __('Payment Type') }}<span
                                                                class="text-danger">*</span></label>
                                                        @if (isset($order->od) && $order->od->status == 0)
                                                            <input type="text"
                                                                value="{{ $order->od->payment_type == 0 ? 'Fixed Payment' : ($order->od->payment_type == 1 ? 'Open Payment' : '') }}"
                                                                class="form-control" disabled>
                                                        @else
                                                            <select name="payment_type"
                                                                class="form-control {{ $errors->has('payment_type') ? ' is-invalid' : '' }}">
                                                                <option selected hidden value=" ">
                                                                    {{ __('Select Payment Type') }}
                                                                </option>
                                                                <option value="0"
                                                                    {{ old('payment_type') == 0 ? 'selected' : '' }}>
                                                                    {{ __('Fixed Payment') }}</option>
                                                                <option value="1"
                                                                    {{ old('payment_type') == 1 ? 'selected' : '' }}>
                                                                    {{ __('Open Payment') }}</option>
                                                            </select>
                                                        @endif
                                                        @include('alerts.feedback', [
                                                            'field' => 'payment_type',
                                                        ])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>{{ __('Distribution Type') }}<span
                                                                class="text-danger">*</span></label>
                                                        @if (isset($order->od) && $order->od->status == 0)
                                                            <input type="text"
                                                                value="{{ $order->od->distribution_type == 0 ? 'Normal Distribution' : ($order->od->distribution_type == 1 ? 'Priority Distribution' : '') }}"
                                                                class="form-control" disabled>
                                                        @else
                                                            <select name="distribution_type"
                                                                class="form-control {{ $errors->has('distribution_type') ? ' is-invalid' : '' }}">
                                                                <option selected hidden value=" ">
                                                                    {{ __('Select Distribution Type') }}</option>
                                                                <option value="0"
                                                                    {{ old('distribution_type') == 0 ? 'selected' : '' }}>
                                                                    {{ __('Normal Distribution') }}</option>
                                                                <option value="1"
                                                                    {{ old('distribution_type') == 1 ? 'selected' : '' }}>
                                                                    {{ __('Priority Distribution') }}</option>
                                                            </select>
                                                        @endif
                                                        @include('alerts.feedback', [
                                                            'field' => 'distribution_type',
                                                        ])
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="preparation-time">{{ __('Preparation Time') }}<span
                                                                class="text-danger">*</span></label>
                                                        <select id="preparation-time" class="form-control" name="prep_time">
                                                            <option value="5">5 minutes</option>
                                                            <option value="10">10 minutes</option>
                                                            <option value="15">15 minutes</option>
                                                            <option value="30">30 minutes</option>
                                                            <option value="45">45 minutes</option>
                                                            <option value="60">1 hour</option>
                                                            <option value="90">1.5 hours</option>
                                                            <option value="120">2 hours</option>
                                                        </select>
                                                        @include('alerts.feedback', [
                                                            'field' => 'prep_time',
                                                        ])
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>{{ __('Note') }}</label>
                                                        <textarea name="note" @if (isset($order->od) && $order->od->status == 0) disabled @endif
                                                            class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}"
                                                            placeholder="Enter order instraction for pharmacy">{{ isset($order->od->note) ? $order->od->note : old('note') }}</textarea>
                                                        @include('alerts.feedback', ['field' => 'note'])
                                                    </div>
                                                    @if (!isset($order->od))
                                                        <div class="form-group col-md-12 text-end">
                                                            <input type="submit" value="Distribute"
                                                                class="btn btn-primary">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_link')
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    <script src="{{ asset('admin/js/order_distribution.js') }}"></script>
@endpush
