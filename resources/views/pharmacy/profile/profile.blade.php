@extends('pharmacy.layouts.master', ['pageSlug' => 'pharmacy_profile'])
@section('title', 'My Profile')
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
            height: 500;
        }
    </style>
@endpush
@section('content')
    <div class="profile-section">
        <div class="row">
            <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Update Profile') }}</h5>
                    </div>
                    <form method="POST" action="{{ route('pharmacy.profile.update') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row flex-xl-row flex-column-reverse">
                                <div class="col-xl-7 col-xxl-8">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Pharmacy Name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter pharmacy name" value="{{ $pharmacy->name }}">
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Pharmacy/Responsible Person Phone') }}</label>
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="Enter Phone" value="{{ $pharmacy->phone }}">
                                            @include('alerts.feedback', ['field' => 'phone'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('PharmacyEmail') }}</label>
                                            <input type="text" name="email" class="form-control"
                                                placeholder="Enter Email" value="{{ $pharmacy->email }}">
                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Emergency Phone') }}</label>
                                            <input type="text" name="emergency_phone" class="form-control"
                                                placeholder="Enter emergency Phone"
                                                value="{{ $pharmacy->emergency_phone }}">
                                            @include('alerts.feedback', ['field' => 'emergency_phone'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Identification Type') }}</label>
                                            <select name="identification_type" id="identification_type"
                                                class="form-control">
                                                <option selected hidden value=" ">
                                                    {{ __('Select Identification Type') }}
                                                </option>
                                                <option value="TIN"
                                                    {{ $pharmacy->identification_type == 'TIN' ? 'selected' : '' }}>
                                                    {{ __('TIN Certificate') }}</option>
                                                <option value="Trade"
                                                    {{ $pharmacy->identification_type == 'Trade' ? 'selected' : '' }}>
                                                    {{ __('Trade License') }}</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'identification_type'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-xxl-4">
                                    <form class="updateForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="profile_image">
                                            <div class="img mx-auto mt-4 rounded-circle">
                                                <img class="avatar mb-0 rounded-circle w-100 h-100" id="previewImage"
                                                    src="{{ $pharmacy->image ? storage_url($pharmacy->image) : asset('no_img/no_img.jpg') }}"
                                                    alt="">
                                                <label for="imageInput" class="camera-icon text-center rounded-circle">
                                                    <i class="fa-solid fa-camera-retro" style="cursor: pointer;"></i>
                                                    <input type="file" id="imageInput" name="image" accept="image/*"
                                                        class="d-none">
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{ __('Identification NO') }}</label>
                                    <input type="text" name="identification_no" id="identification_no"
                                        value="{{ $pharmacy->identification_no ? $pharmacy->identification_no : old('identification_no') }}"
                                        class="form-control" placeholder="Enter identification number">
                                    @include('alerts.feedback', ['field' => 'identification_no'])
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('Operation Area') }}</label>
                                    @if (empty($pharmacy->oa_id))
                                        <select name="oa_id" class="form-control operation_area">
                                            <option selected hidden value=" ">{{ __('Select Operation Area') }}
                                            </option>
                                            @foreach ($operation_areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'oa_id'])
                                    @else
                                        <input type="text" value="{{ $pharmacy->operation_area->name }}"
                                            class="form-control" disabled>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label>{{ __('Operation Sub Area') }}</label>
                                    @if (empty($pharmacy->osa_id))
                                        <select name="osa_id" class="form-control operation_sub_area" disabled>
                                            <option selected hidden value=" ">{{ __('Select Operation Sub Area') }}
                                            </option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'osa_id'])
                                    @else
                                        <input type="text" value="{{ $pharmacy->operation_sub_area->name }}"
                                            class="form-control" disabled>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ __('Present Address') }}</label>
                                    <textarea name="present_address" class="form-control" placeholder="Enter present address">{{ $pharmacy->present_address ? $pharmacy->present_address : old('present_address') }}</textarea>
                                    @include('alerts.feedback', ['field' => 'present_address'])
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ __('Permanent Address') }}</label>
                                    <textarea name="permanent_address" class="form-control" placeholder="Enter permanent address">{{ $pharmacy->permanent_address ? $pharmacy->permanent_address : old('permanent_address') }}</textarea>
                                    @include('alerts.feedback', ['field' => 'permanent_address'])
                                </div>
                                <div class="col-md-12">
                                    <button type="submit"
                                        class="btn btn-sm btn-primary float-end">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('My Location') }}</h5>
            </div>
            <form method="POST" action="{{ route('pharmacy.profile.address') }}" autocomplete="off">
                @csrf
                <div class="card-body map-card">
                    <div class="map" id="map" data-lat="{{ optional($pharmacy->address)->latitude }}"
                        data-lng="{{ optional($pharmacy->address)->longitude }}"></div>

                    <input type="hidden" name="lat" value="{{ optional($pharmacy->address)->latitude }}">
                    <input type="hidden" name="long" value="{{ optional($pharmacy->address)->longitude }}">
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="address">Full Address <small class="text-danger">*</small></label>
                            <input type="text" class="form-control mt-1" id="address" name="address"
                                value="{{ optional($pharmacy->address)->address }}"
                                placeholder="Enter your full address">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">City <small class="text-danger">*</small></label>
                            <input type="text" class="form-control mt-1" id="city" name="city"
                                value="{{ optional($pharmacy->address)->city }}" placeholder="Enter your city name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="street">Street Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control mt-1" id="street" name="street"
                                value="{{ optional($pharmacy->address)->street_address }}"
                                placeholder="Enter your street name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apartment">Apartment Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control mt-1" id="apartment" name="apartment"
                                value="{{ optional($pharmacy->address)->apartment }}"
                                placeholder="Enter your apartment name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="floor">Floor <small class="text-danger">*</small></label>
                            <input type="text" class="form-control mt-1" id="floor" name="floor"
                                value="{{ optional($pharmacy->address)->floor }}"
                                placeholder="Enter your apartment floor">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="instruction">Delivery Man Instruction <small>(optional)</small></label>
                            <textarea type="text" class="form-control mt-1" id="instruction" name="instruction">{{ optional($pharmacy->address)->delivery_instruction }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer float-end">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="POST" action="{{ route('pharmacy.profile.update.password') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Current Password">
                        @include('alerts.feedback', ['field' => 'old_password'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="New Password">
                        @include('alerts.feedback', ['field' => 'password'])

                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm New Password">
                    </div>
                </div>
                <div class="card-footer float-end">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Change password') }}</button>
                </div>
            </form>
        </div>
    </div>
    @include('district_manager.partials.documentation', ['document' => $document])
    </div>
@endsection

@push('js_link')
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1-dev/mapbox-gl-geocoder.min.js">
    </script>

    <script src="{{ asset('pharmacy/js/mapbox.js') }}"></script>
@endpush
@push('js')
    <script>
        function handleErrors(response) {
            var errors = response.errors;
            for (var field in errors) {
                toastr.error(errors[field][0]);
            }
        }
        $(document).ready(function() {
            var form = $('#updateForm');
            $('#imageInput').change(function() {
                var preview = $('#previewImage')[0];
                var fileInput = $(this)[0];
                var file = fileInput.files[0];

                var reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                    uploadImage();
                } else {
                    preview.src = "{{ asset('no_img/no_img.jpg') }}";
                }
            });
        });

        function uploadImage() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('image', $("#imageInput")[0].files[0]);
            console.log(formData);
            var _url = "{{ route('pharmacy.profile.update.image') }}";

            $.ajax({
                url: _url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function() {
                    $('.profile_image .img').addClass('div_animation overly');
                    $('.profile_image .img img.avatar').addClass('image_animation');
                    $('.profile_image .camera-icon').css('display', 'none');

                    setTimeout(function() {
                        // Continue with the AJAX request
                        $.ajax({
                            url: _url,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                if (!response.success) {
                                    $('.profile_image .img').removeClass(
                                        'div_animation overly');
                                    $('.profile_image .img img.avatar').removeClass(
                                        'image_animation');
                                    $('.profile_image .camera-icon').css('display',
                                        'block');
                                    $('#previewImage').attr('src',
                                        "{{ storage_url($pharmacy->image) }}");
                                    handleErrors(response);
                                }

                            },
                            complete: function(response) {
                                if (response.responseJSON.message) {
                                    console.log(response.responseJSON);
                                    $('.profile_image .img').removeClass(
                                        'div_animation overly');
                                    $('.profile_image .img img.avatar').removeClass(
                                        'image_animation');
                                    $('.profile_image .camera-icon').css('display',
                                        'block');
                                    $('#previewImage').attr('src', response.responseJSON
                                        .image);
                                    toastr.success(response.responseJSON.message);
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    $('.profile_image .img').removeClass(
                                        'div_animation overly');
                                    $('.profile_image .img img.avatar').removeClass(
                                        'image_animation');
                                    $('.profile_image .camera-icon').css('display',
                                        'block');
                                    $('#previewImage').attr('src',
                                        "{{ storage_url($pharmacy->image) }}");
                                    toastr.error('Something is wrong!');
                                } else {
                                    console.log('An error occurred.');
                                }
                                toastr.error(response.responseJSON.message);
                            }
                        });
                    }, 5000); // 5 seconds delay


                },
            });
        }




        $(document).ready(function() {
            $('.operation_area').on('change', function() {
                let operation_sub_area = $('.operation_sub_area');
                let oa_id = $(this).val();

                operation_sub_area.prop('disabled', true);

                let url = ("{{ route('pharmacy.profile.get_osa', ['oa_id']) }}");
                let _url = url.replace('oa_id', oa_id);

                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        operation_sub_area.prop('disabled', false);
                        var result = '';
                        data.operation_sub_areas.forEach(function(sub_area) {
                            result +=
                                `<option value="${sub_area.id}">${sub_area.name}</option>`;
                        });
                        operation_sub_area.html(result);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
