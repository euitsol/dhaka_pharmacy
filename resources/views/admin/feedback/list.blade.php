@extends('admin.layouts.master', ['pageSlug' => 'feedback'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Feedback List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Submitted By') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Opened By') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedbacks as $feedback)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $feedback->creater->name }} </td>
                                    <td>
                                        <span>
                                            {{ str_limit($feedback->subject, 50) }}

                                        </span>
                                        <sup class="{{ $feedback->getStatusBg() }}"
                                            style="font-size: 10px">{{ $feedback->getStatus() }}</sup>
                                    </td>
                                    <td> {{ $feedback->openedBy ? $feedback->openedBy->name : '--' }} </td>
                                    <td>{{ timeFormate($feedback->created_at) }}</td>
                                    <td> {{ c_user_name($feedback->creater) }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'feedback.fdk_details',
                                                    'params' => [$feedback->id],
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
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
