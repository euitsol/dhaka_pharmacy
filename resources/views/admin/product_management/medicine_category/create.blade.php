@extends('admin.layouts.master', ['pageSlug' => 'medicine_category'])
@section('title', 'Create Medicine Dosage')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Medicine Dosage') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_category.medicine_category_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('product.medicine_category.medicine_category_create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">

                            <label>{{ __('Name') }}<span class="text-danger">*</span></label>
                            <input type="text" id="title" name="name" class="form-control"
                                placeholder="Enter name" value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                            <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                id="slug" name="slug" value="{{ old('slug') }}"
                                placeholder="{{ __('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
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
