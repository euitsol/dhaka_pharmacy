<div class="card tracking_card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">{{ __('Order Tracking') }}</h5>
    </div>
    <div class="card-body">
        <div class="order-traking-row">
            <div class="progress-box d-flex flex-column">
                <div class="step step-1">
                    <div class="d-inline-flex">
                        <div class="icon_wrap">
                            <div class="icon {{ $odps_status >= 0 ? 'confirm' : '' }} text-center">
                                @if ($odps_status >= 0)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <div class="after {{ $odps_status >= 1 ? 'active' : '' }}"></div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Assigned') }}</h5>
                            @if ($odps_status >= 0)
                                <p class="m-0">{{ __('Assigned at - ') }}
                                    {{ orderTimeFormat($do->created_at) }}</p>
                                @if ($odps_status < 2)
                                    <p class="m-0">
                                        <span>{{ __('Preparation time left') }} ( {!! remainingTime($do->pharmacy_prep_time, true) !!} )</span>
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="step step-3">
                    <div class="d-inline-flex">
                        <div class="icon_wrap">
                            <div class="icon {{ $odps_status >= 2 ? 'confirm' : '' }} text-center">
                                @if ($odps_status >= 2)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <div class="after {{ $odps_status >= 2 ? 'active' : '' }}"></div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Prepared') }}</h5>
                            @if ($odps_status >= 2)
                                <p class="m-0"><span>
                                        {{ __('Prepared at - ') }}
                                        {{ orderTimeFormat($do->pharmacy_preped_at) }}
                                    </span></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="step step-4">
                    <div class="d-inline-flex">
                        <div class="icon_wrap">
                            <div class="icon {{ $odps_status >= 3 ? 'confirm' : '' }} text-center">
                                @if ($odps_status >= 3)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Delivered') }}</h5>
                            @if ($odps_status >= 3)
                                <span>{{ orderTimeFormat($do->odps->pluck('updated_at')->max(), true) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
