@extends('admin.layouts.master', ['pageSlug' => 'district_manager'])
@section('title', 'District Manager Profile')
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
                            <button class="nav-link col" id="earning-tab" data-bs-toggle="tab" data-bs-target="#earning"
                                type="button" role="tab" aria-controls="earning"
                                aria-selected="false">{{ __('Earnings') }}</button>
                            <button class="nav-link col" id="kyc-tab" data-bs-toggle="tab" data-bs-target="#kyc"
                                type="button" role="tab" aria-controls="kyc"
                                aria-selected="false">{{ __('KYC') }}</button>
                            <button class="nav-link col" id="lam-tab" data-bs-toggle="tab" data-bs-target="#lam"
                                type="button" role="tab" aria-controls="lam"
                                aria-selected="false">{{ __('Local Area Managers') }}</button>
                            <button class="nav-link col" id="user-tab" data-bs-toggle="tab" data-bs-target="#user"
                                type="button" role="tab" aria-controls="user"
                                aria-selected="false">{{ __('Users') }}</button>



                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            @include('admin.dm_management.district_manager.includes.details')
                        </div>
                        <div class="tab-pane fade" id="earning" role="tabpanel" aria-labelledby="earning-tab">
                            @include('admin.dm_management.district_manager.includes.earning')
                        </div>
                        <div class="tab-pane fade" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                            @include('admin.dm_management.district_manager.includes.kyc')
                        </div>
                        <div class="tab-pane fade" id="lam" role="tabpanel" aria-labelledby="lam-tab">
                            @include('admin.dm_management.district_manager.includes.lams')
                        </div>
                        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                            @include('admin.dm_management.district_manager.includes.users')
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
                        <img class="avatar" src="{{ auth_storage_url($dm->image, $dm->gender) }}" alt="">
                        <h5 class="title mb-0">{{ $dm->name }}</h5>
                        <p class="description">
                            {{ __('District Manager') }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description bio my-2 text-justify">
                        {!! $dm->bio !!}
                    </div>
                    <div class="earning_info py-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Available Balance') }}</h5>
                                        <h5 class="m-0 amount">
                                            {{ number_format(getEarningEqAmounts($earnings), 2) }}{{ __(' BDT') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total Users') }}</h5>
                                        <h5 class="m-0 amount">{{ number_format($users->count()) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-transparent p-0 mb-0">
                                    <div class="card-body p-2">
                                        <h5 class="title">{{ __('Total LAM') }}</h5>
                                        <h5 class="m-0 amount">{{ number_format($dm->lams->count()) }}
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
                                <span class="content">{{ $dm->phone ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-regular fa-envelope mr-2"></i>
                                <span class="title">{{ __('Email : ') }}</span>
                                <span class="content">{{ $dm->email ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                <span class="title">{{ __('Address : ') }}</span>
                                <span class="content">{!! $dm->present_address ?? '--' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
