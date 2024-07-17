@extends('admin.layouts.master', ['pageSlug' => 'wm_' . $status])
@section('title', 'Withdraw Method List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Withdraw Method List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Account Name') }}</th>
                                <th>{{ __('Bank Name') }}</th>
                                <th>{{ __('Routing Number') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wms as $wm)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $wm->account_name }} </td>
                                    <td> {{ $wm->bank_name }} </td>
                                    <td> {{ $wm->routing_number }} </td>
                                    <td> {{ $wm->type }} </td>
                                    <td>
                                        <span class="{{ $wm->statusBg() }}">{{ $wm->statusTitle() }}</span>
                                    </td>
                                    <td>{{ timeFormate($wm->created_at) }}</td>

                                    <td> {{ c_user_name($wm->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'withdraw_method.wm_details',
                                                    'params' => [encrypt($wm->id)],
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
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6, 7]])
