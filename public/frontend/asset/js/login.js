$(document).ready(function () {
    const inputs = $(".otp-container > input");
    const button = $("#verifyOTP");

    inputs.eq(0).focus();
    button.prop("disabled", true);

    inputs.eq(0).on("paste", function (event) {
        event.preventDefault();

        const pastedValue = (
            event.originalEvent.clipboardData || window.clipboardData
        ).getData("text");
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
    //  OTP Type
    inputs.each(function (index1) {
        $(this).on("keyup", function (e) {
            const currentInput = $(this);
            const nextInput = currentInput.next();
            const prevInput = currentInput.prev();

            if (currentInput.val().length > 1) {
                currentInput.val("");
                return;
            }

            if (
                nextInput &&
                nextInput.attr("disabled") &&
                currentInput.val() !== ""
            ) {
                nextInput.removeAttr("disabled");
                nextInput.focus();
            }

            if (e.key === "Backspace") {
                inputs.each(function (index2) {
                    if (index1 <= index2 && prevInput) {
                        $(this).attr("disabled", true);
                        $(this).val("");
                        prevInput.focus();
                    }
                });
            }

            button.prop("disabled", true);

            const inputsNo = inputs.length;
            if (
                !inputs.eq(inputsNo - 1).prop("disabled") &&
                inputs.eq(inputsNo - 1).val() !== ""
            ) {
                button.prop("disabled", false);
                return;
            }
        });
    });

    // OTP Resend
    $("#send_otp_again").on("click", function (e) {
        e.preventDefault();
        let _url = $(this).attr("href");
        let id = $(this).data("id");
        let $this = $(this);
        $.ajax({
            url: _url,
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                id: id,
            },
            beforeSend: function () {
                $this.html(`<div class="spinner-border spinner-border-sm text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>`);
            },
            success: function (response) {
                $this.html("Sent Again");
                if (response.status == "success") {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            },
        });
    });
});
