@extends('admin.layouts.master', ['pageSlug' => 'lam_kyc_list'])

@section('content')
    <div class="row">
        @forelse ($datas as $groupDatas)
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__("Local Area Manager ". (($groupDatas[0]['status'] === 1) ? 'Accepted' : (($groupDatas[0]['status'] === 0) ? 'Pending' : 'Declined')) ." KYC")}}</h4>
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
                                    <td> {{ $data->creater_name() }} </td>
                                    <td> {{ strtoupper($data->type) }} </td>
                                    <td>
                                        <span class="{{ $data->getStatusBadgeClass() }}">{{ $data->getStatus() }}</span>
                                    </td>
                                    <td>{{ $data->created_date() }}</td>

                                    <td> {{ $data->creater_name() }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'lam_management.lam_kyc.kyc_list.local_area_manager_kyc_details',
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
                            <h4 class="card-title">{{__("Local Area Manager KYC List")}}</h4>
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
