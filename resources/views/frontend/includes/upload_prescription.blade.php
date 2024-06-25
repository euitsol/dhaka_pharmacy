{{-- Prescription Upload Modal  --}}
@push('css_link')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.css"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('user/asset/css/address.css') }}">
@endpush
<div class="modal up_modal fade" style="z-index: 99999999999999;" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Order By Prescription') }}</h5>
                <button type="button" class="close  px-2 py-1 border-1 border-danger rounded-1 text-white bg-danger"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="up_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="prescription">{{ __('Prescription Image') }}<span
                                class="text-danger">*</span></label>
                        <input type="file" name="uploadfile" data-actualName="image" class="form-control filepond"
                            id="prescription" accept="image/*">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">{{ __('Delivery Address') }}<span class="text-danger">*</span></label>
                        @if (user())
                            @forelse (user()->address as $key => $address)
                                <div class="form-check ms-2">
                                    <input class="form-check-input user_address" value="{{ $address->id }}"
                                        style="width: 1em" type="radio" name="address_id"
                                        id="user_address{{ $key }}"
                                        @if ($address->is_default == true) checked @endif>
                                    <label class="form-check-label ms-2" for="user_address{{ $key }}">
                                        {{ str_limit($address->address, 70) }} (<span> {!! get_taka_icon() !!}
                                        </span>
                                        <span class="delivery_charge" data-delivery_charge=""></span>)
                                    </label>
                                </div>
                            @empty
                                <div class="address_add_btn">
                                    <a href="javascript:void(0)" class="btn btn-outline-success mt-2 address_btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#address_add_modal">{{ __('Add Address') }}</a>
                                </div>
                            @endforelse
                            <input type="hidden" name="delivery_fee" class="user_delivery_input"
                                value="{{ ceil($default_delivery_fee) }}">
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('Shipping') }}<span class="text-danger">*</span></label>
                        <select name="delivery_type" class="form-control" id="delivery_type">
                            <option value="">{{ __('Select Delivery Type') }} </option>
                            <option value="normal">{{ __('Normal-Delivery') }} </option>
                            <option value="standard">{{ __('Standard-Delivery') }} </option>
                        </select>
                    </div>
                    <div class="form-group text-end mt-3">
                        <a href="javascript:void(0)" class="btn btn-success up_submit_btn">{{ __('Submit') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('filepond.fileupload')
@include('user.address.add_address')
@push('js_link')
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>
@endpush
@push('js')
    <script src="{{ asset('user/asset/js/up.js') }}"></script>
    <script src="{{ asset('user/asset/js/mapbox.js') }}"></script>
    <script>
        file_upload(["#prescription"], "uploadfile", "user");
        const data = {
            'auth': `{{ Auth::guard('web')->check() }}`,
            'login_route': `{{ route('login') }}`,
            'upload_route': `{{ route('u.obp.up') }}`,
            'address_url': `{{ route('u.obp.address', ['param']) }}`,
        };
    </script>
@endpush
