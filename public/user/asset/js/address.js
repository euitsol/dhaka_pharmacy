// $(document).ready(function () {
//     $(".select2").select2();
//     $(".city_select").select2({
//         placeholder: "Select City",
//         allowClear: true,
//         searchable: true,
//         ajax: {
//             url: routes.city_search,
//             dataType: "json",
//             delay: 250,
//             data: function (params) {
//                 return {
//                     q: params.term,
//                 };
//             },
//             processResults: function (data) {
//                 return {
//                     results: data.map(function (city) {
//                         return {
//                             id: city.city_name,
//                             text: city.city_name,
//                         };
//                     }),
//                 };
//             },
//             cache: true,
//         },
//     });
// });

// Address Modal Js
function initializeCitySelect2(dropdownParentId, selectedData = null) {
    $(".city_select").select2({
        dropdownParent: $(dropdownParentId), // Ensure dropdown appears within modal
        placeholder: "Select City",
        allowClear: true,
        ajax: {
            url: routes.city_search,
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (city) {
                        return {
                            id: city.city_name,
                            text: city.city_name,
                        };
                    }),
                };
            },
            cache: true,
        },
    });
    if (selectedData) {
        let cityOption = new Option(selectedData, selectedData, true, true);
        $(".city_select").append(cityOption).trigger("change");
    } else {
        $(".city_select").val(null).trigger("change");
    }
}
$(document).ready(function () {
    $("#address_add_modal").on("shown.bs.modal", function () {
        initializeCitySelect2("#address_add_modal");
    });

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
                        $("#address_edit_modal input[name='address']").val(
                            response.address
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
                        if (response.is_default == 1) {
                            $(
                                "#address_edit_modal input[name='is_default']"
                            ).prop("checked", true);
                        }
                        $("#address_edit_modal").modal("show");
                        initializeCitySelect2(
                            "#address_edit_modal",
                            response.city
                        );
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
