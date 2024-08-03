@extends('admin.layouts.master', ['pageSlug' => 'admin'])
@section('title', 'Admin Profile')
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
                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  show active" id="details" role="tabpanel"
                            aria-labelledby="details-tab">
                            @include('admin.admin_management.admin.includes.details')
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
                        <img class="avatar" src="{{ auth_storage_url($admin->image, $admin->gender) }}" alt="">
                        <h5 class="title mb-0">{{ $admin->name }}</h5>
                        <p class="description">
                            {{ __($admin->designation ?? 'Admin') }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description bio my-2 text-justify">
                        {!! $admin->bio !!}
                    </div>
                    <div class="contact_info py-3">
                        <ul class="m-0 px-3 list-unstyled">
                            <li>
                                <i class="fa-solid fa-phone-volume mr-2"></i>
                                <span class="title">{{ __('Mobile : ') }}</span>
                                <span class="content">{{ $admin->phone ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-regular fa-envelope mr-2"></i>
                                <span class="title">{{ __('Email : ') }}</span>
                                <span class="content">{{ $admin->email ?? '--' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                <span class="title">{{ __('Address : ') }}</span>
                                <span class="content">{!! $admin->present_address ?? '--' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
