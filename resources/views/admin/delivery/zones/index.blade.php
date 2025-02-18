@extends('admin.layouts.master', ['pageSlug' => 'delivery_zones'])

@section('title', 'Delivery Zones List')

@push('css_link')
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
@endpush

@push('css')
<style>
    #map {
        min-height: 40rem;
        border: 3px solid #139ad8;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Delivery Zones') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            @include('admin.delivery.zones.partials.zones')
                        </div>
                        <div class="col-md-5">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_link')
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            console.log(map_center);

            mapboxgl.accessToken = mapbox_token;
            const map = new mapboxgl.Map({
                container: 'map',
                style: mapbox_style_id,
                center: [90, 23],
                zoom: 5
            });

            map.on('load', function() {
                map.addSource('city-boundaries', {
                    type: 'vector',
                    url: 'mapbox://your-tileset-id-for-city-boundaries'
                });

                map.addLayer({
                    'id': 'city-outlines',
                    'type': 'line',
                    'source': 'city-boundaries',
                    'source-layer': 'your-source-layer-name',
                    'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                    },
                    'paint': {
                    'line-color': '#000000',
                    'line-width': 2
                    }
                });
            });
        });
    </script>
@endpush
