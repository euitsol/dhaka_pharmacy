@extends('frontend.layouts.master')
@section('title', 'Rider Forgot Password')
@push('css')
    <link rel="stylesheet" href="{{ asset('rider/css/login.css') }}">
@endpush
@section('content')
    <section class="rider-section py-5">
        <div class="container">
            <div class="row">
                <div class="rider-container">
                    <div class="row row-gap-4">
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="image-col">
                                <img src="{{ asset('rider/img/rider.png') }}" alt="rider login">
                            </div>
                        </div>
                        <div class="col-lg-7 col-12">
                            <div class="form h-100 d-flex align-items-center justify-content-center">
                                <div class="form-content w-100">
                                    <h2 class="text-center mb-4">{{ __('Reset Password') }}</h2>
                                    <form action="{{ route('rider.reset.password', $rider_id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" name="password" id="password" class="form-control"
                                                    placeholder="Enter your new password" required>
                                                <span class="input-group-text eye_btn"><i
                                                        class="fa-solid fa-eye-slash"></i></span>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'password'])
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" name="password_confirmation" id="confirmPassword"
                                                    class="form-control" placeholder="Confirm your password" required>
                                                <span class="input-group-text eye_btn"><i
                                                        class="fa-solid fa-eye-slash"></i></span>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary w-100 login-button">{{ _('SUBMIT') }}</button>
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
