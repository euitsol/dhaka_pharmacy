{{-- OTP Modal  --}}
<div class="modal otpModal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button type="button" class="close btn btn-danger mt-2 mr-2" style="position: unset"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-white" style="font-size: 15px" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal_data">
                <div class="p-5">
                    <div>
                        <p class="text-center text-success" style="font-size: 5.5rem;">
                            <i class="fa-solid fa-shop-lock"></i>
                        </p>
                        <p class="text-center text-center h5 ">Your OTP for <span id="pharmacy_name"></span>
                        </p>
                        <p class="text-muted text-center">Use this OTP to collect order from pharmacy. This OTP will be
                            changed every time you click on get otp
                            button.</p>
                        <div class="row pt-4 pb-2 otp_div">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Map direction modal --}}
<div class="modal fade map-direction-modal" tabindex="-1" role="dialog" aria-labelledby="MapDirectionModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Pickup Direction') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="" style="font-size: 15px" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="map_direction" id="map_direction"></div>
            </div>
        </div>
    </div>
</div>

{{-- User OTP Verify --}}
<div class="modal fade user-otp-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('User OTP Verify') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="" style="font-size: 15px" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <p class="text-center text-success" style="font-size: 5.5rem;">
                        <i class="fa-solid fa-user-shield"></i>
                    </p>
                    <p class="text-center text-center h5 ">{{ __('Verify OTP') }}
                    </p>
                    <p class="text-muted text-center">
                        {{ __('User will provide you an OTP. Verify the OTP to deliver this order') }}
                    </p>
                    <div class="">
                        <form action="{{ route('rider.order_management.user.otp_verify') }}" method="POST"
                            class="text-center">
                            @csrf
                            <input type="hidden" name="od" value="{{ encrypt($dor->od->id) }}">
                            <div class="field-set otp-field text-center">
                                <input name=otp[] type="number" />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                            </div>
                            <button class="btn btn-success verify-btn mt-3 mb-1" type="submit">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Customer Map direction modal --}}
<div class="modal fade c_map-direction-modal" tabindex="-1" role="dialog" aria-labelledby="MapDirectionModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Delivery Direction') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="" style="font-size: 15px" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="c_map_direction" id="c_map_direction"></div>

                <div class="mt-3">
                    @if ($dor->status == 2)
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>{{ __('Customer') }}</td>
                                    <td>:</td>
                                    <td>
                                        <small> {{ __('Customer Name') }}:
                                            {{ optional($dor->od->order->customer)->name }}</small>
                                        <small>
                                            {{ __('Customer Phone') }}:
                                            {{ optional($dor->od->order->customer)->phone }}
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Receiver') }}</td>
                                    <td>:</td>
                                    <td>
                                        <small> {{ __('Receiver Name') }}:
                                            {{ optional($dor->od->order->address)->name }} </small>
                                        <small>
                                            {{ __('Receiver Phone') }}:
                                            {{ optional($dor->od->order->address)->phone }}
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('City Name') }}</td>
                                    <td>:</td>
                                    <td><small>{{ optional($dor->od->order->address)->city }}</small></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Street Name') }}</td>
                                    <td>:</td>
                                    <td><small>{{ optional($dor->od->order->address)->street_address }}</small></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Appartment') }}</td>
                                    <td>:</td>
                                    <td> <small>Name: {{ optional($dor->od->order->address)->apartment }} ;</small>
                                        <small>Floor: {{ optional($dor->od->order->address)->floor }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Address') }}</td>
                                    <td>:</td>
                                    <td><small>{{ optional($dor->od->order->address)->address }}</small></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Details') }}</td>
                                    <td>:</td>
                                    <td><small>{!! optional($dor->od->order->address)->delivery_instruction !!}</small></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
                <button type="button" class="btn btn-success deliver w-50">Deliver</button>
            </div>
        </div>
    </div>
</div>
