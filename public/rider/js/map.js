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

$(document).ready(function () {
    if (dlat && dlng) {
        const map = initializeMap("map", style, [dlng, dlat], 15);
        addMarker(map, [dlng, dlat]);
        addGeolocateControl(map);
        addNavigationControl(map);

        // const map = new mapboxgl.Map({
        //     container: "map",
        //     style: "mapbox://styles/mapbox/streets-v11",
        //     center: [dlng, dlat],
        //     zoom: 15,
        // });

        // Add geolocation controls to the map
        // var geolocate = new mapboxgl.GeolocateControl({
        //     positionOptions: {
        //         enableHighAccuracy: true,
        //     },
        //     trackUserLocation: true,
        // });
        // map.addControl(geolocate);

        // Define your fixed locations
        var fixedLocation1 = [dlng, dlat]; // replace with your coordinates
        var dlng = 90.36861933352624;
        var dlat = 23.807125501395834;
        var waylng = 90.37115996695525;
        var waylat = 23.806912893559684;

        $.get(
            `https://api.mapbox.com/directions/v5/mapbox/cycling/90.36861933352624,23.807125501395834;90.37115996695525,23.806912893559684?alternatives=true&annotations=distance%2Cduration%2Cspeed%2Ccongestion%2Cmaxspeed&banner_instructions=true&continue_straight=true&geometries=polyline6&language=en&overview=full&roundabout_exits=true&steps=true&voice_instructions=true&voice_units=imperial&access_token=${mapboxgl.accessToken}`,
            (data) => {
                console.log(data);
                map.addLayer({
                    id: "route",
                    type: "line",
                    source: {
                        type: "geojson",
                        data: {
                            type: "Feature",
                            properties: {},
                            geometry: data.routes[0].geometry,
                        },
                    },
                    layout: {
                        "line-join": "round",
                        "line-cap": "round",
                    },
                    paint: {
                        "line-color": "#ff7e5f",
                        "line-width": 8,
                    },
                });
            }
        );

        $(document).on("shown.bs.modal", ".map-modal", function () {
            if (typeof map === "function") {
                map.resize();
            } else {
                console.warn(
                    "Map object (map) not found. Cannot resize the map."
                );
            }
        });
    }
});
