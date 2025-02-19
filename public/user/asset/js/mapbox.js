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
    const lat = $("#user_d_map").attr("data-lat");
    const lng = $("#user_d_map").attr("data-lng");

    if (lat && lng) {
        const map = initializeMap("user_d_map", style, [lng, lat], 15);
        addMarker(map, [lng, lat]);
    }
});

// //Add new address
// $(document).ready(function () {
//     const map = initializeMap("user_a_map", style, [dlng, dlat], 15);
//     initializeGeocode(map);
//     clickNautofill(map, null, "#address_add_modal");
//     addGeolocateControl(map);
//     addNavigationControl(map);

//     $("#address_add_modal").on("shown.bs.modal", function () {
//         map.resize();
//     });
//     $(".address-modal .close").on("click", function () {
//         $("#address_add_modal").modal("hide");
//     });
// });

// //Address Details
// $(document).ready(function () {
//     const maps = {};

//     $(".my-map").each(function (index) {
//         const lng = parseFloat($(this).data("lng"));
//         const lat = parseFloat($(this).data("lat"));
//         const containerId = $(this).attr("id");
//         const mapName = "map" + (index + 1);
//         let map = initializeMap(containerId, style, [lng, lat], 15);
//         addMarker(map, [lng, lat]);
//         addNavigationControl(map);
//         maps[mapName] = map;
//     });

//     $("#accordion").on("shown.bs.collapse", function (e) {
//         let count = $(e.target).attr("data-count");
//         const mapName = "map" + (parseInt(count) + 1);
//         if (maps[mapName]) {
//             maps[mapName].resize();
//         }
//     });
// });

// //Edit Address
// $(document).ready(function () {
//     if ($("#city_select")) {
//         $("#city_select").select2({
//             placeholder: "Select City",
//             allowClear: true,
//             searchable: true,
//             ajax: {
//                 url: routes.city_search,
//                 dataType: "json",
//                 delay: 250,
//                 processResults: function (data) {
//                     return {
//                         results: $.map(data, function (item) {
//                             return {
//                                 text: item.name,
//                                 id: item.name,
//                             };
//                         }),
//                     };
//                 },
//             },
//         });
//     }

//     $(".edit-btn").on("click", function () {
//         let id = $(this).attr("data-id");
//         if (id) {
//             let url = data.details_url;
//             let _url = url.replace("param", id);
//             $.ajax({
//                 url: _url,
//                 method: "GET",
//                 dataType: "json",
//                 success: function (response) {
//                     if (response && Object.keys(response).length > 0) {
//                         $("#address_edit_modal input[name='id']").val(
//                             response.id
//                         );
//                         // $("#address_edit_modal input[name='lat']").val(
//                         //     response.latitude
//                         // );
//                         // $("#address_edit_modal input[name='long']").val(
//                         //     response.longitude
//                         // );
//                         $("#address_edit_modal input[name='address']").val(
//                             response.address
//                         );
//                         $("#address_edit_modal input[name='city']").val(
//                             response.city
//                         );
//                         $("#address_edit_modal input[name='street']").val(
//                             response.street_address
//                         );
//                         $("#address_edit_modal input[name='apartment']").val(
//                             response.apartment
//                         );
//                         $("#address_edit_modal input[name='floor']").val(
//                             response.floor
//                         );
//                         $("#address_edit_modal input[name='instruction']").val(
//                             response.delivery_instruction
//                         );
//                         if (response.is_default == 1) {
//                             $(
//                                 "#address_edit_modal input[name='is_default']"
//                             ).prop("checked", true);
//                         }

//                         // let map = initializeMap(
//                         //     "user_e_map",
//                         //     style,
//                         //     [response.longitude, response.latitude],
//                         //     15
//                         // );
//                         // let marker = addMarker(map, [
//                         //     response.longitude,
//                         //     response.latitude,
//                         // ]);

//                         // initializeGeocode(map);
//                         // clickNautofill(map, marker, "#address_edit_modal");
//                         // addGeolocateControl(map);
//                         // addNavigationControl(map);

//                         $("#address_edit_modal").on(
//                             "shown.bs.modal"
//                             // function () {
//                             //     map.resize();
//                             // }
//                         );
//                         $(".address-edit-modal .close").on(
//                             "click",
//                             function () {
//                                 $("#address_edit_modal").modal("hide");
//                             }
//                         );

//                         $("#address_edit_modal").modal("show");
//                     } else {
//                         console.log("Empty or invalid data received");
//                     }
//                 },
//                 error: function (xhr, status, error) {
//                     console.error("Error fetching search data:", error);
//                 },
//             });
//         }
//     });
// });
