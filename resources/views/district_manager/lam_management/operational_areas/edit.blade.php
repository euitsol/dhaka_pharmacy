@extends('district_manager.layouts.master', ['pageSlug' => 'lam_area'])
@section('title', 'Edit Operation Area')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Operation Area') }}</h4>
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
                    <form method="POST" action="{{ route('dm.lam_area.edit', $lam_area->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Operation Area') }}</label>
                            <input type="hidden" name="oa_id" class="form-control"
                                value="{{ dm()->operation_area->id }}">
                            <input type="text" class="form-control" value="{{ dm()->operation_area->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Operation Sub Area') }}</label>
                            <input type="text" id="title" name="name" class="form-control"
                                placeholder="Enter name" value="{{ $lam_area->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ _('Slug') }}</label>
                            <input type="text" value="{{ $lam_area->slug }}"
                                class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug"
                                name="slug" placeholder="{{ _('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <button type="submit" class="btn btn-primary float-end">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
