@extends('district_manager.layouts.master', ['pageSlug' => 'kyc_notice'])
@section('title', 'KYC Notice')
@section('content')
    <div class="row px-3">
        <h1 class="text-center text-danger">{{ __('Please complete your KYC verification to access this page') }}</h1>
    </div>
@endsection
