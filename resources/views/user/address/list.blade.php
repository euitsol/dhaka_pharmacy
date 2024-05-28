@extends('user.layouts.master', ['pageSlug' => 'address'])

@section('title', 'Address')

@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
@endpush

@section('content')
    <div class="container address">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between mt-1 mb-3">
                    <div>
                        <h4>{{ __('My Address') }}</h4>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                            data-target="#address_add_modal">Add
                            Address</a>
                    </div>
                </div>

                <div class="card">
                    <div class="accordion" id="accordion">
                        @forelse ($address as $key => $address)
                            <div class="accordion-item">
                                <h2 class="accordion-header d-flex align-items-center justify-content-center"
                                    id="heading{{ $key }}">
                                    <button
                                        class="accordion-button @if ($key == 0) @else collapsed @endif"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $key }}"
                                        @if ($key == 0) aria-expanded="true" @else  aria-expanded="false" @endif
                                        aria-controls="collapse{{ $key }}">
                                        {{ $address->address }} <span
                                            class="ml-2 badge {{ $address->getFeaturedBadgeClass() }}">{{ $address->getFeaturedStatus() }}</span>
                                    </button>
                                    <div class="action-btns d-flex align-items-center justify-content-between ">
                                        <a href="javascript:void(0)" data-id="{{ $address->id }}" class="edit-btn"><i
                                                class="fa-solid fa-pen-to-square text-info"></i></a>
                                        <a href="{{ route('u.as.delete', $address->id) }}" class="dlt-btn"
                                            onclick="alert('Are you sure?')"><i
                                                class="fa-solid fa-trash-can text-danger "></i></a>
                                    </div>

                                </h2>
                                <div id="collapse{{ $key }}" data-count="{{ $key }}"
                                    class="accordion-collapse collapse @if ($key == 0) show @endif "
                                    aria-labelledby="heading{{ $key }}" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="strong">City: </span>{{ $address->city }}
                                            </div>
                                            <div class="col-md-3">
                                                <span class="strong">Street: </span>{{ $address->address }}
                                            </div>
                                            <div class="col-md-3">
                                                <span class="strong">Appartment: </span>{{ $address->apartment }}
                                            </div>
                                            <div class="col-md-3">
                                                <span class="strong">Floor: </span>{{ $address->floor }}
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <span class="strong">Instruction: </span> {!! $address->delivery_instruction !!}
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                @if (!empty($address->latitude) && !empty($address->longitude))
                                                    <div class="my-map" id="map{{ $key }}"
                                                        data-lat={{ $address->latitude }}
                                                        data-lng={{ $address->longitude }}></div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="d-flex align-items-center justify-content-center">
                                <h6 class="text-warning mt-2 mb-2">No address found</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.address.add_address')
    @include('user.address.edit_address')
@endsection

@push('js_link')
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
@endpush

@push('js')
    <script>
        const data = {
            'details_url': `{{ route('u.as.details', 'param') }}`,
        };
    </script>
    <script src="{{ asset('user/asset/js/mapbox.js') }}"></script>
@endpush
