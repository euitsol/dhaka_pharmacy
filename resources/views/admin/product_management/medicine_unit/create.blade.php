@extends('admin.layouts.master', ['pageSlug' => 'medicine_unit'])

@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Medicine Unit') }}</h4>
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
                <form method="POST" action="{{ route('product.medicine_unit.medicine_unit_create') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">

                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name"
                                    value="{{ old('name') }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group col-md-6">

                                <label>{{ __('Quantity') }}</label>
                                <input type="text" name="quantity" class="form-control" placeholder="Enter quantity"
                                    value="{{ old('quantity') }}">
                                @include('alerts.feedback', ['field' => 'quantity'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Image') }}</label>
                                <input type="file" accept="image/*" name="image" class="form-control image-upload"
                                    value="{{ old('image') }}">
                                @include('alerts.feedback', ['field' => 'image'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Type') }}</label>
                                <select name="type" class="form-control">
                                    <option selected hidden value=" ">{{ __('Select type') }}</option>
                                    <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>
                                        {{ __('Tablet') }}</option>
                                    <option value="capsul" {{ old('type') == 'capsul' ? 'selected' : '' }}>
                                        {{ __('Capsul') }}</option>
                                    <option value="cream" {{ old('type') == 'cream' ? 'selected' : '' }}>
                                        {{ __('Cream') }}</option>
                                    <option value="pad" {{ old('type') == 'pad' ? 'selected' : '' }}>
                                        {{ __('Pad') }}</option>
                                    <option value="bottle" {{ old('type') == 'bottle' ? 'selected' : '' }}>
                                        {{ __('Bottle') }}</option>
                                    <option value="syringe" {{ old('type') == 'syringe' ? 'selected' : '' }}>
                                        {{ __('Syringe') }}</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'type'])
                            </div>

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
