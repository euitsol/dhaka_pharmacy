<div class="modal fade" id="emailVerifyModal" tabindex="-1" aria-labelledby="emailVerifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailVerifyModalLabel">{{ __('Email Verification') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p class="text-center text-success" style="font-size: 5.5rem;">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </p>
                    <p class="text-center text-center h5 ">{{ __('Verify your OTP') }}
                    </p>
                    <p class="text-muted text-center">
                        {{ __('The verification code has been sent to your email. Please check your email and enter the OTP here to verify.') }}
                    </p>
                    <div class="email-verify">
                        <form action="{{ route('pharmacy.email.verify') }}" method="POST" class="text-center">
                            @csrf
                            <div class="field-set otp-field text-center">
                                <input name=otp[] type="number" />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                                <input name=otp[] type="number" disabled />
                            </div>
                            <button class="btn btn-success verify-btn mt-3 mb-1"
                                type="submit">{{ __('Verify') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $("#emailVerify").on('click', function() {
                let verifyButton = $(this);
                verifyButton.prop('disabled', true);
                verifyButton.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                let url = ("{{ route('pharmacy.email.send.otp') }}");
                $.ajax({
                    url: url,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        verifyButton.prop('disabled', false);
                        verifyButton.html('Verify');
                        if (response.success) {
                            toastr.success(response.message);
                            $("#emailVerifyModal").modal('show');
                        } else {
                            toastr.error(response.message);
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle potential errors gracefully
                        verifyButton.prop('disabled', false);
                        verifyButton.html('Verify');
                        toastr.error('An error occurred. Please try again later.');
                        console.error('AJAX Error:', textStatus,
                            errorThrown);
                    }
                })
            })
        });
        $(document).ready(function() {
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
