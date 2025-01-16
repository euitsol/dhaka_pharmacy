<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ __('Pharmacies Details') }}</h4>
    </div>
    <div class="card-body">
        <div class="row justify-center">
            @foreach ($dor->od->active_odps->unique('pharmacy_id') as $key => $odp)
                <div class="col-md-6">
                    <div class="card pharmacy-details">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $odp->pharmacy->name }}</h4>
                                </div>
                                <div>
                                    <a href="javascript:void(0)" class="btn btn-success text-white get-otp-btn"
                                        data-pharmacyId="{{ $odp->pharmacy->id }}" data-odrId="{{ $dor->id }}">
                                        Get OTP </a>
                                </div>
                                <div>
                                    <a href="javascript:void(0)" class="btn btn-info text-white pharmacy-direction-btn"
                                        data-longitude="{{ optional($odp->pharmacy->address)->longitude }}"
                                        data-latitude="{{ optional($odp->pharmacy->address)->latitude }}">
                                        Direction </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped datatable">
                                <tbody>
                                    <tr>
                                        <th>{{ __('Pharmacy Name') }}</th>
                                        <td>:</td>
                                        <th>{{ $odp->pharmacy->name }}</th>
                                        <td>|</td>
                                        <th>{{ __('Pharmacy Contact') }}</th>
                                        <td>:</td>
                                        <th>{{ $odp->pharmacy->phone }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Operational Area') }}</th>
                                        <td>:</td>
                                        <th>{{ optional($odp->pharmacy->operation_area)->name }}</th>
                                        <td>|</td>
                                        <th>{{ __('Operational Sub Area') }}</th>
                                        <td>:</td>
                                        <th>{{ optional($odp->pharmacy->operation_sub_area)->name }}</th>

                                    </tr>
                                    <tr>
                                        <th>{{ __('Pharmacy Address') }}</th>
                                        <td>:</td>
                                        <th colspan="5" class="pharmacy_address">
                                            {{ optional($odp->pharmacy->address)->address }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pharmacy-location">
                            <div class="pharmacy-location-map" id="pharmacy_location_map_{{ $key }}"
                                data-longitude="{{ optional($odp->pharmacy->address)->longitude }}"
                                data-latitude="{{ optional($odp->pharmacy->address)->latitude }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
