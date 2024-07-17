@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
@endpush

@push('css')
    <style>
        .my_map {

            height: 500px;
        }
    </style>
@endpush
<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Mapbox Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('mbx_settings.update.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Mapbox Access Token') }}</label>
                        <input type="text" name="mapbox_token" style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                            class="form-control{{ $errors->has('mapbox_token') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('ENTER MAPBOX ACCESS TOKEN') }}"
                            value="{{ $mapbox_settings['mapbox_token'] ?? old('mapbox_token') }}">
                        @include('alerts.feedback', ['field' => 'mapbox_token'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Mapbox Style ID') }}</label>
                        <input type="text" name="mapbox_style_id"
                            style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                            class="form-control{{ $errors->has('mapbox_style_id') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('ENTER MAPBOX STYLE ID') }}"
                            value="{{ $mapbox_settings['mapbox_style_id'] ?? old('mapbox_style_id') }}">
                        @include('alerts.feedback', ['field' => 'mapbox_style_id'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Per Km Delivery Charge') }}</label>
                        <input type="text" name="per_km_delivery_charge"
                            style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                            class="form-control{{ $errors->has('per_km_delivery_charge') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('ENTER PER KM DELIVERY CHARGE') }}"
                            value="{{ $mapbox_settings['per_km_delivery_charge'] ?? old('per_km_delivery_charge') }}">
                        @include('alerts.feedback', ['field' => 'per_km_delivery_charge'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Min Delivery Charge') }}</label>
                        <input type="text" name="min_delivery_charge"
                            style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                            class="form-control{{ $errors->has('min_delivery_charge') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('ENTER MIN DELIVERY CHARGE') }}"
                            value="{{ $mapbox_settings['min_delivery_charge'] ?? old('min_delivery_charge') }}">
                        @include('alerts.feedback', ['field' => 'min_delivery_charge'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Miscellaneous Charge') }}</label>
                        <input type="text" name="miscellaneous_charge"
                            style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                            class="form-control{{ $errors->has('miscellaneous_charge') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('ENTER MISCELLANEOUS CHARGE') }}"
                            value="{{ $mapbox_settings['miscellaneous_charge'] ?? old('miscellaneous_charge') }}">
                        @include('alerts.feedback', ['field' => 'miscellaneous_charge'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Pharmacy Radious') }}</label>
                        <input type="text" name="pharmacy_radious"
                            style="border-right: 2px solid rgba(29, 37, 59, 0.5)"
                            class="form-control{{ $errors->has('pharmacy_radious') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('ENTER PHARMACY RADIOUS') }}"
                            value="{{ $mapbox_settings['pharmacy_radious'] ?? old('pharmacy_radious') }}">
                        @include('alerts.feedback', ['field' => 'pharmacy_radious'])
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="center_location_lng" id="center_location_lng"
                            value="{{ $mapbox_settings['center_location_lng'] ?? old('center_location_lng') }}">
                        <input type="hidden" name="center_location_lat" id="center_location_lat"
                            value="{{ $mapbox_settings['center_location_lat'] ?? old('center_location_lat') }}">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body map_wrap">
                <div class="my_map" id="my_map"></div>
            </div>
        </div>
    </div>
    @include('admin.partials.documentation', ['document' => $document])
</div>
@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
@endpush
@push('js')
    <script src="{{ asset('admin/js/mapbox_settings.js') }}"></script>
@endpush
