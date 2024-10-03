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
                            <div class="icon {{ $dor->status >= 0 ? 'confirm' : '' }} text-center">
                                @if ($dor->status >= 0)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <div class="after {{ $dor->status >= 1 ? 'active' : '' }}"></div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Assigned') }}</h5>
                            @if ($dor->status >= 0)
                                <p class="m-0">{{ __('Assigned at - ') }}
                                    {{ orderTimeFormat($dor->created_at) }}</p>
                                @if ($dor->status < 2)
                                    <p class="m-0">
                                        <span>{{ __('Collection time left') }} ( {!! remainingTime($dor->od->rider_collect_time, true) !!} )</span>
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="step step-3">
                    <div class="d-inline-flex">
                        <div class="icon_wrap">
                            <div class="icon {{ $dor->status >= 2 ? 'confirm' : '' }} text-center">
                                @if ($dor->status >= 2)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                            <div class="after {{ $dor->status >= 2 ? 'active' : '' }}"></div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Collected') }}</h5>
                            @foreach ($dor->od->odps->where('status', '!=', '-1')->unique('pharmacy_id') as $odp)
                                @if ($odp->status == 3)
                                    <p class="m-0"><span>
                                            {{ __($odp->pharmacy->name . ' order collected at - ') }}
                                            {{ orderTimeFormat($odp->updated_at) }}
                                        </span></p>
                                @endif
                            @endforeach
                            @if ($dor->status >= 2)
                                {{-- <p class="m-0"><span>
                                        {{ __('Collected at - ') }}
                                        {{ orderTimeFormat($dor->od->rider_collected_at) }}
                                    </span></p> --}}
                                @if ($dor->status < 3)
                                    <p class="m-0">
                                        <span>{{ __('Delivery time left') }} ( {!! remainingTime($dor->od->rider_delivery_time, true) !!} )</span>
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="step step-4">
                    <div class="d-inline-flex">
                        <div class="icon_wrap">
                            <div class="icon {{ $dor->status >= 3 ? 'confirm' : '' }} text-center">
                                @if ($dor->status >= 3)
                                    <img src="{{ asset('user/asset/img/check.png') }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Delivered') }}</h5>
                            @if ($dor->status >= 3)
                                <p><span>{{ orderTimeFormat($dor->od->rider_delivered_at, true) }}
                                    </span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
