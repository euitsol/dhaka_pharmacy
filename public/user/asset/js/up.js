$(document).ready(function () {
    $(".up_button").on("click", function () {
        if (data.auth) {
            $(".up_modal").modal("show");
        } else {
            window.location.href = data.login_route;
        }
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
                resetForm(form);
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
