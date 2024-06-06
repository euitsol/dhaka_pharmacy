@extends('admin.layouts.master', ['pageSlug' => 'ubp'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Order By Prescription List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Prescription Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Order date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ups as $up)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $up->customer->name }}</td>
                                    <td>
                                        <img src="{{ storage_url($up->image) }}" width="60px" height="60px">
                                    </td>
                                    <td><span class="{{ $up->statusBg() }}">{{ $up->statusTitle() }}</span></td>
                                    <td>{{ timeFormate($up->created_at) }}</td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'obp.obp_details',
                                                    'params' => [encrypt($up->id)],
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4]])
