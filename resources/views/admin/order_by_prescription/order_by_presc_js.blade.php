<script>
    let count = 1;

    function renumberItems() {
        $('.item_card').each(function(index) {
            $(this).find('.card-title').text(`Item-${index + 1}`);
            $(this).find('[name^="item["]').each(function() {
                let name = $(this).attr('name');
                let newName = name.replace(/\[\d+\]/, `[${index + 1}]`);
                $(this).attr('name', newName);
            });
        });
        count = $('.item_card').length;
    }

    function getDefault() {
        let medicines = @json($medicines);
        let defaultOptions = medicines.map(function(medicine) {
            return {
                id: medicine.id,
                text: medicine.name
            };
        });
        console.log(defaultOptions);
        return defaultOptions;
    }

    function formatMedicine(medicine) {
        if (medicine.loading) {
            return medicine.text;
        }
        return medicine.name;
    }

    function formatMedicineSelection(medicine) {
        return medicine.name || medicine.text;
    }

    $(document).ready(function() {
        renumberItems();
        $(document).on('click', '.item_add_btn', function() {
            count += 1;
            let result = `
                        <div class="card item_card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <h4 class="card-title">Item-${count}</h4>
                                    </div>
                                    <div class="col-4 text-end">
                                        <a href="javascript:void(0)" style="background:transparent !important;" class="btn btn-outline-danger item_delete_btn text-danger"><i
                                                class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="medicine">Medicine</label>
                                    <select name="item[${count}][medicine]" id="medicine"
                                        class="form-control medicine select-${count}" >
                                        <option value=" " selected hidden>Select Medicine</option>
                                    </select>
                                    @include('alerts.feedback', [
                                        'field' => 'item.*.medicine',
                                    ])
                                </div>
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select name="item[${count}][unit]" id="unit"
                                        class="form-control unit" disabled>
                                        <option value=" " selected hidden>Select Unit</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'item.*.unit'])
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" name="item[${count}][quantity]"
                                            class="form-control"
                                            placeholder="Enter item quantity">
                                    @include('alerts.feedback', ['field' => 'item.*.quantity'])
                                </div>
                            </div>
                        </div>
                        `;
            $('#my_product').append(result);
            $('.invalid-feedback').remove();
            $('.select-' + count).select2({
                data: getDefault(),
                ajax: {
                    url: `{{ route('obp.get_select_medicine.obp_details') }}`,
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            param: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                templateResult: formatMedicine,
                templateSelection: formatMedicineSelection
            });
        });

        $(document).on('click', '.item_delete_btn', function() {
            $(this).closest('.item_card').remove();
            renumberItems();
        });
    });

    $(document).on('change', '.medicine', function() {
        let id = $(this).val();
        console.log(id);
        if (id === null || id === '') {
            $(this).parent().next('.form-group').find('.unit').html(
                '<option value=" " selected hidden>Select Unit</option>');
            $(this).parent().next('.form-group').find('.unit').prop('disabled', true);
        } else {
            let url = `{{ route('obp.get_unit.obp_details', 'param') }}`;
            let _url = url.replace('param', id);
            let element = $(this);
            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let result = '';
                    data.units.forEach(function(unit) {
                        result +=
                            `<option value="${unit.id}">${unit.name+'-('+unit.quantity+')'}</option>`;
                    });
                    element.parent().next('.form-group').find('.unit').prop('disabled', false)
                    element.parent().next('.form-group').find('.unit').html(result);
                    element.parent().next('.form-group').find('.unit').select2({});
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching unit data:', error);
                }
            });
        }
    });

    $(document).ready(function() {
        $('.medicine').select2({
            data: getDefault(),
            ajax: {
                url: `{{ route('obp.get_select_medicine.obp_details') }}`,
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    return {
                        param: params.term // search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            templateResult: formatMedicine,
            templateSelection: formatMedicineSelection
        });
    });
</script>
