@if ($odr && $status != 3 && $status != -1)
    @if ($status == 2)
        <h5><b>{{ __('Note:') }}</b> <span
                class="text-danger">{{ __('Please verify your order before handing it over to the rider. Your OTP is : ') }}
            </span> <strong class="text-success">{{ optional($otp)->otp }}</strong></h5>
    @endif
    @if ($status == 4)
        <h4 class="text-success m-0 py-3">{{ __('Order successfully collected.') }}</h4>
    @endif
    @if ($status == 5)
        <h4 class="text-success m-0 py-3">{{ __('Order successfully delivered.') }}</h4>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('Rider Details') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="rider_image">
                                <img src="{{ storage_url($odr->rider->image) }}" alt="">
                            </div>
                        </div>
                        <div class="card-footer bg-secondary">
                            <h3 class="text-white m-0">{{ $odr->rider->name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <th>{{ __('Rider Name') }}</th>
                                <td>:</td>
                                <th>{{ $odr->rider->name }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Rider Gender') }}</th>
                                <td>:</td>
                                <th>{{ $odr->rider->gender }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Rider Contact') }}</th>
                                <td>:</td>
                                <th>{{ $odr->rider->phone }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Rider Age') }}</th>
                                <td>:</td>
                                <th>{{ $odr->rider->age }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Delivery Priority') }}</th>
                                <td>:</td>
                                <th>{{ $odr->priority() }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Operational Area') }}</th>
                                <td>:</td>
                                <th>{{ $odr->rider->operation_area->name }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Operational Sub Area') }}</th>
                                <td>:</td>
                                <th>{{ optional($odr->rider->operation_sub_area)->name }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
