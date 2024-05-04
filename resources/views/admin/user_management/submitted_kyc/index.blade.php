@extends('admin.layouts.master', ['pageSlug' => 'user_kyc_list'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">User KYC List</h4>
                        </div>
                        {{-- <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'um.user.user_kyc_create',
                                'className' => 'btn-primary',
                                'label' => 'Add User',
                            ])
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Submitted by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $data->type }} </td>
                                    <td>
                                        <span class="badge {{($data->status === 1) ? 'badge-success' : (($data->status === 0) ? 'badge-info' : 'badge-warning') }}">{{($data->status === 1) ? 'Accepted' : (($data->status === 0) ? 'Pending' : 'Declined') }}</span>
                                    </td>
                                    <td>{{ timeFormate($data->created_at) }}</td>

                                    <td> {{ c_user_name($data->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$data->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $data->id,
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
