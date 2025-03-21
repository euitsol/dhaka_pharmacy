@extends('district_manager.layouts.master', ['pageSlug' => 'lam'])
@section('title', 'Create Local Area Manager')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Local Area Manager') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('district_manager.partials.button', [
                                'routeName' => 'dm.lam.list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dm.lam.create') }}">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Enter name') }}" value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone"
                                class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Enter phone') }}" value="{{ old('phone') }}">
                            @include('alerts.feedback', ['field' => 'phone'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('District Manager') }}</label>
                            <input type="text" class="form-control {{ $errors->has('dm_id') ? ' is-invalid' : '' }}"
                                value="{{ dm()->name }}" disabled>
                            <input type="hidden" name="dm_id" class="form-control" value="{{ dm()->id }}">
                            @include('alerts.feedback', ['field' => 'dm_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('District Manager Area') }}</label>
                            <input type="text" class="form-control" value="{{ dm()->operation_area->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Local Area Manager Area') }}</label>
                            <select name="osa_id" class="form-control {{ $errors->has('osa_id') ? ' is-invalid' : '' }}">
                                <option selected hidden value=" ">{{ __('Select Local Area Manager Area') }}</option>
                                @foreach (dm()->operation_area->operation_sub_areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ $area->id == old('osa_id') ? 'selected' : '' }}>
                                        {{ $area->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'osa_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Enter new password') }}">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation"
                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Confirm password') }}">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <button type="submit" class="btn btn-primary float-end">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('district_manager.partials.documentation', ['document' => $document])
    </div>
@endsection
