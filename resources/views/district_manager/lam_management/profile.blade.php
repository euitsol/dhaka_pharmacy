@extends('district_manager.layouts.master', ['pageSlug' => 'lam'])
@section('title', 'Local Area Manager Profile')
@section('content')
    <div class="row profile">
        <div class="col-md-8">
            <div class="card h-100 mb-0">
                <div class="card-header px-4">
                    <nav>
                        <div class="nav nav-tabs row" id="nav-tab" role="tablist">
                            <button class="nav-link active col" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details"
                                aria-selected="true">{{ __('Details') }}</button>
                            <button class="nav-link col" id="kyc-tab" data-bs-toggle="tab" data-bs-target="#kyc"
                                type="button" role="tab" aria-controls="kyc"
                                aria-selected="false">{{ __('KYC') }}</button>
                            <button class="nav-link col" id="user-tab" data-bs-toggle="tab" data-bs-target="#user"
                                type="button" role="tab" aria-controls="user"
                                aria-selected="false">{{ __('Users') }}</button>
                            <button class="nav-link col" id="earning-tab" data-bs-toggle="tab" data-bs-target="#earning"
                                type="button" role="tab" aria-controls="earning"
                                aria-selected="false">{{ __('Earnings') }}</button>



                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            @include('district_manager.lam_management.includes.details')
                        </div>
                        <div class="tab-pane fade" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                            @include('district_manager.lam_management.includes.kyc')
                        </div>
                        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                            @include('district_manager.lam_management.includes.users')
                        </div>
                        <div class="tab-pane fade" id="earning" role="tabpanel" aria-labelledby="earning-tab">
                            @include('district_manager.lam_management.includes.earning')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user mb-0">
                <div class="card-body">
                    <p class="card-text">
                    <div class="author">
                        <img class="avatar" src="{{ auth_storage_url($lam->image, $lam->gender) }}" alt="">
                        <h5 class="title mb-0">{{ $lam->name }}</h5>
                        <p class="description">
                            {{ __($lam->designation ?? 'Local Area Manager') }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description bio my-2 text-justify">
                        {!! $lam->bio !!}
                    </div>
                    <div class="earning_info py-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Available Balance') }}</h5>
                                        <h5 class="m-0 amount">
                                            {{ number_format(getEarningEqAmounts($earnings), 2) }}{{ __(' BDT') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total Users') }}</h5>
                                        <h5 class="m-0 amount">{{ number_format($users->count()) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact_info py-3">
                        <ul class="m-0 px-3 list-unstyled">
                            <li>
                                <i class="fa-solid fa-phone-volume mr-2"></i>
                                <span class="title">{{ __('Mobile : ') }}</span>
                                <span class="content">{{ $lam->phone ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-regular fa-envelope mr-2"></i>
                                <span class="title">{{ __('Email : ') }}</span>
                                <span class="content">{{ $lam->email ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                <span class="title">{{ __('Address : ') }}</span>
                                <span class="content">{!! $lam->present_address ?? '--' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="card-footer">
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
                </div> --}}
            </div>
        </div>
    </div>
@endsection
