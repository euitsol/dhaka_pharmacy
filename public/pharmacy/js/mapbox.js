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

        fetch(
            `https://api.mapbox.com/geocoding/v5/mapbox.places/${e.lngLat.lng},${e.lngLat.lat}.json?access_token=${mapboxgl.accessToken}`
        )
            .then((response) => response.json())
            .then((data) => {
                const address = data.features[0].place_name;
                const [street, city] = address.split(", ");

                // Autofill the input fields
                $(parentID + ' input[name="address"]').val(address);
                $(parentID + ' input[name="street"]').val(street);
                $(parentID + ' input[name="city"]').val(city);
            });

        $(parentID + ' input[name="lat"]').val(e.lngLat.lat);
        $(parentID + ' input[name="long"]').val(e.lngLat.lng);
    });
}

//Dashboard
$(document).ready(function () {
    const lat = $("#map").attr("data-lat");
    const lng = $("#map").attr("data-lng");

    if (lat && lng) {
        const map = initializeMap("map", style, [lng, lat], 15);
        addMarker(map, [lng, lat]);
        addNavigationControl(map);
    } else {
        const map = initializeMap("map", style, [dlng, dlat], 15);
        initializeGeocode(map);
        clickNautofill(map, null, ".map-card");
        addGeolocateControl(map);
        addNavigationControl(map);
    }
});
