@extends('admin.layouts.master', ['pageSlug' => 'operation_area'])

@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Operation Area') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'opa.operation_area.operation_area_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('opa.operation_area.operation_area_create') }}">
                        @csrf
                        <div class="form-group">

                            <label>{{__('Name')}}</label>
                            <input type="text" id="title" name="name" class="form-control" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ _('Slug') }}</label>
                            <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" name="slug" placeholder="{{ __('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
