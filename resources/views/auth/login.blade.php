@extends('frontend.layouts.master')
@section('title', 'User Login')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins&display=swap"
    rel="stylesheet">
@push('css')
    <style>
        .container-fluid {
            padding: 0 !important;
        }

        .login_form {
            width: 100%;
            max-height: calc(100vh - 83.40px);
            background-color: #ffffff;
            position: relative;
        }

        .login_form::before {
            content: '';
            position: absolute;
            background-image: url('{{ asset('user_login/Image/Vector 4.png') }}');
            width: 200px;
            height: 200px;
        }

        .right-col {
            text-align: right;
        }

        .row {
            margin-right: 0 !important;
        }

        .login_form form {
            padding: 100px;
        }

        .login_form .col-6 img {
            margin-top: -40px;
        }
    </style>
@endpush

@section('content')
    <section class="login_form">
        <div class="row py-5 ">
            <div class="col-6 p-5 p-5">
                <form>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="form1Example13" class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example13">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="form1Example23" class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example23">Password</label>
                    </div>

                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                            <label class="form-check-label" for="form1Example3"> Remember me </label>
                        </div>
                        <a href="#!">Forgot password?</a>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>

                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
                    </div>

                    <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!"
                        role="button">
                        <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
                    </a>
                    <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!"
                        role="button">
                        <i class="fab fa-twitter me-2"></i>Continue with Twitter</a>

                </form>

            </div>
            <div class="col-6 right-col p-0">
                <img src="{{ asset('user_login/Image/Frame.jpg') }}" alt="">
            </div>

        </div>
    </section>


@endsection
