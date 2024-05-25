@extends('rider.layouts.master', ['pageSlug' => $status.'_orders'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(ucwords(strtolower((str_replace('-', ' ', $status))))." Order List") }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Priority') }}</th>
                                <th>{{ __('Pharmacies') }}</th>
                                <th>{{ __('Delivery Address') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($dors as $dor)
                        
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $dor->od->order->order_id }} </td>
                                    <td> {{ $dor->priority() }} </td>
                                    <td>
                                        @foreach ($dor->pharmacy as $key => $pharmacy)
                                            {{str_limit($pharmacy->name,10)}} @if($key != (count($dor->pharmacy) - 1)) {{'| '}} @endif
                                        @endforeach 
                                    </td>
                                    <td> {{str_limit($dor->od->order->address->street_address,30)}} </td>
                                    <td>
                                        <span class="{{ $dor->statusBg() }}">{{ __(ucwords(strtolower(str_replace('-', ' ', $dor->statusTitle()))))  }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{route('rider.order_management.details',$dor->id)}}">{{ __("View Details") }}</a>
                                            </div>
                                        </div>
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
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])

