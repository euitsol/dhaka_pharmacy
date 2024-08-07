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
        removeInvalidFeedback();
        login_title.show();
        otp_title.hide();
        otp_form.hide();
        login_form.find(".phone").val(otp_form.find(".phone").val());
        login_form.find(".password").val("");
        login_form.show();
    });
    otp_switch.on("click", function () {
        removeInvalidFeedback();
        login_title.hide();
        otp_title.show();
        login_form.hide();
        otp_form.find(".phone").val(login_form.find(".phone").val());
        otp_form.show();
    });
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
