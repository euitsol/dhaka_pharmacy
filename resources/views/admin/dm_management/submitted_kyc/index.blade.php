@extends('admin.layouts.master', ['pageSlug' => 'dm_kyc_list'])

@section('content')
    <div class="row">
        @forelse ($datas as $groupDatas)
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__("District Manager ". (($groupDatas[0]['status'] === 1) ? 'Accepted' : (($groupDatas[0]['status'] === 0) ? 'Pending' : 'Declined')) ." KYC")}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Submitted by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupDatas as $data)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ c_user_name($data->creater) }} </td>
                                    <td> {{ strtoupper($data->type) }} </td>
                                    <td>
                                        <span class="badge {{($data->status === 1) ? 'badge-success' : (($data->status === 0) ? 'badge-info' : 'badge-warning') }}">{{($data->status === 1) ? 'Accepted' : (($data->status === 0) ? 'Pending' : 'Declined') }}</span>
                                    </td>
                                    <td>{{ timeFormate($data->created_at) }}</td>

                                    <td> {{ c_user_name($data->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'dm_management.dm_kyc.kyc_list.district_manager_kyc_details',
                                                    'params' => [$data->id],
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
        @empty
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__("District Manager KYC List")}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Submitted by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
        @endforelse
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
