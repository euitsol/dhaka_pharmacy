@extends('admin.layouts.master', ['pageSlug' => 'medicine_dose'])
@section('title', 'Edit Medicine Dose')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Medicine Dose') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_dose.medicine_dose_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('product.medicine_dose.medicine_dose_edit', $medicine_dose->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" id="title" name="name" class="form-control"
                                placeholder="Enter name" value="{{ $medicine_dose->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ _('Slug') }}</label>
                            <input type="text" value="{{ $medicine_dose->slug }}"
                                class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug"
                                name="slug" placeholder="{{ _('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="icon" class="form-control image-upload"
                                value="{{ old('icon') }}"
                                @if (isset($medicine_dose->icon)) data-existing-files="{{ storage_url($medicine_dose->icon) }}"
                                    data-delete-url="" @endif>
                            @include('alerts.feedback', ['field' => 'icon'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="Enter description">{{ $medicine_dose->description }}</textarea>
                            @include('alerts.feedback', ['field' => 'description'])
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
