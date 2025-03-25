@extends('admin.layouts.master', ['pageSlug' => 'w_' . $status])
@section('title', "Withdraw $status List")
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __("Withdraw $status List") }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Receiver') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Submitted date') }}</th>
                                <th>{{ __('Submitted by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $w)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $w->receiver->name . ' ( ' . getSubmitterType($pc->receiver_type) . ' )' }}
                                    </td>
                                    <td> {!! get_taka_icon() !!}{{ number_format($w->amount, 2) }}</td>
                                    <td>
                                        <span class="{{ $w->statusBg() }}">{{ $w->statusTitle() }}</span>
                                    </td>
                                    <td>{{ timeFormate($w->created_at) }}</td>

                                    <td> {{ c_user_name($w->creater) . ' ( ' . getSubmitterType($w->creater_type) . ' )' }}
                                    </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'withdraw.w_details',
                                                    'params' => [encrypt($w->id)],
                                                    'label' => 'View Details',
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
