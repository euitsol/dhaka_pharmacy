@extends('admin.layouts.master', ['pageSlug' => 'medicine_unit'])
@section('title', 'Edit Medicine Unit')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Medicine Unit') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_unit.medicine_unit_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('product.medicine_unit.medicine_unit_edit', $medicine_unit->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <label>{{ __('Name') }}<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name"
                                    value="{{ $medicine_unit->name }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group">
                                <label>{{ __('Image') }}</label>
                                <input type="file" accept="image/*" name="image" class="form-control image-upload"
                                    value="{{ old('image') }}" multiple
                                    @if (isset($medicine_unit->image)) data-existing-files="{{ storage_url($medicine_unit->image) }}"
                                      data-delete-url="" @endif>
                                @include('alerts.feedback', ['field' => 'image'])
                            </div>
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
