@extends('rider.layouts.master', ['pageSlug' => $dor->statusTitle() . '_orders'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __(ucwords($dor->statusTitle()) . ' Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            @include('admin.partials.button', [
                                'routeName' => 'rider.order_management.index',
                                'className' => 'btn-primary',
                                'params' => $dor->statusTitle(),
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>Customer Name</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->address->name }}</th>
                                <td>|</td>
                                <th>Customer Contact</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->address->phone }}</th>
                            </tr>
                            <tr>
                                <th>Delivery Address</th>
                                <td>:</td>
                                <th>{!! $dor->od->order->address->street_address !!}</th>
                                <td>|</td>
                                <th>Order ID</th>
                                <td>:</td>
                                <th>{{ $dor->od->order->order_id }}</th>
                               
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td>:</td>
                                <th>{{ $dor->priority() }}</th>
                                <td>|</td>
                                <th>Total Price</th>
                                <td>:</td>
                                <th>{{ $dor->totalPrice }}{!! get_taka_icon() !!}</th>
                            </tr>
                            <tr>
                                <th>Delivery Instraction</th>
                                <td>:</td>
                                <th colspan="5">{{ $dor->instraction }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Pharmacies Details') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-center">
                        @foreach ($dor->pharmacy as $pharmacy)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ $pharmacy->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped datatable">
                                            <tbody>
                                                <tr>
                                                    <th>Pharmacy Name</th>
                                                    <td>:</td>
                                                    <th>{{ $pharmacy->name }}</th>
                                                    <td>|</td>
                                                    <th>Pharmacy Contact</th>
                                                    <td>:</td>
                                                    <th>{{ $pharmacy->phone }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Operational Area</th>
                                                    <td>:</td>
                                                    <th>{{optional($pharmacy->operation_area)->name}}</th>
                                                    <td>|</td>
                                                    <th>Operational Sub Area</th>
                                                    <td>:</td>
                                                    <th>{{ optional($pharmacy->operation_sub_area)->name }}</th>
                                                   
                                                </tr>
                                                <tr>
                                                    <th>Pharmacy Address</th>
                                                    <td>:</td>
                                                    <th colspan="5">{{ $pharmacy->present_address }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    @if($dor->status == 3)
                        <div class="buttons text-end">
                            <a href="" class="btn btn-danger">{{__('Dispute')}}</a>
                            <a href="" class="btn btn-primary">{{__('Collect')}}</a>
                        </div>
                    @endif
                    @if($dor->status == 4)
                        <a href="" class="btn btn-danger">{{__('Cancel')}}</a>
                        <a href="" class="btn btn-primary">{{__('Delivered')}}</a>
                    @endif
                    @if($dor->status == 5)
                        <a href="" class="btn btn-primary">{{__('Complete')}}</a>
                    @endif
                    @if($dor->status == 7)
                        <a href="" class="btn btn-primary">{{__('Cancel Complete')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

