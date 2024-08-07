@extends('admin.layouts.master', ['pageSlug' => 'district_manager'])
@section('title', 'Create District Manager')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create District Manager') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm_management.district_manager.district_manager_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('dm_management.district_manager.district_manager_create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">

                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                value="{{ old('phone') }}">
                            @include('alerts.feedback', ['field' => 'phone'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Operation Area') }}</label>
                            <select name="oa_id" class="form-control">
                                <option selected hidden value=" ">{{ __('Select Operation Area') }}</option>
                                @foreach ($operation_areas as $area)
                                    <option value="{{ $area->id }}" {{ old('oa_id') == $area->id ? 'selected' : '' }}>
                                        {{ __($area->name) }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'oa_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
