@extends('frontend.layouts.master')
@section('title', 'District Manager Reset Password')
@push('css')
    <link rel="stylesheet" href="{{ asset('dm/css/login.css') }}">
@endpush
@section('content')
    <section class="district-section py-5">
        <div class="container">
            <div class="row">
                <div class="district-container">
                    <div class="row row-gap-4">
                        <div class="col-md-5">
                            <div class="image-col pe-md-4 pe-0 ">
                                <img src="{{ asset('dm/image/distric.png') }}" alt="dsitrict login">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form ps-md-4 ps-0 h-100 d-flex align-items-center justify-content-center">
                                <div class="form-content w-100">
                                    <h2 class="text-center mb-4">{{ __('Reset Password') }}</h2>
                                    <form action="{{ route('district_manager.reset.password', $dm_id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" id="password" name="password" class="form-control"
                                                    placeholder="Enter your new password" required>
                                                <span class="input-group-text eye_btn"><i
                                                        class="fa-solid fa-eye-slash"></i></span>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'password'])
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" id="confirmPassword" name="password_confirmation"
                                                    class="form-control" placeholder="Confirm your password" required>
                                                <span class="input-group-text eye_btn"><i
                                                        class="fa-solid fa-eye-slash"></i></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" id="rememberMe" class="form-check-input">
                                            <label for="rememberMe" class="form-check-label">{{ __('Remember Me') }}</label>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary w-100 login-button">{{ __('SUBMIT') }}</button>
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
        $(document).ready(function() {
            $('.eye_btn').click(function() {
                var input = $(this).prev('input');
                if (input.attr('type') == 'password') {
                    $(this).html('<i class="fa-solid fa-eye"></i>');
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                    $(this).html('<i class="fa-solid fa-eye-slash"></i>');
                }
            });
        });
    </script>
@endpush
