{{-- @extends('admin.layouts.master', ['pageSlug' => 'admin'])
@section('title', 'Admin Profile')
@section('content')
    <div class="row profile">
        <div class="col-md-8">
            <div class="card h-100 mb-0">
                <div class="card-header px-4">
                    <nav>
                        <div class="nav nav-tabs row" id="nav-tab" role="tablist">
                            <button class="nav-link active col" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details"
                                aria-selected="true">{{ __('Details') }}</button>
                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            @include('admin.admin_management.admin.includes.details')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user mb-0">
                <div class="card-body">
                    <p class="card-text">
                    <div class="author">
                        <img class="avatar" src="{{ auth_storage_url($admin->image, $admin->gender) }}" alt="">
                        <h5 class="title mb-0">{{ $admin->name }}</h5>
                        <p class="description">
                            {{ __($admin->designation ?? 'Admin') }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description bio my-2 text-justify">
                        {!! $admin->bio !!}
                    </div>
                    <div class="contact_info py-3">
                        <ul class="m-0 px-3 list-unstyled">
                            <li>
                                <i class="fa-solid fa-phone-volume mr-2"></i>
                                <span class="title">{{ __('Mobile : ') }}</span>
                                <span class="content">{{ $admin->phone ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-regular fa-envelope mr-2"></i>
                                <span class="title">{{ __('Email : ') }}</span>
                                <span class="content">{{ $admin->email ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                <span class="title">{{ __('Address : ') }}</span>
                                <span class="content">{!! $admin->present_address ?? '--' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('admin.layouts.master', ['pageSlug' => 'admin'])
@section('title', 'My Profile')
@section('content')
    <div class="profile-section">
        <div class="row">
            <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Update Profile') }}</h5>
                    </div>
                    <form method="POST" action="{{ route('am.admin.update.admin_profile') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row flex-xl-row flex-column-reverse">
                                <div class="col-xl-7 col-xxl-8">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Name') }}<span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter name" value="{{ $admin->name }}">
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Designation') }}</label>
                                            <input type="text" name="designation" class="form-control"
                                                placeholder="Enter designation" value="{{ $admin->designation }}">
                                            @include('alerts.feedback', ['field' => 'designation'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Father Name') }}</label>
                                            <input type="text" name="father_name" class="form-control"
                                                placeholder="Enter emergency Phone"
                                                value="{{ $admin->father_name ?? old('father_name') }}">
                                            @include('alerts.feedback', ['field' => 'father_name'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Mother Name') }}</label>
                                            <input type="text" name="mother_name" class="form-control"
                                                placeholder="Enter emergency Phone"
                                                value="{{ $admin->mother_name ?? old('mother_name') }}">
                                            @include('alerts.feedback', ['field' => 'mother_name'])
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Email') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Email"
                                                value="{{ $admin->email }}" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Role') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter role"
                                                value="{{ $admin->role->name }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-xxl-4">
                                    <form class="updateForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="profile_image">
                                            <div class="img mx-auto mt-4 rounded-circle">
                                                <img class="avatar mb-0 rounded-circle w-100 h-100" id="previewImage"
                                                    src="{{ $admin->image ? storage_url($admin->image) : asset('no_img/no_img.jpg') }}"
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
                                    <label>{{ __('Phone') }}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone"
                                        value="{{ $admin->phone }}">
                                    @include('alerts.feedback', ['field' => 'phone'])
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('Emergency Phone') }}</label>
                                    <input type="text" name="emergency_phone" class="form-control"
                                        placeholder="Enter emergency Phone"
                                        value="{{ $admin->emergency_phone ?? old('emergency_phone') }}">
                                    @include('alerts.feedback', ['field' => 'emergency_phone'])
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('Gender') }}</label>
                                    <select name="gender" class="form-control">
                                        <option value=" " selected hidden>{{ __('Select Gender') }}</option>
                                        <option value="1"
                                            {{ $admin->gender == 1 || old('gender') == 1 ? ' selected' : '' }}>
                                            {{ __('Male') }}</option>
                                        <option value="2"
                                            {{ $admin->gender == 2 || old('gender') == 2 ? ' selected' : '' }}>
                                            {{ __('Female') }}</option>
                                        <option value="3"
                                            {{ $admin->gender == 3 || old('gender') == 3 ? ' selected' : '' }}>
                                            {{ __('Other') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('Identification Type') }}</label>
                                    <select name="identification_type" id="identification_type" class="form-control">
                                        <option selected hidden value=" ">
                                            {{ __('Select Identification Type') }}
                                        </option>
                                        <option value="1"
                                            {{ ($admin->identification_type || old('identification_type')) == 1 ? 'selected' : '' }}>
                                            {{ __('National ID Card') }}</option>
                                        <option value="2"
                                            {{ ($admin->identification_type || old('identification_type')) == 2 ? 'selected' : '' }}>
                                            {{ __('Birth Certificate No') }}</option>
                                        <option value="2"
                                            {{ ($admin->identification_type || old('identification_type')) == 2 ? 'selected' : '' }}>
                                            {{ __('Passport No') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'identification_type'])
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('Identification No') }}</label>
                                    <input type="text" class="form-control" name="identification_no"
                                        value="{{ $admin->identification_no }}">
                                    @include('alerts.feedback', ['field' => 'identification_no'])
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{ __('Date of Birth') }}</label>
                                    <input type="date" class="form-control" name="date_of_birth"
                                        value="{{ $admin->date_of_birth }}">
                                    @include('alerts.feedback', ['field' => 'date_of_birth'])
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ __('Bio') }}</label>
                                    <textarea name="bio" class="form-control" placeholder="Enter your bio">{{ $admin->bio }}</textarea>
                                    @include('alerts.feedback', ['field' => 'bio'])
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ __('Present Address') }}</label>
                                    <textarea name="present_address" class="form-control" placeholder="Enter present address">{{ $admin->present_address }}</textarea>
                                    @include('alerts.feedback', ['field' => 'present_address'])
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ __('Permanent Address') }}</label>
                                    <textarea name="permanent_address" class="form-control" placeholder="Enter permanent address">{{ $admin->permanent_address }}</textarea>
                                    @include('alerts.feedback', ['field' => 'permanent_address'])
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Identification Document') }}</label>
                                        <input type="file" accept=".pdf" class="form-control"
                                            name="identification_file">
                                        @include('alerts.feedback', ['field' => 'identification_file'])
                                    </div>
                                    @if (!empty($admin->identification_file))
                                        <a class="btn btn-primary" target="_blank"
                                            href="{{ route('am.admin.download.admin_profile', base64_encode($admin->identification_file)) }}"><i
                                                class="fa-solid fa-download"></i></a>
                                    @endif
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
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="POST" action="{{ route('am.admin.pupdate.admin_profile') }}" autocomplete="off"
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
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Change Password') }}</button>
                </div>
            </form>
        </div>
    </div>
    @include('district_manager.partials.documentation', ['document' => $document])
    </div>
@endsection
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
            var _url = "{{ route('am.admin.imgupdate.admin_profile') }}";

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
                                        "{{ storage_url($admin->image) }}");
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
                                        "{{ storage_url($admin->image) }}");
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
    </script>
@endpush
