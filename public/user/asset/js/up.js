$(document).ready(function () {
    $(".up_button").on("click", function () {
        let url = data.check_auth;
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.requiresLogin) {
                    window.location.href = routes.login;
                } else if (response.success) {
                    $(".up_modal").modal("show");
                    refreshDeliveryFee();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    });
});
// Upload Prescription
$(document).ready(function () {
    $(".up_submit_btn").click(function () {
        var form = $(".up_form");
        $.ajax({
            type: "POST",
            url: data.upload_route,
            data: form.serialize(),
            success: function (response) {
                $(".invalid-feedback").remove();
                $(".up_modal").modal("hide");
                toastr.success(response.message);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Handle validation errors
                    var errors = xhr.responseJSON.errors;
                    $(".invalid-feedback").remove();
                    $.each(errors, function (field, messages) {
                        // Display validation errors
                        var errorHtml = "";
                        $.each(messages, function (index, message) {
                            errorHtml +=
                                '<span class="invalid-feedback d-block" role="alert">' +
                                message +
                                "</span>";
                        });
                        $('[name="' + field + '"]').after(errorHtml);
                        // Handle other errors.
                        let imageError =
                            '<span class="invalid-feedback d-block" role="alert">Image field is required</span>';
                        $('[name="uploadfile"]').parent().after(imageError);
                    });
                } else {
                    $(".invalid-feedback").remove();
                    // Handle other errors.
                    let imageError =
                        '<span class="invalid-feedback d-block" role="alert">Image field is required</span>';
                    $('[name="uploadfile"]').parent().after(imageError);
                }
            },
        });
    });
});
function refreshDeliveryFee(e = false) {
    var delivery_fee;
    if (e == false) {
        $(document).ready(function () {
            setTimeout(function () {
                delivery_fee = $(".user_address:checked")
                    .next("label")
                    .find(".delivery_charge")
                    .text()
                    .replace(",", "");
            }, 1500);
        });
    } else {
        delivery_fee = e
            .next("label")
            .find(".delivery_charge")
            .text()
            .replace(",", "");
    }
}
$(document).ready(function () {
    $(document).on("change", ".user_address", function () {
        refreshDeliveryFee($(this));
    });
});
