@extends('rider.layouts.master', ['pageSlug' => $dor->statusTitle() . '_orders'])
@section('title', 'Order Details')
@push('css')
@endpush
@push('css_link')
    <link href="https://pbutcher.uk/flipdown/css/flipdown/flipdown.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('rider/css/order_details.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __(slugToTitle($dor->statusTitle()) . ' Order Details') }}</h4>
                    @if ($dor->status < 2)
                        <div class="flipdown" id="flipdown" data-time="{{ $dor->od->rider_collect_time }}">
                        </div>
                    @elseif($dor->status < 3)
                        <div class="flipdown" id="flipdown" data-time="{{ $dor->od->rider_delivery_time }}">
                        </div>
                    @endif
                    <a href="{{ URL::previous() }}" class="btn btn-success">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @include('rider.orders.includes.order_details', [
                                'dor' => $dor,
                            ])
                        </div>
                        <div class="col-md-4">
                            @include('rider.orders.includes.order_tracking', [
                                'dor' => $dor,
                            ])
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- for pendind & picking up --}}
        @if ($dor->status == 0 || $dor->status == 1)
            @include('rider.orders.includes.pharmacy_details', [
                'dor' => $dor,
            ])
        @elseif ($dor->status == 2)
            @include('rider.orders.includes.customer_details', [
                'dor' => $dor,
            ])
        @endif
    </div>

    @include('rider.orders.includes.modals')
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

    <script>
        function initializeFlipDown(prepTime) {
            var currentTime = new Date().getTime() / 1000; // Get current time in seconds
            var targetTime = new Date(prepTime).getTime() / 1000; // Get target time in seconds
            var timeDifference = targetTime - currentTime; // Calculate the difference in seconds

            var flipdown = new FlipDown(currentTime + timeDifference, {
                    theme: "dark",
                    headings: ["Hours", "Minutes", "Seconds"], // Custom headings for hours, minutes, and seconds
                })
                .start()
                .ifEnded(function() {
                    $(".flipdown").html(
                        `<span class="text-danger text-center d-block">DELAYED</span>`
                    );
                });

            // Hide the days column
            document
                .querySelectorAll(".flipdown__box.flipdown__box--day")
                .forEach((box) => (box.style.display = "none"));
        }
        $(document).ready(function() {
            initializeFlipDown($("#flipdown").data('time'));
            $(".flipdown").show();
        });

        // Order Tracking
        $(document).ready(function() {
            $(".tracking_card").height($(".order_details_card").height() + "px");
        });
    </script>
@endpush

@push('js_link')
    <script src="https://pbutcher.uk/flipdown/js/flipdown/flipdown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
