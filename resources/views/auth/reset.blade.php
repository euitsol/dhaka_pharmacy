@extends('frontend.layouts.master')
@section('title', 'User Password Reset')

@push('css')
    <link rel="stylesheet" href="{{ asset('user/user_login/style.css') }}">
@endpush
@section('content')
    <section class="log-with-pass">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xxl-6 col-md-10 mx-auto">
                    <div class="left-col login_wrap">
                        <div class="form-title">
                            <h1 class="otp_title">{{ __('UPDATE YOUR PASSWORD') }}</h1>
                            <h3>{{ __('Follow the instructions to make it easier to reset password and you will be able to explore
                                                                                                                                                                                                        inside.') }}
                            </h3>
                        </div>
                        <form action="{{ route('user.reset.password', $user_id) }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="phn input-box password_input">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" placeholder="Enter new password"
                                    class="password pass-n" autocomplete="off" readonly
                                    onfocus="this.removeAttribute('readonly');">
                                <span class="icon eye"><i id="eye-icon" class="fa-solid fa-eye"></i></i></span>
                            </div>
                            @include('alerts.feedback', ['field' => 'password'])
                            <div class="pass input-box password_input mb-3">
                                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password_confirmation" placeholder="Confirm password"
                                    class="password pass-c" autocomplete="off" readonly
                                    onfocus="this.removeAttribute('readonly');">
                            </div>
                            <input class="reset_pass_button submit_button" type="submit" value="UPDATE">

                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-6 d-none d-lg-block">
                    <div class="right-col">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('user/user_login/app.js') }}"></script>
@endpush
