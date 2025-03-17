@extends('admin.layouts.master', ['pageSlug' => 'hub'])
@section('title', 'Create Hub')
@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
@endpush

@push('css')
    <style>
        .map {
            width: 100%;
            height: 250px;
        }

        .ps {
            overflow: unset !important;
        }

        .ps--active-x>.ps__rail-x,
        .ps--active-y>.ps__rail-y {
            display: none !important;
        }
    </style>
@endpush
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Hub') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'hm.hub.hub_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('hm.hub.hub_create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Name') }}<small class="text-danger">*</small></label>
                                <input type="text" id="title" name="name"
                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="Enter name" value="{{ old('name') }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Slug') }}<small class="text-danger">*</small></label>
                                <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                    id="slug" value="{{ old('slug') }}" name="slug"
                                    placeholder="{{ __('Enter Slug (must be use - on white speace)') }}">
                                @include('alerts.feedback', ['field' => 'slug'])
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __('Description') }}<small class="text-danger">*</small></label>
                                <textarea id="description" name="description"
                                    class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Enter description">{{ old('description') }}</textarea>
                                @include('alerts.feedback', ['field' => 'description'])
                            </div>
                        </div>

                        {{-- Hub Address Form --}}
                        <div class="card mt-3 mb-0">
                            <div class="card-header">
                                <h5 class="title">{{ __('Hub Location') }}</h5>
                            </div>
                            <div class="card-body map-card">
                                <div class="map" id="map" data-lat="{{ old('lat') }}"
                                    data-lng="{{ old('long') }}"></div>

                                <input type="hidden" name="lat" value="{{ old('lat') }}">
                                <input type="hidden" name="long" value="{{ old('long') }}">
                                <div class="row mt-3">
                                    <div class="form-group col-md-12">
                                        <label for="address">{{ __('Full Address ') }}<small
                                                class="text-danger">*</small></label>
                                        <input type="text" class="form-control mt-1" id="address" name="address"
                                            value="{{ old('address') }}" placeholder="Enter your full address">
                                        @include('alerts.feedback', ['field' => 'address'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="city">{{ __('City ') }}<small
                                                class="text-danger">*</small></label>
                                        <input type="text" class="form-control mt-1" id="city" name="city"
                                            value="{{ old('city') }}" placeholder="Enter your city name">
                                        @include('alerts.feedback', ['field' => 'city'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="street">{{ __('Street Name ') }}<small
                                                class="text-danger">*</small></label>
                                        <input type="text" class="form-control mt-1" id="street" name="street"
                                            value="{{ old('street') }}" placeholder="Enter your street name">
                                        @include('alerts.feedback', ['field' => 'street'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="apartment">{{ __('Apartment Name ') }}<small
                                                class="text-danger">*</small></label>
                                        <input type="text" class="form-control mt-1" id="apartment" name="apartment"
                                            value="{{ old('apartment') }}" placeholder="Enter your apartment name">
                                        @include('alerts.feedback', ['field' => 'apartment'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="floor">{{ __('Floor ') }}<small
                                                class="text-danger">*</small></label>
                                        <input type="text" class="form-control mt-1" id="floor" name="floor"
                                            value="{{ old('floor') }}" placeholder="Enter your apartment floor">
                                        @include('alerts.feedback', ['field' => 'floor'])
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label
                                            for="instruction">{{ __('Delivery Man Instruction ') }}<small>{{ __('(optional)') }}</small></label>
                                        <textarea type="text" class="form-control mt-1" id="instruction" name="instruction">{{ old('instruction') }}</textarea>
                                    </div>
                                </div>
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
@push('js_link')
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>

    <script src="{{ asset('pharmacy/js/mapbox.js') }}"></script>
@endpush
