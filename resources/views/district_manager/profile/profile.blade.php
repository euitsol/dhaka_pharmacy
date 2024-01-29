@extends('district_manager.layouts.master', ['pageSlug' => 'district_manager_profile'])

@push('css')
    <style>
        .profile_image .camera-icon {
            position: absolute;
            bottom: -10%;
            font-size: 15px;
            height: 35px;
            width: 35px;
            line-height: 35px;
            left: 50%;
            text-align: center;
            right: 50%;
            transform: translateX(-50%);
            background: #fff;
            color: #E87BD7;
            border-radius: 50%;
            border: 1px solid #E87BD7;
        }

        .profile_image .img , .profile_image .overly {
            height: 215px;
            width: 215px;
            border: 5px solid #2b3553;
            border-bottom-color: transparent;
            position: relative;
            border-radius: 50%;
           
        }
        .profile_image .overly::before{
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            background: #000;
            display: block;
            height: 100%;
            width: 100%;
            border-radius: 50%;
            opacity: .5;
            transition: .4s;
            z-index: 99;
           
        }
        .div_animation{
             animation: round 5s linear infinite;
        }

        .profile_image .img img.avatar {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 50%;
            
        }
        .image_animation{
            animation: rounds 5s linear infinite reverse;
        }

        @keyframes round {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rounds {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        button.btn.btn-icon.btn-round {
            color: #fff;
        }

        @media only screen and (max-width: 1199px) {
            
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Update Profile') }}</h5>
                </div>
                <form method="POST" action="{{ route('dm.profile.update') }}" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method('PUT');
                    <div class="card-body">
                        <div class="row flex-xl-row flex-column-reverse">
                            <div class="col-xl-7 col-xxl-8">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                            value="{{ dm()->name }}">
                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Father Name') }}</label>
                                        <input type="text" name="father_name" class="form-control"
                                            placeholder="Enter Father Name" value="{{ dm()->father_name }}">
                                        @include('alerts.feedback', ['field' => 'father_name'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Nother Name') }}</label>
                                        <input type="text" name="mother_name" class="form-control"
                                            placeholder="Enter Mother Name" value="{{ dm()->mother_name }}">
                                        @include('alerts.feedback', ['field' => 'mother_name'])
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>{{ __('Phone') }}</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone"
                                            value="{{ dm()->phone }}">
                                        @include('alerts.feedback', ['field' => 'phone'])
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Parents Phone') }}</label>
                                        <input type="text" name="parents_phone" class="form-control"
                                            placeholder="Enter Parents Phone" value="{{ dm()->parents_phone }}">
                                        @include('alerts.feedback', ['field' => 'parents_phone'])
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-xxl-4">
                                <form class="updateForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="profile_image">
                                        <div class="img mx-auto mt-4">
                                            <img class="avatar mb-0" id="previewImage"
                                                src="{{ dm()->image ? storage_url(dm()->image) : 'https://white-dashboard-laravel.creative-tim.com/white/img/emilyz.jpg' }}"
                                                alt="">
                                            <label for="imageInput" class="camera-icon">
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
                                <label>{{ __('Area') }}</label>
                                <select name="area" class="form-control">
                                    <option selected hidden>{{ __('Select Area') }}</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'area'])
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Gender') }}</label>
                                <select name="gender" class="form-control">
                                    <option selected hidden>{{ __('Select Genger') }}</option>
                                    <option value="Male" {{ dm()->gender == 'Male' ? 'selected' : '' }}>
                                        {{ __('Male') }}</option>
                                    <option value="Female" {{ dm()->gender == 'Female' ? 'selected' : '' }}>
                                        {{ __('Female') }}</option>
                                    <option value="Others" {{ dm()->gender == 'Others' ? 'selected' : '' }}>
                                        {{ __('Others') }}</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'gender'])
                            </div>


                            <div class="form-group col-md-4">
                                <label>{{ __('Age') }}</label>
                                <input type="text" name="age" value="{{ dm()->age ? dm()->age : old('age') }}"
                                    class="form-control" placeholder="Enter age">
                                @include('alerts.feedback', ['field' => 'age'])
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{ __('Date of Birth') }}</label>
                                <input type="date" name="dob" value="{{ dm()->dob ? dm()->dob : old('dob') }}"
                                    class="form-control">
                                @include('alerts.feedback', ['field' => 'dob'])
                            </div>


                            <div class="form-group col-md-4">
                                <label>{{ __('Identification Type') }}</label>
                                <select name="identification_type" id="identification_type" class="form-control">
                                    <option selected hidden>{{ __('Select Identification Type') }}</option>
                                    <option value="NID" {{ dm()->identification_type == 'NID' ? 'selected' : '' }}>
                                        {{ __('National ID Card') }}</option>
                                    <option value="DOB" {{ dm()->identification_type == 'DOB' ? 'selected' : '' }}>
                                        {{ __('Date of Birth') }}</option>
                                    <option value="Passport"
                                        {{ dm()->identification_type == 'Passport' ? 'selected' : '' }}>
                                        {{ __('Passport NO') }}</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'identification_type'])
                            </div>


                            <div class="form-group col-md-4">
                                <label>{{ __('Identification NO') }}</label>
                                <input type="text" name="identification_no" id="identification_no"
                                    value="{{ dm()->identification_no ? dm()->identification_no : old('identification_no') }}"
                                    class="form-control" placeholder="Enter identification number">
                                @include('alerts.feedback', ['field' => 'identification_no'])
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Upload CV') }}</label>
                                    <input type="file" accept=".pdf" class="form-control" name="cv">
                                    @include('alerts.feedback', ['field' => 'cv'])
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <label>{{ __('Present Address') }}</label>
                                <textarea name="present_address" class="form-control" placeholder="Enter present address">{{ dm()->present_address ? dm()->present_address : old('present_address') }}</textarea>
                                @include('alerts.feedback', ['field' => 'present_address'])
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __('Permanent Address') }}</label>
                                <textarea name="permanent_address" class="form-control" placeholder="Enter permanent address">{{ dm()->permanent_address ? dm()->permanent_address : old('permanent_address') }}</textarea>
                                @include('alerts.feedback', ['field' => 'permanent_address'])
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                            </div>
                </form>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="title">{{ __('Password') }}</h5>
        </div>
        <form method="POST" action="{{ route('dm.profile.update.password') }}" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            @method('PUT');
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
            <div class="card-footer">
                <button type="submit" class="btn btn-fill btn-primary">{{ __('Change password') }}</button>
            </div>
        </form>
    </div>
    </div>
    @include('district_manager.partials.documentation', ['document' => $document])

    </div>
@endsection
@push('js')
    <script>
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
                    preview.src = "https://white-dashboard-laravel.creative-tim.com/white/img/emilyz.jpg";
                }
            });
        });

        function uploadImage() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('image', $("#imageInput")[0].files[0]);
            console.log(formData);
            var _url = "{{ route('dm.profile.update.image') }}";

            $.ajax({
                url: _url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend:function() {
                            $('.profile_image .img').addClass('div_animation overly');
                            $('.profile_image .img img.avatar').addClass('image_animation');
                            $('.profile_image .camera-icon').css('display','none');

                            setTimeout(function () {
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
                                    success: function (response) {
                                        console.log('Image uploaded successfully');
                                    },
                                    complete: function () {
                                        // Remove animation classes after AJAX request is complete
                                        $('.profile_image .img').removeClass('div_animation overly');
                                        $('.profile_image .img img.avatar').removeClass('image_animation');
                                        $('.profile_image .camera-icon').css('display', 'block');
                                    },
                                    error: function (xhr) {
                                        if (xhr.status === 422) {
                                            var errors = xhr.responseJSON.errors;
                                            $.each(errors, function (field, messages) {
                                                var errorHtml = '';
                                                $.each(messages, function (index, message) {
                                                    errorHtml +=
                                                        '<span class="invalid-feedback d-block" role="alert">' +
                                                        message + '</span>';
                                                });
                                                $('[name="' + field + '"]').after(errorHtml);
                                            });
                                        } else {
                                            console.log('An error occurred.');
                                        }
                                    }
                                });
                            }, 5000); // 10 seconds delay

                            
                        },
            });
        }
    </script>
@endpush
