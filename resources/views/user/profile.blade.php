@extends('user.layouts.master', ['pageSlug' => 'profile'])
@section('title', 'Manage My Account')
@section('content')

    <div class="profile-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-title">
                        <h3>{{ __('Update Profile') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('u.profile.update') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row flex-xl-row flex-column-reverse">
                                    <div class="col-xl-7 col-xxl-8">
                                        <div class="row">
                                            <div class="form-group mb-4 col-md-6">
                                                <label class="text-muted">{{ __('Name') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter Name" value="{{ $user->name ?? old('name') }}">
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>
                                            <div class="form-group mb-4 col-md-6">
                                                <label class="text-muted">{{ __('Occupation') }}</label>
                                                <input type="text" name="occupation" class="form-control"
                                                    placeholder="Enter Occupation"
                                                    value="{{ $user->occupation ?? old('occupation') }}">
                                                @include('alerts.feedback', ['field' => 'occupation'])
                                            </div>
                                            <div class="form-group mb-4 col-md-6">
                                                <label class="text-muted">{{ __('Father Name') }}</label>
                                                <input type="text" name="father_name" class="form-control"
                                                    placeholder="Enter Father Name"
                                                    value="{{ $user->father_name ?? old('father_name') }}">
                                                @include('alerts.feedback', ['field' => 'father_name'])
                                            </div>
                                            <div class="form-group mb-4 col-md-6">
                                                <label class="text-muted">{{ __('Mother Name') }}</label>
                                                <input type="text" name="mother_name" class="form-control"
                                                    placeholder="Enter Mother Name"
                                                    value="{{ $user->mother_name ?? old('mother_name') }}">
                                                @include('alerts.feedback', ['field' => 'mother_name'])
                                            </div>

                                            <div class="form-group mb-4 col-md-6">
                                                <label class="text-muted">{{ __('Phone') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" value="{{ $user->phone }}" class="form-control"
                                                    placeholder="Enter Phone" disabled>
                                            </div>
                                            <div class="form-group mb-4 col-md-6">
                                                <label class="text-muted">{{ __('Emergency Contact') }}</label>
                                                <input type="text" name="emergency_phone" class="form-control"
                                                    placeholder="Enter Emergency Contact Number"
                                                    value="{{ $user->emergency_phone ?? old('emergency_phone') }}">
                                                @include('alerts.feedback', ['field' => 'emergency_phone'])
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-xxl-4">
                                        <form class="updateForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="profile_image">
                                                <div class="img mx-auto mt-4 rounded-circle">
                                                    <img class="avatar mb-0 rounded-circle w-100 h-100" id="previewImage"
                                                        src="{{ auth_storage_url($user->image, $user->gender) }}"
                                                        alt="">
                                                    <label for="imageInput" class="camera-icon text-center rounded-circle">
                                                        <i class="fa-solid fa-camera-retro" style="cursor: pointer;"></i>
                                                        <input type="file" id="imageInput" name="image"
                                                            accept="image/*" class="d-none">
                                                    </label>
                                                    @include('alerts.feedback', ['field' => 'image'])
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-4 col-md-4">
                                        <label class="text-muted">{{ __('Email') }}</label>
                                        <input type="text" name="email" class="form-control"
                                            placeholder="Enter Emergency Contact Number"
                                            value="{{ $user->email ?? old('email') }}">
                                        @include('alerts.feedback', ['field' => 'email'])
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label class="text-muted">{{ __('Gender') }}</label>
                                        <select name="gender" class="form-control">
                                            <option value=" " selected hidden>{{ __('Select Gender') }}
                                            </option>
                                            <option value="1"
                                                {{ $user->gender == '1' || old('gender') == '1' ? 'selected' : '' }}>
                                                {{ __('Male') }}</option>
                                            <option value="2"
                                                {{ $user->gender == '2' || old('gender') == '2' ? 'selected' : '' }}>
                                                {{ __('Female') }}</option>
                                            <option value="3"
                                                {{ $user->gender == '3' || old('gender') == '3' ? 'selected' : '' }}>
                                                {{ __('Other') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'gender'])
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label class="text-muted">{{ __('Date of Birth') }}</label>
                                        <input type="date" name="dob" value="{{ $user->dob ?? old('dob') }}"
                                            class="form-control">
                                        @include('alerts.feedback', ['field' => 'dob'])
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label class="text-muted">{{ __('Age') }}</label>
                                        <input type="text" name="age" value="{{ $user->age ?? old('age') }}"
                                            class="form-control" placeholder="Enter age">
                                        @include('alerts.feedback', ['field' => 'age'])
                                    </div>


                                    <div class="form-group mb-4 col-md-4">
                                        <label class="text-muted">{{ __('Identification Type') }}</label>
                                        <select name="identification_type" id="identification_type" class="form-control">
                                            <option selected hidden value=" ">{{ __('Select Identification Type') }}
                                            </option>
                                            <option value="1"
                                                {{ $user->identification_type == '1' || old('identification_type') == '1' ? 'selected' : '' }}>
                                                {{ __('National ID Card') }}</option>
                                            <option value="2"
                                                {{ $user->identification_type == '2' || old('identification_type') == '2' ? 'selected' : '' }}>
                                                {{ __('Birth Certificate No') }}</option>
                                            <option value="3"
                                                {{ $user->identification_type == '3' || old('identification_type') == '3' ? 'selected' : '' }}>
                                                {{ __('Passport NO') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'identification_type'])
                                    </div>


                                    <div class="form-group mb-4 col-md-4">
                                        <label class="text-muted">{{ __('Identification NO') }}</label>
                                        <input type="text" name="identification_no" id="identification_no"
                                            value="{{ $user->identification_no ?? old('identification_no') }}"
                                            class="form-control" placeholder="Enter identification number">
                                        @include('alerts.feedback', ['field' => 'identification_no'])
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label class="text-muted">{{ __('Identification File') }}</label>
                                            <input type="file" accept=".pdf" class="form-control"
                                                name="identification_file">
                                            @include('alerts.feedback', [
                                                'field' => 'identification_file',
                                            ])
                                        </div>
                                        @if (!empty($user->identification_file))
                                            <a class="btn btn-primary" target="_blank"
                                                href="{{ route('u.profile.file.download', base64_encode($user->identification_file)) }}"><i
                                                    class="fa-solid fa-download"></i></a>
                                        @endif
                                    </div>


                                    <div class="form-group mb-4 col-md-12">
                                        <label class="text-muted">{{ __('Bio') }}</label>
                                        <textarea name="bio" class="form-control" placeholder="Enter bio">{{ $user->bio ?? old('bio') }}</textarea>
                                        @include('alerts.feedback', ['field' => 'bio'])
                                    </div>
                                    <div class="form-group mb-4 col-md-12">
                                        <label class="text-muted">{{ __('Present Address') }}</label>
                                        <textarea name="present_address" class="form-control" placeholder="Enter present address">{{ $user->present_address ?? old('present_address') }}</textarea>
                                        @include('alerts.feedback', ['field' => 'present_address'])
                                    </div>
                                    <div class="form-group mb-4 col-md-12">
                                        <label class="text-muted">{{ __('Permanent Address') }}</label>
                                        <textarea name="permanent_address" class="form-control" placeholder="Enter permanent address">{{ $user->permanent_address ?? old('permanent_address') }}</textarea>
                                        @include('alerts.feedback', ['field' => 'permanent_address'])
                                    </div>
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="submit_btn">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="p-title">
                        <h3>{{ __('Update Password') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('u.profile.update.password') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <label class="text-muted">{{ __('Current Password') }}</label>
                                    <input type="password" name="old_password" class="form-control"
                                        placeholder="Current Password">
                                    @include('alerts.feedback', ['field' => 'old_password'])
                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-muted">{{ __('New Password') }}</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="New Password">
                                    @include('alerts.feedback', ['field' => 'password'])

                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-muted">{{ __('Confirm New Password') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm New Password">
                                </div>
                                <div class="form-group text-end">
                                    <button type="submit" class="submit_btn">{{ __('Change password') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                    preview.src = "{{ asset('no_img/anime3.png') }}";
                }
            });
        });

        function uploadImage() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('image', $("#imageInput")[0].files[0]);
            var _url = "{{ route('u.profile.update.img') }}";

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
                                        "{{ storage_url($user->image) }}");
                                    handleErrors(response);
                                }

                            },
                            complete: function(response) {
                                if (response.responseJSON.message) {
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
                                        "{{ storage_url($user->image) }}");
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
