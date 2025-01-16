@extends('admin.layouts.master', ['pageSlug' => 'rs_kyc_list'])
@section('title', 'Submitted KYC List')
@section('content')
    <div class="row">
        @forelse ($submitted_kyc as $kyc_group)
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">
                                    {{ __('Submitted ' . $kyc_group[0]->getStatus() . ' KYC List') }}
                                </h4>
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
                                    <th>{{ __('Created date') }}</th>
                                    <th>{{ __('Submitted by') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kyc_group as $kyc)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ c_user_name($kyc->creater) }} </td>
                                        <td> {{ ucfirst($kyc->type) }} </td>
                                        <td>
                                            <span class="{{ $kyc->getStatusBadgeClass() }}">{{ $kyc->getStatus() }}</span>
                                        </td>
                                        <td>{{ timeFormate($kyc->created_at) }}</td>

                                        <td> {{ c_user_name($kyc->creater) }} </td>
                                        <td>
                                            @include('admin.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'rm.rider_kyc.submitted_kyc.rs_kyc_details',
                                                        'params' => [$kyc->id],
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
                                <h4 class="card-title">{{ __('Submitted KYC List') }}</h4>
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
                                    <th>{{ __('Created date') }}</th>
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
