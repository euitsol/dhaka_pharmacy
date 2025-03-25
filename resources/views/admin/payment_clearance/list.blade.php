@extends('admin.layouts.master', ['pageSlug' => 'pc_' . $activity])
@section('title', slugToTitle($activity) . ' List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(slugToTitle($activity) . ' List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Receiver') }}</th>
                                <th>{{ __('Point') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Activity') }}</th>
                                <th>{{ __('Submitted date') }}</th>
                                <th>{{ __('Submitted by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $pc)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $pc->receiver->name . ' ( ' . getSubmitterType($pc->receiver_type) . ' )' }}
                                    </td>
                                    <td> {{ number_format($pc->point, 2) }} ({!! get_taka_icon() . number_format($pc->point_history->eq_amount, 2) !!})</td>
                                    <td> {!! get_taka_icon() !!}{{ number_format($pc->eq_amount, 2) }}</td>
                                    <td>
                                        <span
                                            class="{{ $pc->activityBg() }}">{{ slugToTitle($pc->activityTitle()) }}</span>
                                    </td>
                                    <td>{{ timeFormate($pc->created_at) }}</td>

                                    <td> {{ c_user_name($pc->creater) . ' ( ' . getSubmitterType($pc->creater_type) . ' )' }}
                                    </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'pc.pc_details',
                                                    'params' => [encrypt($pc->id)],
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
