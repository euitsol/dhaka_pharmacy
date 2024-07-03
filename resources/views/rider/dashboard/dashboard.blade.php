@extends('rider.layouts.master', ['pageSlug' => 'rider_dashboard'])

@section('title', 'Dashboard')
@push('css')
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-2 ml-2 mb-2">
                            <div class="card-body">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <span class="">Order Pickup</span>
                                                <span class="ml-2">

                                                    <div uk-countdown="date: 2024-07-04">
                                                        <span class="uk-countdown-number uk-countdown-days"></span>
                                                        <span class="uk-countdown-number uk-countdown-hours"></span>
                                                        <span class="uk-countdown-number uk-countdown-minutes"></span>
                                                        <span class="uk-countdown-number uk-countdown-seconds"></span>
                                                    </div>

                                                </span>
                                            </button>
                                        </div>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="map" class="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="{{ asset('rider/js/direction.js') }}"></script>
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css"
        type="text/css">
@endpush
