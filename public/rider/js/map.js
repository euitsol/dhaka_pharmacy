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

function addCustomPin(type, map, coordinates) {
    if (type == "pharmacy") {
        var pin = pharmacy_pin;
    } else if (type == "rider") {
        var pin = rider_pin;
    } else {
        var pin = user_pin;
    }

    map.loadImage(pin, (error, image) => {
        if (error) throw error;
        map.addImage(type, image);
        map.addSource("point", {
            type: "geojson",
            data: {
                type: "FeatureCollection",
                features: [
                    {
                        type: "Feature",
                        geometry: {
                            type: "Point",
                            coordinates: coordinates,
                        },
                    },
                ],
            },
        });

        map.addLayer({
            id: "points",
            type: "symbol",
            source: "point",
            layout: {
                "icon-image": type,
                "icon-size": 0.15,
            },
        });
    });
}

//For pharmacy directions
$(document).ready(function () {
    const maps = {};
    const mapDirectionModal = "map-direction-modal";
    const mapDirectionMap = "map_direction";
    var directionMap = null;

    $(".pharmacy-location-map").each(function (index) {
        var lng = parseFloat($(this).data("longitude"));
        var lat = parseFloat($(this).data("latitude"));
        var containerId = $(this).attr("id");
        var mapName = "map" + (index + 1);
        let map = initializeMap(containerId, style, [lng, lat], 15);
        addCustomPin("pharmacy", map, [lng, lat]);
        addNavigationControl(map);
        maps[mapName] = map;
    });

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
            addCustomPin("pharmacy", directionMap, [longitude, latitude]);

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
});

//For user directions
$(document).ready(function () {
    const c_maps = {};
    const mapCDirectionModal = "c_map-direction-modal";
    const mapCDirectionMap = "c_map_direction";
    var c_directionMap = null;
    $(".customer-location-map").each(function (index) {
        var lng = parseFloat($(this).data("longitude"));
        var lat = parseFloat($(this).data("latitude"));
        var containerId = $(this).attr("id");
        var mapName = "cmap";
        let map = initializeMap(containerId, style, [lng, lat], 15);
        addCustomPin("user", map, [lng, lat]);
        addNavigationControl(map);
        c_maps[mapName] = map;
    });

    $(".customer-direction-btn").on("click", function () {
        var longitude = $(this).attr("data-longitude");
        var latitude = $(this).attr("data-latitude");

        $("." + mapCDirectionModal).modal("show");

        if (c_directionMap === null) {
            c_directionMap = initializeMap(
                mapCDirectionMap,
                style,
                [dlng, dlat],
                15
            );
        } else {
            c_directionMap.remove();
            c_directionMap = initializeMap(
                mapCDirectionMap,
                style,
                [dlng, dlat],
                15
            );
        }

        c_directionMap.on("load", function () {
            addNavigationControl(c_directionMap);
            var c_direction = new MapboxDirections({
                accessToken: mapboxgl.accessToken,
            });

            c_directionMap.addControl(c_direction, "top-left");
            c_direction.setDestination([longitude, latitude]);
            addCustomPin("user", c_directionMap, [longitude, latitude]);

            var geolocate = new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true,
                },
                trackUserLocation: true,
            });
            c_directionMap.addControl(geolocate);

            geolocate.on("geolocate", function (position) {
                var userLocation = [
                    position.coords.longitude,
                    position.coords.latitude,
                ];
                c_direction.setOrigin(userLocation);
            });
        });
    });

    $("." + mapCDirectionModal).modal({
        backdrop: "static",
        keyboard: false,
    });

    $("." + mapCDirectionModal).on("shown.bs.modal", function () {
        if (c_directionMap !== null) {
            c_directionMap.resize();
        }
    });

    $("." + mapCDirectionModal).on("hidden.bs.modal", function () {
        if (c_directionMap !== null) {
            c_directionMap.remove();
            c_directionMap = null;
        }
    });
});
