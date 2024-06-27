$(document).ready(function () {
    $(".up_button").on("click", function () {
        if (data.auth) {
            $(".up_modal").modal("show");
            refreshDeliveryFee();
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

mapboxgl.accessToken = mapbox_token;

//compare able location
const default_longitude = 90.3636733401006;
const default_latitude = 23.806853416250462;

const per_km_charge = 20; //tk
const min_charge = 60; //tk
const miscellaneous_charge = 10; //tk

$(document).ready(function () {
    $(".user_address").each(function (e) {
        get_location($(this).val(), $(this));
    });
});

function get_distance(lng, lat) {
    let userLocation = turf.point([lng, lat]);
    let warehouseLocation = turf.point([default_longitude, default_latitude]);
    let distance = turf.distance(userLocation, warehouseLocation);
    return Math.ceil(distance);
}

function calculate_cost(distance = null) {
    let cost = 0;
    if (distance != null && distance > 0) {
        cost = distance * per_km_charge;
        cost += miscellaneous_charge;
        if (cost < min_charge) {
            cost = min_charge;
        }
    } else {
        cost = min_charge;
    }

    return cost;
}

function get_location(id, target) {
    if (id) {
        let url = data.address_url;
        let _url = url.replace("param", id);
        $.ajax({
            url: _url,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response && Object.keys(response).length > 0) {
                    let distance = get_distance(
                        response.longitude,
                        response.latitude
                    );
                    let cost = numberFormat(calculate_cost(distance));
                    $(target)
                        .closest(".form-check")
                        .find(".delivery_charge")
                        .text(cost);
                    $(target)
                        .closest(".form-check")
                        .find(".delivery_charge")
                        .attr("data-delivery_charge", cost);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching search data:", error);
            },
        });
    }
}

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
                $(".user_delivery_input").val(
                    Math.ceil(parseInt(delivery_fee))
                );
                // if ($(".user_address").is(":checked")) {
                //     $(".up_submit_btn").removeClass("disabled");
                // }
            }, 1500);
        });
    } else {
        delivery_fee = e
            .next("label")
            .find(".delivery_charge")
            .text()
            .replace(",", "");
        $(".user_delivery_input").val(Math.ceil(parseInt(delivery_fee)));
    }
}
$(document).ready(function () {
    $(document).on("change", ".user_address", function () {
        refreshDeliveryFee($(this));
    });
});
