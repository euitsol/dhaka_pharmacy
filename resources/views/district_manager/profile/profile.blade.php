@extends('district_manager.layouts.master', ['pageSlug' => 'district_manager_profile'])

@push('css')
    <style>
        .profile_image .camera-icon {
            position: absolute;
            bottom: -8%;
            font-size: 20px;
            height: 45px;
            width: 46px;
            line-height: 46px;
            left: 50%;
            text-align: center;
            right: 50%;
            transform: translateX(-50%);
            background: #fff;
            color: #E87BD7;
            border-radius: 50%;
            border: 1px solid #E87BD7;
        }
        .profile_image .img{
            height: 100%;
            width: 100%;
            border: 5px solid #2b3553;
            border-bottom-color: transparent;
            position: relative;
            /* border-radius: 50%; */
            /* animation: round 5s linear infinite; */

        }
        .profile_image .img img.avatar{
            width: 100%;
            height: 100%;
            border:none;
            border-radius: 0 !important;
            /* border-radius: 50%; 
            animation: rounds 5s linear infinite reverse; */
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

        button.btn.btn-icon.btn-round{
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            {{-- <div class="row">
                <div class="col-md-8"> --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{__('Edit Profile')}}</h5>
                        </div>
                        <form method="POST" action="{{route('dm.profile.update')}}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT');
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>{{__('Name')}}</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                                value="{{dm()->name}}">
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('Phone')}}</label>
                                            <input type="phone" name="phone" class="form-control" placeholder="Enter phone"
                                                value="{{dm()->phone}}">
                                            @include('alerts.feedback', ['field' => 'phone'])
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{__('Age')}}</label>
                                                    <input type="text" name="age" value="{{(dm()->age) ? dm()->age : old('age')}}" class="form-control" placeholder="Enter age">
                                                    @include('alerts.feedback', ['field' => 'age'])
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{__('Area')}}</label>
                                                    <select name="area" class="form-control">
                                                        <option selected hidden>{{__('Select Area')}}</option>
                                                    </select>
                                                    @include('alerts.feedback', ['field' => 'area'])
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{__('Identification Type')}}</label>
                                                    <select name="identification_type" id="identification_type" class="form-control">
                                                        <option selected hidden>{{__('Select Identification Type')}}</option>
                                                        <option value="NID" {{(dm()->identification_type == "NID") ? 'selected' : ''}}>{{__('National ID Card')}}</option>
                                                        <option value="DOB" {{(dm()->identification_type == "DOB") ? 'selected' : ''}}>{{__('Date of Birth')}}</option>
                                                        <option value="Passport" {{(dm()->identification_type == "Passport") ? 'selected' : ''}}>{{__('Passport NO')}}</option>
                                                    </select>
                                                    @include('alerts.feedback', ['field' => 'identification_type'])
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{__('Identification NO')}}</label>
                                                    <input type="text" name="identification_no" id="identification_no" value="{{(dm()->identification_no) ? dm()->identification_no : old('identification_no')}}" class="form-control" placeholder="Enter identification number">
                                                    @include('alerts.feedback', ['field' => 'identification_no'])
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('Upload CV')}}</label>
                                                    <input type="file" accept=".pdf" class="form-control" name="cv">
                                                    @include('alerts.feedback', ['field' => 'cv'])
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('Present Address')}}</label>
                                                    <textarea name="present_address" class="form-control" placeholder="Enter present address">{{dm()->present_address ? dm()->present_address : old('present_address') }}</textarea>
                                                    @include('alerts.feedback', ['field' => 'present_address'])
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <button type="submit" class="btn btn-fill btn-primary">{{__('Update')}}</button>
                                    </form>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <form class="updateForm" autocomplete="off" enctype="multipart/form-data">
                                            @csrf
                                                <div class="profile_image">
                                                    <div class="img mx-auto mt-4">
                                                        <img class="avatar mb-0" id="previewImage" src="https://white-dashboard-laravel.creative-tim.com/white/img/emilyz.jpg" alt="">
                                                        <label for="imageInput" class="camera-icon">
                                                            <i class="fa-solid fa-camera-retro" style="cursor: pointer;"></i>
                                                            <input type="file" id="imageInput" name="image" accept="image/*" class="d-none">
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                {{-- <h5 class="title">{{dm()->name}}</h5>
                                                <p class="description">{{__('District Manager')}}</p> --}}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{__('Password')}}</h5>
                        </div>
                        <form method="POST" action="{{route('dm.profile.update.password')}}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT');
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{__('Current Password')}}</label>
                                    <input type="password" name="old_password" class="form-control" placeholder="Current Password"
                                        >
                                    @include('alerts.feedback', ['field' => 'old_password'])
                                </div>
                                <div class="form-group">
                                    <label>{{__('New Password')}}</label>
                                    <input type="password" name="password" class="form-control" placeholder="New Password"
                                        >
                                    @include('alerts.feedback', ['field' => 'password'])

                                </div>
                                <div class="form-group">
                                    <label>{{__('Confirm New Password')}}</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm New Password">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-fill btn-primary">{{__('Change password')}}</button>
                            </div>
                        </form>
                    </div>
                {{-- </div> --}}
                {{-- <div class="col-md-4">
                    <div class="card card-user">
                        <div class="card-body">
                            <p class="card-text">
                            </p>
                            <div class="author">
                                <div class="block block-one"></div>
                                <div class="block block-two"></div>
                                <div class="block block-three"></div>
                                <div class="block block-four"></div>
                                <form class="updateForm" autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                        <div class="image">
                                            <div class="img mx-auto">
                                                <img class="avatar" id="previewImage" src="https://white-dashboard-laravel.creative-tim.com/white/img/emilyz.jpg" alt="">
                                            </div>
                                            <label for="imageInput">
                                                <i class="fa-solid fa-camera-retro camera-icon" style="cursor: pointer;"></i>
                                                <input type="file" id="imageInput" name="image" accept="image/*" class="d-none">
                                            </label>
                                        </div>
                                        
                                        <h5 class="title">{{dm()->name}}</h5>
                                        <p class="description">
                                        District Manager
                                    </p>
                                </form>
                            </div>
                            <p></p>
                            <div class="card-description">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga provident, cumque velit harum assumenda nulla eaque, repellendus explicabo nihil sunt nisi tempora perspiciatis, nostrum illo? Alias voluptates dignissimos voluptatibus recusandae laborum mollitia cum, maxime iste aperiam assumenda fugiat harum quod quo? Nostrum repellat totam tenetur deleniti, eaque voluptas neque velit!
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="button-container">
                                <button class="btn btn-icon btn-round btn-facebook">
                                    <i class="fab fa-facebook"></i>
                                </button>
                                <button class="btn btn-icon btn-round btn-twitter">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button class="btn btn-icon btn-round btn-google">
                                    <i class="fab fa-google-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- </div> --}}
        </div>
        @include('district_manager.partials.documentation', ['document' => $document])
        
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
    var form = $('#updateForm');
    $('#imageInput').change(function () {
        var preview = $('#previewImage')[0];
        var fileInput = $(this)[0];
        var file = fileInput.files[0];

        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);

            let _url = "{{ route('dm.profile.update.image')}}";
            let formData = new FormData(form[0]); // Fix: Use form instead of 'this'
            $.ajax({
                type: 'POST',
                url: _url,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response.message);
                    window.location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            var errorHtml = '';
                            $.each(messages, function (index, message) {
                                errorHtml += '<span class="invalid-feedback d-block" role="alert">' + message + '</span>';
                            });
                            $('[name="' + field + '"]').after(errorHtml);
                        });
                    } else {
                        console.log('An error occurred.');
                    }
                }
            });
        } else {
            preview.src = "https://white-dashboard-laravel.creative-tim.com/white/img/emilyz.jpg";
        }
    });
});
</script>
@endpush
