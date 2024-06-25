@extends('admin.layouts.master', ['pageSlug' => 'feedback'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Feedback Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'feedback.fdk_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>{{ __('Submitted By') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->creater->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Subject') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->subject }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Description') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->description }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Files') }}</th>
                                <th>:</th>
                                <td>
                                    @foreach (json_decode($feedback->files, true) as $file)
                                        <a href="{{ route('feedback.download.fdk_details', encrypt($file)) }}"
                                            class="btn btn-info me-2 text-white"><i class="fa-solid fa-download"></i></a>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Opened By') }}</th>
                                <th>:</th>
                                <td>{{ $feedback->openedBy->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Created Date') }}</th>
                                <th>:</th>
                                <td>{{ timeFormate($feedback->created_at) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Created By') }}</th>
                                <th>:</th>
                                <td>{{ c_user_name($feedback->creater) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Updated Date') }}</th>
                                <th>:</th>
                                <td>{{ timeFormate($feedback->updated_at) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Updated By') }}</th>
                                <th>:</th>
                                <td>{{ c_user_name($feedback->updater) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
