@extends('admin.layouts.master', ['pageSlug' => 'push_notification'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{$document ? 'col-md-8' : 'col-md-12'}} ">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title">{{ __('Push Notification Setting') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('push.update.ns') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('Channel') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('App ID')}}</label>
                                                <input type="text" name="app_id" value="{{ $notification_settings['app_id'] ?? '' }}" class="form-control {{ $errors->has('app_id') ? ' is-invalid' : '' }}" placeholder="Enter app id"
                                                    value="{{ old('app_id') }}">
                                                @include('alerts.feedback', ['field' => 'app_id'])
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('Key')}}</label>
                                                <input type="text" name="key" value="{{ $notification_settings['key'] ?? '' }}" class="form-control {{ $errors->has('key') ? ' is-invalid' : '' }}" placeholder="Enter key"
                                                    value="{{ old('key') }}">
                                                @include('alerts.feedback', ['field' => 'key'])
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('Secret')}}</label>
                                                <input type="text" name="secret" value="{{ $notification_settings['secret'] ?? '' }}" class="form-control {{ $errors->has('secret') ? ' is-invalid' : '' }}" placeholder="Enter secret"
                                                    value="{{ old('secret') }}">
                                                @include('alerts.feedback', ['field' => 'secret'])
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('Cluster')}}</label>
                                                <input type="text" name="cluster" value="{{ $notification_settings['cluster'] ?? '' }}" class="form-control {{ $errors->has('cluster') ? ' is-invalid' : '' }}" placeholder="Enter cluster"
                                                    value="{{ old('cluster') }}">
                                                @include('alerts.feedback', ['field' => 'cluster'])
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('Beame') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('Instance ID')}}</label>
                                                <input type="text" name="instance_id" value="{{ $notification_settings['instance_id'] ?? '' }}" class="form-control {{ $errors->has('instance_id') ? ' is-invalid' : '' }}" placeholder="Enter instance id"
                                                    value="{{ old('instance_id') }}">
                                                @include('alerts.feedback', ['field' => 'instance_id'])
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('Primary Key')}}</label>
                                                <input type="text" name="primary_key" value="{{ $notification_settings['primary_key'] ?? '' }}" class="form-control {{ $errors->has('primary_key') ? ' is-invalid' : '' }}" placeholder="Enter primary key"
                                                    value="{{ old('primary_key') }}">
                                                @include('alerts.feedback', ['field' => 'primary_key'])
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary ">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
