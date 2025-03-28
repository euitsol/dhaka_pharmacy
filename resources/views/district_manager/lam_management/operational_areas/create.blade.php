@extends('district_manager.layouts.master', ['pageSlug' => 'lam_area'])
@section('title', 'Create Operation Sub Area')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Operation Sub Area') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm.lam_area.list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dm.lam_area.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Operation Area') }}</label>
                            <input type="hidden" name="oa_id" class="form-control"
                                value="{{ dm()->operation_area->id }}">
                            <input type="text" class="form-control" value="{{ dm()->operation_area->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Operation Sub Area') }}</label>
                            <input type="text" id="title" name="name" class="form-control"
                                placeholder="{{ __('Enter name') }}" value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}</label>
                            <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                id="slug" name="slug" value="{{ old('slug') }}"
                                placeholder="{{ __('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <button type="submit" class="btn btn-primary float-end">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
