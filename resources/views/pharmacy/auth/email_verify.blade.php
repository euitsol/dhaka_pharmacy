@extends('pharmacy.layouts.master', ['pageSlug' => 'email_verify'])
@section('title', 'Email Verify')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Email Verification') }}</h4>
                </div>

                <div class="card-body d-flex justify-content-center align-items-center py-5 my-5">
                    <form method="POST" action="{{ route('pharmacy.email.verify') }}" class="w-100">
                        @csrf
                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-4">
                                <input type="email" class="form-control" value="{{ $pharmacy->email }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="otp"
                                class="col-md-4 col-form-label text-md-end">{{ __('Verification Code') }}</label>

                            <div class="col-md-4">
                                <input id="otp" type="otp"
                                    class="form-control {{ $errors->has('otp') ? ' is-invalid' : '' }}" name="otp"
                                    value="{{ $pharmacy->otp }}" placeholder="Enter verification code">
                                @include('alerts.feedback', ['field' => 'otp'])
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('pharmacy.email.send.otp') }}">{{ __('Resent Code') }}</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
