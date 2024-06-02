//compare able location

$(document).ready(function () {
    const location = filter_address($(".user-location").attr("data-location"));
    if (location) {
        modifyOptions(location);
    }
});

function get_distance(pharmacyLocation, userLocation) {
    userLocation = turf.point(userLocation);
    pharmacyLocation = turf.point(pharmacyLocation);
    let distance = turf.distance(userLocation, pharmacyLocation);
    return distance;
}

function filter_address(location) {
    if (location) {
        const coordinates = location
            .substring(1, location.length - 1)
            .split(",")
            .map(parseFloat);
        if (!isNaN(coordinates[0]) && !isNaN(coordinates[1])) {
            return coordinates;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function modifyOptions(userLocation) {
    $(".pharmacies option").each(function () {
        const location = filter_address($(this).attr("data-location"));
        const originalText = $(this).text();
        let addedText = 0;
        if (location && userLocation) {
            addedText = get_distance(location, userLocation);

            const modifiedText =
                originalText + " (" + addedText.toFixed(2) + " km )";
            $(this).text(modifiedText);
        }
    });
}
