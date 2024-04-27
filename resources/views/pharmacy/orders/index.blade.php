@extends('pharmacy.layouts.master', ['pageSlug' => $status.'_orders'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(ucwords($status)." Orders List") }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Total Product') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Distribution Type') }}</th>
                                <th>{{ __('Preparetion Time') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($dops as $dop)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $dop->od->order->order_id }} </td>
                                    <td> {{ count($dop) }} </td>
                                    <td> {{ $dop->od->paymentType() }} </td>
                                    <td> {{ $dop->od->distributionType() }} </td>
                                    <td> {{ $dop->od->readablePrepTime() }} </td>
                                    
                                    <td>
                                        <span class="{{ $dop->statusBg }}">{{ $dop->statusTitle }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('pharmacy.order_management.details',['do_id'=>encrypt($dop->od->id), 'status'=>$status])}}">{{ __("View Details") }}</a>
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

