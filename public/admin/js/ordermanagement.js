$(document).ready(() => {
    let rowCounter = 0;

    const createAddressSelect2 = (options) => ({
        placeholder: options.placeholder,
        allowClear: true,
        language: {
            noResults: function() {
                return 'No address found, Please add a new address.';
            }
        },
        ajax: {
            url: options.url,
            dataType: 'json',
            delay: 250,
            data: (params) => ({ q: params.term, data: options.data }),
            processResults: function(data) {
                const items = Array.isArray(data.addresses) ? data.addresses : [];
                return {
                    results: items.map(function(item) {
                        return {
                            id: item.id,
                            text: item.name,
                            options: item.options
                        };
                    })
                };
            },
            cache: true,
            ...(options.minInput ? { minimumInputLength: 1 } : {})
        }
    });

    const select2Config = {
        delivery_address: createAddressSelect2({
            placeholder: 'Select Delivery Address',
            url: window.AppConfig.urls.obp.delivery_address,
            minInput: true,
            data: {
                'user_id': $('#user_id').val()
            },
        }),
    };

    const createSuggestionBox = (searchInput) => {
        const $suggestionBox = $('<div>', {
            class: 'suggestion-box p-2 pb-0',
            style: 'display: none; position: absolute; background: white; border: 1px solid #ddd; z-index: 1000; width: 100%; max-height: 15rem; overflow-y: auto;'
        });
        $(searchInput).after($suggestionBox);
        return $suggestionBox;
    };

    const initMedicineSearch = ($row) => {
        const $searchInput = $row.find('.medicine-search');
        const $suggestionBox = createSuggestionBox($searchInput);
        const $medicineIdInput = $row.find('.medicine-id');
        const $unitSelect = $row.find('.unit-select');

        let searchTimeout;

        $searchInput.on('input', function() {
            const query = $(this).val();
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                $suggestionBox.hide();
                return;
            }

            searchTimeout = setTimeout(() => {
                $.get(window.AppConfig.urls.obp.product_search, { q: query })
                    .done((data) => {
                        $suggestionBox.empty();
                        data.forEach(medicine => {
                            const $item = $('<div>', {
                                class: 'suggestion-item p-2 border-bottom cursor-pointer',
                                text: medicine.name
                            }).data('medicine', medicine);

                            $item.hover(
                                function() { $(this).addClass('bg-light'); },
                                function() { $(this).removeClass('bg-light'); }
                            );

                            $suggestionBox.append($item);
                        });
                        $suggestionBox.show();
                    });
            }, 300);
        });

        $(document).on('click', '.suggestion-item', function() {
            const medicine = $(this).data('medicine');
            $searchInput.val(medicine.name);
            $medicineIdInput.val(medicine.id);

            // Update unit select options
            $unitSelect.empty().append('<option value="">Select Unit</option>');
            medicine.units.forEach(unit => {
                $unitSelect.append(`<option value="${unit.id}" data-price="${unit.price}">${unit.name}</option>`);
            });

            $suggestionBox.hide();
            updateRowTotal($row);
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.suggestion-box, .medicine-search').length) {
                $suggestionBox.hide();
            }
        });
    };

    const updateRowTotal = ($row) => {
        const quantity = parseInt($row.find('.quantity').val()) || 0;
        const selectedUnit = $row.find('.unit-select option:selected');
        const price = parseFloat(selectedUnit.data('price')) || 0;

        const total = quantity * price;
        $row.find('.unit-price').text(price.toFixed(2));
        $row.find('.total-price').text(total.toFixed(2));

        updateOrderTotals();
    };

    const updateOrderTotals = () => {
        let totalAmount = 0;
        $('.medicine-row').each(function() {
            totalAmount += parseFloat($(this).find('.total-price').text()) || 0;
        });

        const deliveryCharge = parseFloat($('#delivery-charge').val()) || 0;
        const grandTotal = totalAmount + deliveryCharge;

        $('#total-amount').text(totalAmount.toFixed(2));
        $('input[name="total_amount"]').val(totalAmount.toFixed(2));
        $('#delivery-charge-display').text(deliveryCharge.toFixed(2));
        $('#grand-total').text(grandTotal.toFixed(2));
    };

    const bindPricingEvents = ($row) => {
        $row.find('.unit-select, .quantity').on('change', function() {
            updateRowTotal($row);
        });
    };

    const addNewRow = () => {
        rowCounter++;
        const $newRow = $('.medicine-row').first().clone();

        // Clear values
        $newRow.find('input:not([type="hidden"])').val('');
        $newRow.find('select').empty().append('<option value="">Select Unit</option>');
        $newRow.find('.unit-price, .total-price').text('0.00');

        // Update name attributes
        $newRow.find('[name]').each(function() {
            const name = $(this).attr('name').replace('[0]', `[${rowCounter}]`);
            $(this).attr('name', name);
        });

        $('#medicine-order-table tbody').append($newRow);
        initMedicineSearch($newRow);
        bindPricingEvents($newRow);
    };

    // Initialize first row
    initMedicineSearch($('.medicine-row').first());
    bindPricingEvents($('.medicine-row').first());

    // Initialize delivery address select2
    $('#delivery-address').select2(select2Config.delivery_address);

    // Event Handlers
    $(document)
        .on('click', '#add-medicine-row', addNewRow)
        .on('click', '.remove-row', function() {
            if ($('.medicine-row').length > 1) {
                $(this).closest('tr').remove();
                updateOrderTotals();
            }
        });

    $('#delivery-address').on('select2:select', function(e) {
        const selectedData = e.params.data;
        const deliveryOptions = selectedData.options || [];
        const $deliveryTypeSelect = $('#delivery-type');

        $deliveryTypeSelect.empty().append('<option value="">Select Delivery Type</option>');

        deliveryOptions.forEach(function(option) {
            const optionText = `${option.name} - Charge: ${option.charge}, Delivery Time: ${option.delivery_time_hours} hrs`;
            $deliveryTypeSelect.append(
                $('<option>', {
                    value: option.type,
                    text: optionText,
                    'data-charge': option.charge,
                })
            );
        });

        $deliveryTypeSelect.prop('disabled', false);
    });

    $('#delivery-type').on('change', function() {
        const charge = parseFloat($(this).find('option:selected').data('charge')) || 0;
        $('#delivery-charge').val(charge);
        updateOrderTotals();
    });

    // Form submission
    $('#prescription-order-form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');

        // Disable submit button
        $submitBtn.prop('disabled', true);

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (response.status == true) {
                    toastr.success(response.message);
                    $('#prescription-order-form').modal('hide');
                    $submitBtn.prop('disabled', false);
                } else {
                    toastr.error(response.message || 'An error occurred');
                    $('#prescription-order-form').modal('hide');
                    $submitBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.message) {
                    toastr.error(response.message);
                } else {
                    toastr.error('An error occurred while processing your request');
                }

                $submitBtn.prop('disabled', false);
            }
        });
    });
});
