<div class="modal fade" id="otpVerifyModal" tabindex="-1" aria-labelledby="otpVerifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpVerifyModalLabel">{{ __('OTP Verify') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p class="text-center text-success" style="font-size: 5.5rem;">
                        <i class="fa-solid fa-location-pin-lock"></i>
                    </p>
                    <p class="text-center text-center h5 ">{{ __('Verify rider') }}
                    </p>
                    <p class="text-muted text-center">
                        {{ __("Once this rider is verified you'll receive your point.") }}
                    </p>
                    <div class="">
                        <form action="{{ route('pharmacy.order_management.verify') }}" method="POST"
                            class="text-center">
                            @csrf
                            <input type="hidden" name="od" value="{{ $do->id }}">
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
