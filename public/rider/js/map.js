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
    const map = initializeMap("map", style, [dlng, dlat], 15);
    addNavigationControl(map);

    map.on("load", function () {
        var directions = new MapboxDirections({
            accessToken: mapboxgl.accessToken,
        });
        map.addControl(directions, "top-left");

        directions.setDestination([flng, flat]);

        // Add geolocate control to the map.
        var geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true,
            },
            trackUserLocation: true,
        });
        map.addControl(geolocate);

        geolocate.on("geolocate", function (position) {
            var userLocation = [
                position.coords.longitude,
                position.coords.latitude,
            ];
            directions.setOrigin(userLocation);
        });

        geolocate.trigger();
    });

    // $(document).on("shown.bs.modal", ".map-modal", function () {
    //     if (typeof map === "function") {
    //         map.resize();
    //     } else {
    //         console.warn("Map object (map) not found. Cannot resize the map.");
    //     }
    // });
});
