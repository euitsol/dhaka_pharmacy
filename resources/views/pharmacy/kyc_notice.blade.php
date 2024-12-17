@extends('pharmacy.layouts.master', ['pageSlug' => 'kyc_notice'])
@section('title', 'KYC Notice')
@section('content')
    <div class="row px-3">
        <div class="card">
            <div class="card-body text-center text-danger">
                <div class="kyc-alert d-flex align-items-center justify-content-center" style="height: 85vh;">
                    <div class="alert-content">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 20rem;"></i>
                        <p class="text-danger">{{ __('Please complete your KYC verification to access this page') }}
                        </p>
                        <a href="{{ route('pharmacy.kyc.verification') }}"
                            class="btn btn-primary">{{ __('KYC Verification Center') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
