@extends('admin.layouts.master', ['pageSlug' => 'payment_'.$status])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __("Payment List") }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <span class="{{$statusBgColor}}">{{$status}}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Tran ID') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                {{-- <th>{{ __('Created by') }}</th> --}}
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $payment->customer->name }}</td>
                                    <td>{{json_decode($payment->details,true)['tran_id'] ?? '--'}}</td>
                                    <td>&#2547;{{isset(json_decode($payment->details,true)['amount']) ? number_format((json_decode($payment->details,true)['amount']),2) : '--'}}</td>
                                    <td><span class="{{$statusBgColor}}">{{$status}}</span></td>
                                    <td>{{ $payment->created_date() }}</td>

                                    {{-- <td> {{ $payment->created_user_name() }} </td> --}}
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'pym.payment.payment_details',
                                                    'params' => [encrypt($payment->id)],
                                                    'label' => 'Details',
                                                ],
                                            ],
                                        ])
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
