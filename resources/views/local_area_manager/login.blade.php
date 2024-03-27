@extends('frontend.layouts.master')
@section('title','Local Area Manager Login')
@push('css')
<style>
    
    .lam-login-section {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }    
    .lam-login-section .left_column .tabs_wrap .tab{
        cursor: pointer;
        font-size: 24px;
        transition: .4s all;
    }
    .lam-login-section .left_column .tabs_wrap .tab span{
        font-size: 18px;
        font-weight: 600;

    }
    .lam-login-section .left_column .tabs_wrap .tab i{
        transition: .4s all;
    }
    .lam-login-section .left_column .tabs_wrap .tab:hover i{
        transform: scale(1.5);
    }
    .lam-login-section .right_column{
        color: #333;
    }
    .lam-login-section .right_column .form-group .input-group{
        background-color: #eee;
    }
    .lam-login-section .right_column .form-group input{
        background-color: transparent;
        border-radius: 0 !important;
    }
    .lam-login-section .right_column .form-group input:focus{
        border: none;
        outline: none;
        box-shadow: none;
    }
    .lam-login-section .right_column .form-group .submit_button{
        background-color: #225F91;
        font-weight: 600;
        color: #fff;
        transition: .4s;
    }
    .lam-login-section .right_column .form-group .submit_button:hover{
        opacity: .8;
    }
    .lam-login-section .right_column .login_form .forget span{
        cursor: pointer;
    }
    .lam-login-section .left_column .tabs_wrap .tab.active{
        background-color: #225F91;
        color: #fff;
    }
    .reference{
        position: relative;
    }
    .reference .loading{
        position: absolute;
        height: 40px;
        width: 40px;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }
    .reference .loading img{
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

</style>
@endpush
@section('content')
    <section class="lam-login-section bg-gray py-5 my-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="left_column mb-5 mb-md-0">
                                <div class="row">
                                    <div class="col-md-7 pe-md-0">
                                        <div class="image_wrap h-100">
                                            <img style="object-fit: cover" src="{{asset('frontend\asset\img\lam_login_reg.jpeg')}}" class="h-100 w-100" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-5 ps-md-0">
                                        <div class="tabs_wrap bg-white h-100 d-flex justify-content-between align-items-center flex-md-column text-center">
                                            <div class="tab tab-1 h-100 w-100 py-lg-5 py-4 active">
                                                <i class="fa fa-user"></i>
                                                <span class="d-block mt-3 mt-lg-2">Login</span>
                                            </div>
                                            <div class="tab tab-2 h-100 w-100 py-lg-5 py-4">
                                                <i class="fa fa-edit"></i>
                                                <span class="d-block mt-3 mt-lg-2">Register</span>
                                            </div>
                                            <div class="tab tab-3 h-100 w-100 py-lg-5 py-4">
                                                <i class="fa fa-lock"></i>
                                                <span class="d-block mt-3 mt-lg-2">Forget Password?</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="right_column bg-white h-100">

                                <!-- Login Form  -->
                                <div class="login_form form px-4  py-4">
                                    <form action="{{ route('local_area_manager.login') }}" method="POST" autocomplete="on">
                                        @csrf
                                        <h3 class="text-center mb-5 mb-lg-5">{{__('Login Here')}}</h3>
                                        <div class="form-group mb-3 mb-lg-4">
                                            <div class="input-group" role="group">
                                                <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-phone"></i></span>
                                                <input type="text" placeholder="Phone" name="phone" value="{{ old('phone') }}" class="border-0 form-control @error('phone') is-invalid @enderror" autofocus required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 mb-lg-4">
                                            <div class="input-group" role="group">
                                                <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-key"></i></span>
                                                <input type="password" placeholder="Password" class="border-0 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" required>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 mb-lg-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
        
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 mb-lg-4">
                                            <input type="submit" value="Login" class="border-0 form-control py-2 py-lg-3 submit_button">
                                        </div>
                                        <div class="forget text-center py-3 py-lg-4">
                                            <span>{{__('Forget Password?')}}</span>
                                        </div>
                                    </form>
                                </div>

                                <!-- Register Form  -->
                                <div class="register_form form d-none px-4 pt-lg-5 pb-lg-3 py-4">
                                    <form action="{{ route('local_area_manager.register') }}" method="POST" autocomplete="on">
                                        @csrf
                                        <h3 class="text-center mb-3 mb-lg-3">{{__('Register Here')}}</h3>
                                        <div class="form-group mb-3 mb-lg-4">
                                            <div class="input-group" role="group">
                                                <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-user"></i></span>
                                                <input type="text" name="name" value="{{old('name')}}" placeholder="Name" class="border-0 form-control  @error('name') is-invalid @enderror" required autocomplete="name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 mb-lg-4">
                                            <div class="input-group" role="group">
                                                <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-phone"></i></span>
                                                <input type="text" name="phone" value="{{old('phone')}}" placeholder="Phone" class="border-0 form-control  @error('phone') is-invalid @enderror" required autocomplete="phone">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 mb-lg-4">
                                            <div class="input-group reference" role="group">
                                                <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa-solid fa-hashtag"></i></span>
                                                <input type="text" id="reference" name="dm_id" value="{{old('dm_id')}}" placeholder="Reference ID" class="border-0 form-control  @error('dm_id') is-invalid @enderror" required autocomplete="dm_id">
                                                @error('dm_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <div class="loading" style="display: none">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-md-flex">
                                            <div class="form-group mb-3 mb-lg-4 col-md-6 pe-md-2">
                                                <div class="input-group" role="group">
                                                    <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-key"></i></span>
                                                    <input type="password" name="password" placeholder="Password" class="border-0 form-control  @error('password') is-invalid @enderror" required autocomplete="new-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 mb-lg-4 col-md-6 ps-md-2">
                                                <div class="input-group" role="group">
                                                    <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-key"></i></span>
                                                    <input type="password" placeholder="Confirm Password" class="border-0 form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-3 mb-lg-2">
                                                <input type="submit" value="Register" class="border-0 form-control py-2 py-lg-3 submit_button">
                                        </div>
                                    </form>
                                </div>


                                <!-- Reset Form  -->
                                <div class="reset_form form d-none px-4 py-lg-5 py-4">
                                    <form action="" method="" autocomplete="on">
                                        <h3 class="text-center mb-5 mb-lg-5">Reset Password</h3>
                                        <p class="mb-3 mb-lg-4">Enter your phone number below and we'll send you a verification code to your phone.</p>
                                        <p class="mb-4 mb-lg-5"><strong>Need Help?</strong> Learn more about how to <a href="#">retrieve an existing account</a>.</p>
                                        <div class="form-group mb-3 mb-lg-4">
                                            <div class="input-group" role="group">
                                                <span class="pe-3 ps-4 py-2 py-lg-3"><i class="fa fa-phone"></i></span>
                                                <input type="text" placeholder="Phone" class="border-0 form-control">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 mb-lg-4">
                                                <input type="submit" value="Reset" class="border-0 form-control py-2 py-lg-3 submit_button">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        console.log("HI");
        var tab = $(".tab");
        var tab1 = $(".tab-1");
        var tab2 = $(".tab-2");
        var tab3 = $(".tab-3");
        var form = $(".form");
        var login_form = $(".login_form");
        var register_form = $(".register_form");
        var reset_form = $(".reset_form");

        var forget = $('.forget');

        tab1.find('i').css("transform", 'scale(1.5)');
        login_form.removeClass('d-none');

        tab.on("click", function () {
            tab.find('i').css("transform",'scale(1)');
            $(this).find('i').css("transform", 'scale(1.5)');


            tab.removeClass("active");
            $(this).addClass("active");
            form.addClass('d-none')
            if (tab1.hasClass("active")) {
                login_form.removeClass('d-none');
            }
            if (tab2.hasClass("active")) {
                register_form.removeClass('d-none');
            }
            if (tab3.hasClass("active")) {
                reset_form.removeClass('d-none');
            }
        });


        forget.on("click", function () {
            tab.removeClass("active");
            $('.tab-3').addClass("active");
            form.addClass('d-none')
            reset_form.removeClass('d-none');
        });
    });



    //Reference ID Check
    $(document).ready(function() {
        $('#reference').on('input keyup', function() {
            var loadign = `<img src="{{asset('frontend/default/loading.gif')}}">`;
            var check = `<img src="{{asset('frontend/default/check.jpg')}}">`;
            var cross = `<img src="{{asset('frontend/default/cross.jpg')}}">`;
            var imageDiv = $('.loading');
            imageDiv.show();
            imageDiv.html(loadign);
            let id = $(this).val();
            console.log(id);
            let url = ("{{ route('local_area_manager.reference', ['id']) }}");
            let _url = url.replace('id', id);
            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data.status == true){
                        imageDiv.html(check);
                    }else{
                        imageDiv.html(cross);
                    }
                        
                },

                error: function(xhr, status, error) {
                    imageDiv.html(cross);
                    console.error('Error fetching user data:', error);
                    
                }
            });
        });
    });
</script>
@endpush
