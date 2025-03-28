@extends('admin.layouts.master', ['pageSlug' => 'doc'])
@section('title', 'Edit Documentation')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }} ">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Documentation') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'doc.doc_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('doc.doc_edit', $doc->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Title') }}</label>
                            <input type="text" name="title"
                                class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                placeholder="Enter title" value="{{ $doc->title }}">
                            @include('alerts.feedback', ['field' => 'title'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Module Key') }}</label>
                            <input type="text" name="module_key"
                                class="form-control {{ $errors->has('module_key') ? ' is-invalid' : '' }}"
                                placeholder="Enter module key" value="{{ $doc->module_key }}">
                            @include('alerts.feedback', ['field' => 'module_key'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Type') }}</label>
                            <select name="type" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                                <option selected hidden value=" ">{{ __('Select Type') }}</option>
                                <option {{ $doc->type == 'create' ? 'selected' : '' }} value="create">
                                    {{ __('Create') }}</option>
                                <option {{ $doc->type == 'update' ? 'selected' : '' }} value="update">
                                    {{ __('Update') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'type'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Documentation') }}</label>
                            <textarea name="documentation" class="form-control {{ $errors->has('documentation') ? ' is-invalid' : '' }}"
                                placeholder="Enter documentation">{{ $doc->documentation }}</textarea>
                            @include('alerts.feedback', ['field' => 'documentation'])
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
