@push('css')
    <style>
        .order-traking-row .icon {
            width: 21px;
            height: 21px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(217, 217, 217, 1);
            position: relative;
        }

        .order-traking-row .icon img {
            margin-left: 3px;
        }

        .order-traking-row .confirm {
            background-color: rgba(40, 163, 73, 1);
        }

        .order-traking-row .step .icon_wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 10px;
        }

        .order-traking-row .step .after {
            width: 5px;
            height: calc(100% - 21px);
            min-height: 35px;
            background-color: rgba(217, 217, 217, 1);
            right: -240px;
        }

        .order-traking-row .step .after.active {
            background-color: rgba(40, 163, 73, 1);
        }

        .order-traking-row .step-5 .icon::after {
            width: 48px;
            right: -55px;
        }

        .order-traking-row .step h5 {
            font-family: var(--secondry-font);
            font-size: 14px;
            line-height: 21px;
            font-weight: 400;
            color: var(--text);
        }

        .order-traking-row .step h5 {
            font-family: var(--secondry-font);
            font-size: 14px;
            line-height: 21px;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 0;
        }

        .order-traking-row .step p {
            color: rgba(0, 0, 0, 0.58);
        }
    </style>
@endpush
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
                            <div class="after {{ $odps_status >= 2 ? 'active' : '' }}"></div>
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
                            <div class="after {{ $odps_status > 2 ? 'active' : '' }}"></div>
                        </div>
                        <div class="status_details pb-2">
                            <h5>{{ __('Order Prepared') }}</h5>
                            @if ($odps_status >= 2)
                                <p class="m-0"><span>
                                        {{ __('Prepared at - ') }}
                                        {{ orderTimeFormat($do->pharmacy_preped_at) }}
                                    </span></p>
                                @if ($do->status >= 3)
                                    @if ($do->status >= 4)
                                        <p class="m-0">
                                            <span>{{ __('Order collected at - ') }}{{ orderTimeFormat($do->rider_collected_at, true) }}
                                            </span>
                                        </p>
                                        @if ($do->status < 5)
                                            <p class="m-0">
                                                <span>{{ __('Order delivery time left') }}( {!! remainingTime($do->rider_delivery_time, true) !!}
                                                    )
                                                </span>
                                            </p>
                                        @endif
                                    @else
                                        <p class="m-0">
                                            <span>{{ __('Order collection time left') }} ( {!! remainingTime($do->rider_collect_time, true) !!}
                                                )</span>
                                        </p>
                                    @endif
                                @endif
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
                                <p class="m-0">
                                    {{ orderTimeFormat($do->rider_delivered_at) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('.tracking_card').height($('.order_details_card').height() + 'px');
        })
    </script>
@endpush
