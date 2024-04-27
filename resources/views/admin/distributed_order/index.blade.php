@extends('admin.layouts.master', ['pageSlug' => 'order_'.$status])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Order '.ucwords(strtolower((str_replace('-', ' ', $status))))) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Pharmacy') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Total Product') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Distribution Type') }}</th>
                                <th>{{ __('Preparation Time') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dos as $do)
                                @foreach ($do->dops as $dop)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$dop->pharmacy->name}}</td>
                                        <td>{{$do->order->order_id}}</td>
                                        <td>{{count($dop)}}</td>
                                        <td>{{$do->paymentType()}}</td>
                                        <td>{{$do->distributionType()}}</td>
                                        <td>{{ $do->prep_time }}</td>
                                        <td>
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    ['routeName' => 'do.do_details',   'params' => [encrypt($do->id),encrypt($dop->pharmacy->id)], 'label' => 'Details'],
                                                ]
                                            ])
                                        </td>
                                    
                                    </tr>
                                @endforeach
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
