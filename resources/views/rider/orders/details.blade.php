@extends('rider.layouts.master', ['pageSlug' => $dor->statusTitle() . '_orders'])
@section('title', 'Order Details')
@push('css')
    <style>
        .pharmacy-location-map,
        .customer-location-map {
            height: 400px;
        }

        .map_direction,
        .c_map_direction {
            height: 500px;
        }

        .otp-letter-input {
            max-width: 100%;
            height: 90px;
            border: 1px solid #198754;
            border-radius: 10px;
            color: #198754;
            font-size: 60px;
            text-align: center;
            font-weight: bold;
        }

        .otp-field {
            flex-direction: row;
            column-gap: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-field input {
            height: 45px;
            background-color: #e9e9e9 !important;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid var(--bg-1);
            padding: unset !important;
        }

        .otp-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .otp-field input::-webkit-inner-spin-button,
        .otp-field input::-webkit-outer-spin-button {
            display: none;
        }

        .submit_button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .verify-btn {
            margin-top: 2rem;
            width: 20rem;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __(ucwords($dor->statusTitle()) . ' Order Details') }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ URL::previous() }}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <tbody>
                            <tr>
                                <td>{{ __('Order ID') }}</th>
                                <td>:</td>
                                <td>
                                    {{ $dor->od->order->order_id }}
                                    <span class="ml-1 badge badge-{{ $dor->statusBg() }}">{{ $dor->statusTitle() }}</span>
                                    </th>
                                <td>|</td>
                                <td>{{ __('Remaining Time') }}</td>
                                <td>:</td>
                                @if ($dor->status == 0 || $dor->status == 1)
                                    <td>{!! remainingTime($dor->od->rider_collect_time, true) !!}</td>
                                @elseif ($dor->status == 2)
                                    <td>{!! remainingTime($dor->od->rider_delivery_time, true) !!}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- for pendind & picking up --}}
            @if ($dor->status == 0 || $dor->status == 1)
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
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-success text-white get-otp-btn"
                                                        data-pharmacyId="{{ $odp->pharmacy->id }}"
                                                        data-odrId="{{ $dor->id }}">
                                                        Get OTP </a>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-info text-white pharmacy-direction-btn"
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
                                            <div class="pharmacy-location-map"
                                                id="pharmacy_location_map_{{ $key }}"
                                                data-longitude="{{ optional($odp->pharmacy->address)->longitude }}"
                                                data-latitude="{{ optional($odp->pharmacy->address)->latitude }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif ($dor->status == 2)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header ">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="card-title">{{ __('Customer Details') }}</h4>
                                        </div>
                                        <div>
                                            <a href="telto:{{ optional($dor->od->order->customer)->phone }}"
                                                class="btn btn-success text-white">
                                                Call </a>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0)"
                                                class="btn btn-info text-white customer-direction-btn"
                                                data-longitude="{{ optional($dor->od->order->address)->longitude }}"
                                                data-latitude="{{ optional($dor->od->order->address)->latitude }}">
                                                Direction </a>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="customer-location-map" id="cmap"
                                        data-longitude="{{ optional($dor->od->order->address)->longitude }}"
                                        data-latitude="{{ optional($dor->od->order->address)->latitude }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
            @endif
        </div>
    </div>

    </div>

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
                                <input type="hidden" name="od" value="{{  encrypt($dor->od->id) }}">
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
@endsection

@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('rider/js/remaining.js') }}"></script>
    <script src="{{ asset('rider/js/direction.js') }}"></script>
    <script src="{{ asset('rider/js/map.js') }}"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.get-otp-btn', function() {
                var odrId = $(this).attr('data-odrId');
                var pharmacyId = $(this).attr('data-pharmacyId');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('rider.order_management.get_otp') }}',
                    data: {
                        odrId: odrId,
                        pharmacyId: pharmacyId,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('.otpModal').modal('show');
                            $('.otpModal .modal_data #pharmacy_name').html(response.data
                                .pharmacy.name)
                            var otp = response.data.otp.otp.toString();
                            var append = ``;
                            for (let i = 0; i < otp.length; i++) {
                                textContent = otp[i];
                                append += `
                                    <div class="col-2">
                                        <input class="otp-letter-input" type="text" disabled value="${textContent}">
                                    </div>
                                `;
                            }
                            $('.otpModal .modal_data .otp_div').html(append)
                        }
                    }
                })
            });

            $('.deliver').on('click', function() {
                $('.c_map-direction-modal').modal('hide');
                $('.user-otp-modal').modal('show');
            });


            const inputs = $(".otp-field > input");
            const button = $(".verify-btn");

            inputs.eq(0).focus();
            button.prop("disabled", true);

            inputs.eq(0).on("paste", function(event) {
                event.preventDefault();

                const pastedValue = (event.originalEvent.clipboardData || window.clipboardData)
                    .getData(
                        "text");
                const otpLength = inputs.length;

                for (let i = 0; i < otpLength; i++) {
                    if (i < pastedValue.length) {
                        inputs.eq(i).val(pastedValue[i]);
                        inputs.eq(i).removeAttr("disabled");
                        inputs.eq(i).focus();
                    } else {
                        inputs.eq(i).val(""); // Clear any remaining inputs
                        inputs.eq(i).focus();
                    }
                }
            });

            inputs.each(function(index1) {
                $(this).on("keyup", function(e) {
                    const currentInput = $(this);
                    const nextInput = currentInput.next();
                    const prevInput = currentInput.prev();

                    if (currentInput.val().length > 1) {
                        currentInput.val("");
                        return;
                    }

                    if (nextInput && nextInput.attr("disabled") && currentInput
                        .val() !== "") {
                        nextInput.removeAttr("disabled");
                        nextInput.focus();
                    }

                    if (e.key === "Backspace") {
                        inputs.each(function(index2) {
                            if (index1 <= index2 && prevInput) {
                                $(this).attr("disabled", true);
                                $(this).val("");
                                prevInput.focus();
                            }
                        });
                    }

                    button.prop("disabled", true);

                    const inputsNo = inputs.length;
                    if (!inputs.eq(inputsNo - 1).prop("disabled") && inputs.eq(
                            inputsNo - 1)
                        .val() !== "") {
                        button.prop("disabled", false);
                        return;
                    }
                });
            });

        });
    </script>
@endpush
