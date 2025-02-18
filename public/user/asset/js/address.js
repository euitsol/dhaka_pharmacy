$(document).ready(function () {
    $('.select2').select2();
    $('#city_select').select2({
        placeholder: 'Select City',
        allowClear: true,
        searchable: true,
        ajax: {
            url: routes.city_search,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function(city) {
                        return {
                            id: city.city_name,
                            text: city.city_name
                        };
                    })
                };
            },
            cache: true
        }
    });
})
