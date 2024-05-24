const style = "mapbox://styles/qwaszx342432/clwjxz6ta007c01pogy8u4y4t";

$(document).ready(function () {
    mapboxgl.accessToken = mapbox_token;
    if (!mapboxgl.supported()) {
        alert(
            "Your browser does not support Mapbox. Please use a different browser"
        );
    }

    const lat1 = $("#user_d_map").attr("data-lat");
    const lng1 = $("#user_d_map").attr("data-lng");

    if (lat1 && lng1) {
        const map1 = new mapboxgl.Map({
            container: "user_d_map", // container ID
            style: style, // style URL
            center: [lng1, lat1], // starting position [lng, lat]
            zoom: 15, // starting zoom
        });

        const marker1 = new mapboxgl.Marker() // initialize a new marker
            .setLngLat([lng1, lat1]) // Marker [lng, lat] coordinates
            .addTo(map1); // Add the marker to the map
    }

    const map2 = new mapboxgl.Map({
        container: "user_a_map", // container ID
        style: style, // style URL
        center: [90.36861933352624, 23.807125501395834],
        zoom: 10, // starting zoom
    });

    const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken, // Set the access token
        mapboxgl: mapboxgl, // Set the mapbox-gl instance
        marker: false, // Do not use the default marker style
        placeholder: "Search for your address",
    });

    map2.addControl(geocoder);

    let marker2;

    map2.on("click", function (e) {
        if (marker2) {
            // Check if the marker exists before trying to remove it
            marker2.remove();
        }

        marker2 = new mapboxgl.Marker().setLngLat(e.lngLat).addTo(map2);

        // Fetch the address for the clicked location
        fetch(
            `https://api.mapbox.com/geocoding/v5/mapbox.places/${e.lngLat.lng},${e.lngLat.lat}.json?access_token=${mapboxgl.accessToken}`
        )
            .then((response) => response.json())
            .then((data) => {
                const address = data.features[0].place_name;
                console.log(address);

                const [street, city] = address.split(", ");

                // Autofill the input fields
                $('[name="address"]').val(address);
                $('[name="street"]').val(street);
                $('[name="city"]').val(city);
            });

        $('[name="lat"]').val(e.lngLat.lat);
        $('[name="long"]').val(e.lngLat.lng);

        console.log(`Longitude: ${e.lngLat.lng}, Latitude: ${e.lngLat.lat}`);
    });
    // Add a button to track the user's current location
    map2.addControl(
        new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true,
            },
            trackUserLocation: true,
            fitBoundsOptions: {
                maxZoom: 22, // Set the maximum zoom level when panning to the user's location
            },
        })
    );

    map2.addControl(new mapboxgl.NavigationControl(), "top-left");

    $("#address_modal").on("shown.bs.modal", function () {
        map2.resize();
    });
    $(".address-modal .close").on("click", function () {
        $("#address_modal").modal("hide");
    });
});

$(document).ready(function () {
    const maps = {};

    $(".my-map").each(function (index) {
        const lng = parseFloat($(this).data("lng"));
        const lat = parseFloat($(this).data("lat"));
        const containerId = $(this).attr("id");
        const mapName = "map" + (index + 1);
        let map = new mapboxgl.Map({
            container: containerId,
            style: style,
            center: [lng, lat],
            zoom: 10,
        });
        const marker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);
        maps[mapName] = map;
    });

    $("#accordion").on("shown.bs.collapse", function (e) {
        let count = $(e.target).attr("data-count");
        const mapName = "map" + (parseInt(count) + 1);
        if (maps[mapName]) {
            maps[mapName].resize();
        }
    });
});

//Details
$(document).ready(function () {
    $(".edit-btn").on("click", function () {
        let id = $(this).attr("data-id");
        if (id) {
            let url = data.details_url;
            let _url = url.replace("param", id);
            $.ajax({
                url: _url,
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response && Object.keys(response).length > 0) {
                        $("#address_edit_modal input[name='id']").val(
                            response.id
                        );
                        $("#address_edit_modal input[name='lat']").val(
                            response.latitude
                        );
                        $("#address_edit_modal input[name='long']").val(
                            response.longitude
                        );
                        $("#address_edit_modal input[name='address']").val(
                            response.address
                        );
                        $("#address_edit_modal input[name='city']").val(
                            response.city
                        );
                        $("#address_edit_modal input[name='street']").val(
                            response.street_address
                        );
                        $("#address_edit_modal input[name='apartment']").val(
                            response.apartment
                        );
                        $("#address_edit_modal input[name='floor']").val(
                            response.floor
                        );
                        $("#address_edit_modal input[name='instruction']").val(
                            response.delivery_instruction
                        );

                        let map = new mapboxgl.Map({
                            container: "user_e_map",
                            style: style,
                            center: [response.longitude, response.latitude],
                            zoom: 15,
                        });
                        let cmarker = new mapboxgl.Marker()
                            .setLngLat([response.longitude, response.latitude])
                            .addTo(map);

                        const geocoder = new MapboxGeocoder({
                            accessToken: mapboxgl.accessToken, // Set the access token
                            mapboxgl: mapboxgl, // Set the mapbox-gl instance
                            marker: false, // Do not use the default marker style
                            placeholder: "Search for your address",
                        });

                        map.addControl(geocoder);

                        map.on("click", function (e) {
                            if (cmarker) {
                                cmarker.remove();
                            }

                            cmarker = new mapboxgl.Marker()
                                .setLngLat(e.lngLat)
                                .addTo(map);

                            // Fetch the address for the clicked location
                            fetch(
                                `https://api.mapbox.com/geocoding/v5/mapbox.places/${e.lngLat.lng},${e.lngLat.lat}.json?access_token=${mapboxgl.accessToken}`
                            )
                                .then((response) => response.json())
                                .then((data) => {
                                    const address = data.features[0].place_name;
                                    console.log(address);

                                    const [street, city] = address.split(", ");

                                    // Autofill the input fields
                                    $(
                                        '#address_edit_modal input[name="address"]'
                                    ).val(address);
                                    $(
                                        '#address_edit_modal input[name="street"]'
                                    ).val(street);
                                    $(
                                        '#address_edit_modal input[name="city"]'
                                    ).val(city);
                                });

                            $('#address_edit_modal input[name="lat"]').val(
                                e.lngLat.lat
                            );
                            $('#address_edit_modal input[name="long"]').val(
                                e.lngLat.lng
                            );

                            console.log(
                                `Longitude: ${e.lngLat.lng}, Latitude: ${e.lngLat.lat}`
                            );
                        });
                        // Add a button to track the user's current location
                        map.addControl(
                            new mapboxgl.GeolocateControl({
                                positionOptions: {
                                    enableHighAccuracy: true,
                                },
                                trackUserLocation: true,
                                fitBoundsOptions: {
                                    maxZoom: 22, // Set the maximum zoom level when panning to the user's location
                                },
                            })
                        );

                        map.addControl(
                            new mapboxgl.NavigationControl(),
                            "top-left"
                        );

                        $("#address_edit_modal").on(
                            "shown.bs.modal",
                            function () {
                                map.resize();
                            }
                        );
                        $(".address-edit-modal .close").on(
                            "click",
                            function () {
                                $("#address_edit_modal").modal("hide");
                            }
                        );

                        $("#address_edit_modal").modal("show");
                    } else {
                        console.log("Empty or invalid data received");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching search data:", error);
                },
            });
        }
    });
});
