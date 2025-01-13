$(document).ready(function () {
    $(".eye").click(function () {
        var passwordField = $(".password");
        var eyeIcon = $("#eye-icon");

        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            eyeIcon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            eyeIcon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
});

function removeInvalidFeedback() {
    $(document).find(".invalid-feedback").remove();
}
function nameValid() {
    $(".name").parent(".input-box").next(".invalid-feedback").remove();
    $(".name").removeClass("form-control is-invalid");
    if ($(".name").val() === "" || $(".name").val() === null) {
        errorHtml = `<span class="invalid-feedback d-block" role="alert">The name field is required.</span>`;
        $(".name").parent(".input-box").after(errorHtml);
        $(".name").addClass("form-control is-invalid");
    }
}

$(document).ready(function () {
    let login_switch = $(".login_switch");
    let otp_switch = $(".otp_switch");

    let otp_title = $(".otp_title");
    let login_title = $(".login_title");
    let otp_form = $(".otp_form");
    let login_form = $(".login_form");

    login_switch.on("click", function () {
        if (!sessionStorage.getItem("login_type")) {
            removeInvalidFeedback();
        }
        login_title.show();
        otp_title.hide();
        otp_form.hide();
        login_form.find(".phone").val(otp_form.find(".phone").val());
        login_form.find(".password").val("");
        login_form.show();
        sessionStorage.setItem("login_type", "password");
    });
    otp_switch.on("click", function () {
        removeInvalidFeedback();
        login_title.hide();
        otp_title.show();
        login_form.hide();
        otp_form.find(".phone").val(login_form.find(".phone").val());
        otp_form.show();
        sessionStorage.setItem("login_type", "otp");
    });

    if (sessionStorage.getItem("login_type") === "password") {
        login_switch.trigger("click");
    }
});

function conPassMatch() {
    let new_pass = $(".pass-n");
    let con_pass = $(".pass-c");
    con_pass.parent(".pass").next(".invalid-feedback").remove();
    con_pass.removeClass("form-control is-invalid");
    if (con_pass.val() !== new_pass.val()) {
        errorHtml = `<span class="invalid-feedback d-block mt-3" role="alert">Confirm password not match.</span>`;
        con_pass.parent(".pass").after(errorHtml);
        con_pass.addClass("form-control is-invalid");
    }
}

$(document).ready(function () {
    $(".pass-c").on("input keyup", function () {
        nameValid();
        conPassMatch();
    });
    $(".pass-n").on("input keyup", function () {
        nameValid();
        conPassMatch();
    });
});

// Phone Validation
$(document).ready(function () {
    $(".phone").on("input keyup", function () {
        let phone = $(this).val();

        let digitRegex = /^\d{11}$/;
        let errorHtml = "";
        let submit_button = $(".submit_button");
        submit_button.addClass("disabled");

        $(this).parent(".input-box").next(".invalid-feedback").remove();
        $(this).removeClass("form-control is-invalid");
        // Check if the input is a number
        if (!isNaN(phone)) {
            if (digitRegex.test(phone)) {
                console.log("Valid");
                submit_button.removeClass("disabled");
            } else {
                errorHtml =
                    '<span class="invalid-feedback d-block" role="alert">Phone number must be 11 digit</span>';
                $(this).addClass("form-control is-invalid");
            }
        } else {
            errorHtml =
                '<span class="invalid-feedback d-block" role="alert">Invalid phone number</span>';
            $(this).addClass("form-control is-invalid");
        }
        $(this).parent(".input-box").after(errorHtml);
    });
});

// Send Again

$(document).ready(function () {
    $(".send_otp_again").click(function (e) {
        e.preventDefault();
        let _url = $(this).attr("href");
        $.ajax({
            url: _url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching member data:", error);
                toastr.error("Something is wrong!");
            },
        });
    });
});

$(document).ready(function () {
    const inputs = $(".otp-field > input");
    const button = $(".verify-btn");

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
});
