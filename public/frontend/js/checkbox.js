mapboxgl.accessToken = mapbox_token;

//compare able location
const default_longitude = 90.3636733401006;
const default_latitude = 23.806853416250462;

const per_km_charge = 20; //tk
const min_charge = 60; //tk
const miscellaneous_charge = 10; //tk

$(document).ready(function () {
    $(".address").each(function (e) {
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
        let url = data.details_url;
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
                    $(target).closest(".form-check").find(".charge").text(cost);
                    $(target)
                        .closest(".form-check")
                        .find(".charge")
                        .attr("data-charge", cost);
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
                delivery_fee = $(".address:checked")
                    .next("label")
                    .find(".charge")
                    .text()
                    .replace(",", "");
                $(".delivery_fee").text(
                    numberFormat(Math.ceil(parseInt(delivery_fee)))
                );
                $(".delivery_input").val(Math.ceil(parseInt(delivery_fee)));
                var total_price =
                    parseInt($(".total_price").data("total_price")) +
                    parseInt(delivery_fee);
                total_price = numberFormat(Math.ceil(total_price));
                $(".total_price").text(total_price);

                $(".confirm_button").prop("disabled", false);
            }, 1500);
        });
    } else {
        delivery_fee = e.next("label").find(".charge").text().replace(",", "");
        $(".delivery_fee").text(
            numberFormat(Math.ceil(parseInt(delivery_fee)))
        );
        $(".delivery_input").val(Math.ceil(parseInt(delivery_fee)));
        var total_price =
            parseInt($(".total_price").data("total_price")) +
            parseInt(delivery_fee);
        total_price = numberFormat(Math.ceil(total_price));
        $(".total_price").text(total_price);
    }
}
refreshDeliveryFee();

$(document).ready(function () {
    $(".address").on("change", function () {
        refreshDeliveryFee($(this));
    });
});
