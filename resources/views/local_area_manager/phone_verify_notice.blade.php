@extends('local_area_manager.layouts.master', ['pageSlug' => 'phone_verify_notice'])
@section('title', 'Phone Verify Notice')
@section('content')
    <div class="row px-3">
        <div class="card">
            <div class="card-body text-center text-danger">
                <div class="kyc-alert d-flex align-items-center justify-content-center" style="height: 85vh;">
                    <div class="alert-content">
                        <i class="fa-solid fa-phone" style="font-size: 20rem;"></i>
                        <p class="text-danger">{{ __('Please verify your phone to access this page') }}
                        </p>
                        <a href="{{ route('local_area_manager.phone.verify', encrypt(lam()->id)) }}"
                            class="btn btn-primary">{{ __('Verify Your Phone') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
