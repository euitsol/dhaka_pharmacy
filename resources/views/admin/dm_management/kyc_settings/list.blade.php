@extends('admin.layouts.master', ['pageSlug' => 'dm_kyc_settings'])
@section('title', 'Disrict Manager KYC List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @forelse ($kycs as $group_kyc)
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">{{ __('Disrict Manager ' . $group_kyc[0]->getStatus() . ' KYC') }}
                                </h4>
                            </div>
                            <div class="col-4 text-right">
                                @if ($group_kyc[0]->status == 1)
                                    @include('admin.partials.button', [
                                        'routeName' => 'dm_management.dm_kyc.settings.dm_kyc_create',
                                        'className' => 'btn-primary',
                                        'label' => 'Add New KYC',
                                    ])
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created date') }}</th>
                                    <th>{{ __('Created by') }}</th>
                                    <th>{{ __('Updated date') }}</th>
                                    <th>{{ __('Updated by') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($group_kyc as $kyc)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ Str::ucfirst($kyc->type) }} </td>
                                        <td>
                                            <span class="{{ $kyc->getStatusBadgeClass() }}">{{ $kyc->getStatus() }}</span>
                                        </td>
                                        <td>{{ timeFormate($kyc->created_at) }}</td>
                                        <td> {{ c_user_name($kyc->created_user) }} </td>
                                        <td>{{ $kyc->created_at != $kyc->updated_at ? timeFormate($kyc->updated_at) : 'Null' }}
                                        </td>
                                        <td> {{ u_user_name($kyc->updated_user) }} </td>
                                        <td>
                                            @if ($kyc->status == 1)
                                                @include('admin.partials.action_buttons', [
                                                    'menuItems' => [
                                                        [
                                                            'routeName' =>
                                                                'dm_management.dm_kyc.settings.dm_kyc_details',
                                                            'params' => [encrypt($kyc->id)],
                                                            'label' => 'Details',
                                                        ],
                                                    ],
                                                ])
                                            @else
                                                @include('admin.partials.action_buttons', [
                                                    'menuItems' => [
                                                        [
                                                            'routeName' =>
                                                                'dm_management.dm_kyc.settings.dm_kyc_details',
                                                            'params' => [encrypt($kyc->id)],
                                                            'label' => 'Details',
                                                        ],
                                                        [
                                                            'routeName' =>
                                                                'dm_management.dm_kyc.settings.dm_kyc_status',
                                                            'params' => [encrypt($kyc->id)],
                                                            'label' => $kyc->getBtnStatus(),
                                                        ],
                                                    ],
                                                ])
                                            @endif
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
            @empty
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">{{ __('Dis KYC Setting') }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                @include('admin.partials.button', [
                                    'routeName' => 'dm_management.dm_kyc.settings.dm_kyc_create',
                                    'className' => 'btn-primary',
                                    'label' => 'Add New KYC',
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created date') }}</th>
                                    <th>{{ __('Created by') }}</th>
                                    <th>{{ __('Updated date') }}</th>
                                    <th>{{ __('Updated by') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                        </nav>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6]])
