@if ($do->assignedRider->first() && $do->status == 3)
    @if ($do->status == 4)
        <h4 class="text-success m-0 py-3">{{ __('Order successfully collected.') }}</h4>
    @endif
    @if ($do->status == 5)
        <h4 class="text-success m-0 py-3">{{ __('Order successfully delivered.') }}</h4>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('Rider Details') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-4">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <div class="rider_image">
                                <img src="{{ storage_url($do->assignedRider->first()->rider->image) }}" alt="">
                            </div>
                        </div>
                        <div class="card-footer bg-secondary">
                            <h3 class="text-white m-0">{{ $do->assignedRider->first()->rider->name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>{{ __('Rider Name') }}</th>
                                <td>:</td>
                                <th>{{ $do->assignedRider->first()->rider->name }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Rider Gender') }}</th>
                                <td>:</td>
                                <th>{{ $do->assignedRider->first()->rider->gender }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Rider Contact') }}</th>
                                <td>:</td>
                                <th>{{ $do->assignedRider->first()->rider->phone }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Rider Age') }}</th>
                                <td>:</td>
                                <th>{{ $do->assignedRider->first()->rider->age }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Priority') }}</th>
                                <td>:</td>
                                <th>{{ $do->assignedRider->first()->priority() }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Area') }}</th>
                                <td>:</td>
                                <th>{{ $do->assignedRider->first()->rider->operation_area->name }} <span
                                        class="small">({{ optional($do->assignedRider->first()->rider->operation_sub_area)->name }})</span>
                                </th>
                            </tr>
                            <tr>
                                <th>{{ __('OTP') }}</th>
                                <td>:</td>
                                <th>
                                    <span class="text-success">
                                        {{ __('Please verify your delivery man before handing the order to the rider.') }}
                                    </span>
                                    {{-- <strong
                                        class="text-success">{{ optional($do->active_otps->first())->otp }}</strong> --}}

                                    <button type="button" class="btn btn-success ml-1" data-bs-toggle="modal"
                                        data-bs-target="#otpVerifyModal">{{ __('Deliver') }}</button>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
