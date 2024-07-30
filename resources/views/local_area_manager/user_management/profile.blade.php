@extends('local_area_manager.layouts.master', ['pageSlug' => 'user'])
@section('content')
    <div class="row profile">
        <div class="col-md-8">
            <div class="card h-100 mb-0">
                <div class="card-header">
                    <nav>
                        <div class="nav nav-tabs row" id="nav-tab" role="tablist">
                            <button class="nav-link active col" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details"
                                aria-selected="true">{{ __('Details') }}</button>
                            <button class="nav-link col" id="kyc-tab" data-bs-toggle="tab" data-bs-target="#kyc"
                                type="button" role="tab" aria-controls="kyc"
                                aria-selected="false">{{ __('KYC') }}</button>
                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            @include('local_area_manager.user_management.includes.details')
                        </div>
                        <div class="tab-pane fade" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                            @include('local_area_manager.user_management.includes.kyc')
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
                        <img class="avatar" src="{{ auth_storage_url($user->image, $user->gender) }}" alt="">
                        <h5 class="title mb-0">{{ $user->name }}</h5>
                        <p class="description">
                            {{ __($user->designation ?? 'General User') }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description bio my-2 text-justify">
                        {!! $user->bio !!}
                    </div>
                    <div class="earning_info py-3">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total Orders') }}</h5>
                                        <h5 class="m-0 amount">{{ number_format($orders->count()) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total Payments') }}</h5>
                                        <h5 class="m-0 amount">
                                            {{ number_format($payments->count()) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total Reviews') }}</h5>
                                        <h5 class="m-0 amount">{{ number_format($reviews->count()) }}
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
                                <span class="content">{{ $user->phone ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-regular fa-envelope mr-2"></i>
                                <span class="title">{{ __('Email : ') }}</span>
                                <span class="content">{{ $user->email ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                <span class="title">{{ __('Address : ') }}</span>
                                <span class="content">{!! $user->present_address ?? '--' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
