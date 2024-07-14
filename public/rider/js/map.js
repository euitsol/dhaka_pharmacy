mapboxgl.accessToken = mapbox_token;
if (!mapboxgl.supported()) {
    alert(
        "Your browser does not support Mapbox. Please use a different browser"
    );
}

// const style = "mapbox://styles/qwaszx342432/clwjxz6ta007c01pogy8u4y4t";
const style = "mapbox://styles/mapbox/streets-v9";
const dlng = 90.36861933352624;
const dlat = 23.807125501395834;
const flng = 90.37115996695525;
const flat = 23.806912893559684;

function initializeMap(container, style, center, zoom) {
    return new mapboxgl.Map({
        container: container,
        style: style,
        center: center,
        zoom: zoom,
    });
}

function initializeGeocode(map) {
    let geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        marker: false,
        placeholder: "Search for your address",
    });
    map.addControl(geocoder);
}

function addMarker(map, center) {
    return new mapboxgl.Marker().setLngLat(center).addTo(map);
}

function addGeolocateControl(map) {
    map.addControl(
        new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true,
            },
            trackUserLocation: true,
            fitBoundsOptions: {
                maxZoom: 20,
            },
        })
    );
}

function addNavigationControl(map) {
    map.addControl(new mapboxgl.NavigationControl(), "top-right");
}

$(document).ready(function () {
    const maps = {};
    const mapDirectionModal = "map-direction-modal";
    const mapDirectionMap = "map_direction";
    var directionMap = null;

    $(".pharmacy-location-map").each(function (index) {
        const lng = parseFloat($(this).data("longitude"));
        const lat = parseFloat($(this).data("latitude"));
        const containerId = $(this).attr("id");
        const mapName = "map" + (index + 1);
        let map = initializeMap(containerId, style, [lng, lat], 15);
        addMarker(map, [lng, lat]);
        addNavigationControl(map);
        maps[mapName] = map;
    });

    console.log(maps);

    $(".pharmacy-direction-btn").on("click", function () {
        var longitude = $(this).attr("data-longitude");
        var latitude = $(this).attr("data-latitude");

        $("." + mapDirectionModal).modal("show");

        if (directionMap === null) {
            directionMap = initializeMap(
                mapDirectionMap,
                style,
                [dlng, dlat],
                15
            );
        } else {
            directionMap.remove();
            directionMap = initializeMap(
                mapDirectionMap,
                style,
                [dlng, dlat],
                15
            );
        }

        directionMap.on("load", function () {
            addNavigationControl(directionMap);
            var direction = new MapboxDirections({
                accessToken: mapboxgl.accessToken,
            });

            directionMap.addControl(direction, "top-left");
            direction.setDestination([longitude, latitude]);

            var geolocate = new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true,
                },
                trackUserLocation: true,
            });
            directionMap.addControl(geolocate);

            geolocate.on("geolocate", function (position) {
                var userLocation = [
                    position.coords.longitude,
                    position.coords.latitude,
                ];
                direction.setOrigin(userLocation);
            });
        });
    });

    $(".map-direction-modal").modal({
        backdrop: "static",
        keyboard: false,
    });

    $("." + mapDirectionModal).on("shown.bs.modal", function () {
        if (directionMap !== null) {
            directionMap.resize();
        }
    });

    $("." + mapDirectionModal).on("hidden.bs.modal", function () {
        if (directionMap !== null) {
            directionMap.remove();
            directionMap = null;
        }
    });
    // const map = initializeMap("map", style, [dlng, dlat], 15);
    // addNavigationControl(map);

    // map.on("load", function () {
    //     var directionsInstances = [];
    //     pharmacyLocations.forEach((element, index) => {
    // var directionsKey = "directions_" + index;
    // directionsInstances[directionsKey] = new MapboxDirections({
    //     accessToken: mapboxgl.accessToken,
    // });
    // map.addControl(directionsInstances[directionsKey], "top-left");
    // directionsInstances[directionsKey].setDestination([
    //     element.longitude,
    //     element.latitude,
    // ]);
    // });

    // Add geolocate control to the map.
    // var geolocate = new mapboxgl.GeolocateControl({
    //     positionOptions: {
    //         enableHighAccuracy: true,
    //     },
    //     trackUserLocation: true,
    // });
    // map.addControl(geolocate);

    // geolocate.on("geolocate", function (position) {
    //     var userLocation = [
    //         position.coords.longitude,
    //         position.coords.latitude,
    //     ];
    //     for (var key in directionsInstances) {
    //         if (directionsInstances.hasOwnProperty(key)) {
    //             directionsInstances[key].setOrigin(userLocation);
    //         }
    //     }
    // });

    // geolocate.trigger();
    // });

    // $(document).on("shown.bs.modal", ".map-modal", function () {
    //     if (typeof map === "function") {
    //         map.resize();
    //     } else {
    //         console.warn("Map object (map) not found. Cannot resize the map.");
    //     }
    // });
});
