mapboxgl.accessToken = mapbox_token;

//compare able location
const default_longitude = 90.3636733401006;
const default_latitude = 23.806853416250462;

const per_km_charge = 20; //tk
const min_charge = 50; //tk
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
                    let cost = calculate_cost(distance);
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
