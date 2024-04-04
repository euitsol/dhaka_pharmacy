@extends('admin.layouts.master', ['pageSlug' => 'operation_sub_area'])

@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Update LAM Area') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm_management.operation_sub_area.operation_sub_area_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('dm_management.operation_sub_area.operation_sub_area_edit', $operation_sub_area->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('DM Area') }}</label>
                            <select name="oa_id" class="form-control">
                                @foreach ($operation_areas as $area)
                                    <option value="{{$area->id}}" {{($operation_sub_area->id == $area->id) ? 'selected' : ''}}>{{$area->name}}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'oa_id'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" id="title" name="name" class="form-control" placeholder="Enter name"
                                value="{{ $operation_sub_area->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ _('Slug') }}</label>
                            <input type="text" value="{{ $operation_sub_area->slug }}" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" name="slug" placeholder="{{ _('Enter Slug (must be use - on white speace)') }}">
                            @include('alerts.feedback', ['field' => 'slug'])
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
