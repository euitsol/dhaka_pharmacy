mapboxgl.accessToken = mapbox_token;
if (!mapboxgl.supported()) {
    alert(
        "Your browser does not support Mapbox. Please use a different browser"
    );
}

// const style = "mapbox://styles/qwaszx342432/clwjxz6ta007c01pogy8u4y4t";
const style = mapbox_style_id;
const dlng = map_center[1];
const dlat = map_center[2];

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
    map.addControl(new mapboxgl.NavigationControl(), "top-left");
}

function clickNautofill(map, marker, parentID) {
    // Responsible for marking a pointer and autofill the data
    map.on("click", function (e) {
        if (marker) {
            marker.remove();
        }

        marker = addMarker(map, e.lngLat);
        $("#center_location_lat").val(e.lngLat.lat);
        $("#center_location_lng").val(e.lngLat.lng);
    });
}

//Dashboard
$(document).ready(function () {
    const map = initializeMap("my_map", style, [dlng, dlat], 15);
    initializeGeocode(map);
    clickNautofill(map, null);
    addGeolocateControl(map);
    addNavigationControl(map);
});
