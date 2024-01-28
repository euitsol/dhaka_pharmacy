@extends('district_manager.layouts.master', ['pageSlug' => 'lam'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Update Local Area Manager') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('dm.lam.list') }}" class="btn btn-sm btn-primary">{{ _("Back") }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dm.lam.edit', $lam->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ $lam->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                value="{{ $lam->phone }}">
                            @include('alerts.feedback', ['field' => 'phone'])
                        </div>
                        <div class="form-group {{ $errors->has('dm_id') ? ' has-danger' : '' }}">
                            <label>{{ __('District Manager') }}</label>
                            <select name="dm_id" class="form-control {{ $errors->has('dm_id') ? ' is-invalid' : '' }}" disabled>
                                <option value="{{ dm()->id }}" selected>{{ dm()->name }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'dm_id'])
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
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('district_manager.partials.documentation', ['document' => $document])
    </div>
@endsection
