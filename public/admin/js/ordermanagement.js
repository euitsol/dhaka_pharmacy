$(document).ready(() => {
    let rowCounter = 0;

    const createSelect2 = (options) => ({
        placeholder: options.placeholder,
        allowClear: true,
        ajax: {
            url: options.url,
            dataType: 'json',
            delay: 250,
            data: (params) => ({ q: params.term }),
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            },
            cache: true,
            ...(options.minInput ? { minimumInputLength: 1 } : {})
        }
    });

    const createSuggestionBox = (searchInput) => {
        const $suggestionBox = $('<div>', {
            class: 'suggestion-box p-2 pb-0',
            style: 'display: none; position: absolute; background: white; border: 1px solid #ddd; z-index: 1000; width: 100%; max-height: 15rem; overflow-y: auto;'
        });
        $(searchInput).after($suggestionBox);
        return $suggestionBox;
    };

    const initMedicineSearch = ($row) => {
        const $searchWrapper = $('<div>', { class: 'position-relative' });
        const $searchInput = $('<input>', {
            type: 'text',
            class: 'form-control medicine-search',
            placeholder: 'Search medicine...',
            autocomplete: 'off'
        });
        const $medicineIdInput = $('<input>', {
            type: 'hidden',
            class: 'medicine-id medicine-data',
            name: 'medicine_id[]'
        });

        $row.find('.medicine-select').replaceWith($searchWrapper);
        $searchWrapper.append($searchInput, $medicineIdInput);

        const $suggestionBox = createSuggestionBox($searchInput);

        let searchTimeout;

        $searchInput.on('input', function() {
            const searchTerm = $(this).val();
            clearTimeout(searchTimeout);

            if (searchTerm.length < 2) {
                $suggestionBox.hide();
                return;
            }

            searchTimeout = setTimeout(() => {
                $.ajax({
                    url: window.AppConfig.urls.obp.product_search,
                    data: { q: searchTerm },
                    success: (response) => {
                        console.log(response.items);

                        const suggestions = response.items.map(item => `
                            <div class="suggestion-item p-2 cursor-pointer"
                                data-id="${item.id}"
                                data-units='${btoa(JSON.stringify(item.units))}'
                                data-price="${item.price}"
                                data-discountpercentage="${item.discount_percentage || 0}"
                                data-discountedprice="${item.discounted_price || 0}"
                            >
                                <div class="fw-bold">${item.name}</div>
                                <small> Category: ${item.pro_cat?.name || ''} |</small>
                                <small> Generic: ${item.generic?.name || ''} | </small>
                                <small> Strength: ${item.strength?.name || ''} |</small>
                                <small> Dosage: ${item.dosage?.name || ''} |</small>
                                <small> Company: ${item.company?.name || ''} | </small><br>
                                <small>Price: ${item.discount_percentage > 0 ? `<del>${item.price} BDT</del> ${item.discounted_price} BDT` : `${item.price} BDT`}</small>
                            </div>
                        `).join('');
                        $suggestionBox.html(suggestions || '<div class="p-2">No results found</div>').show();
                    }
                });
            }, 300);
        });

        $suggestionBox.on('click', '.suggestion-item', function() {
            const $this = $(this);
            console.log($this.data('discountpercentage'));
            $medicineIdInput
                .val($this.data('id'))
                .data({
                    price: $this.data('price'),
                    discountpercentage: $this.data('discountpercentage')
                });

            $searchInput.val($this.find('.fw-bold').text());
            $suggestionBox.hide();

            const units = JSON.parse(atob($this.data('units')));
            const $unitSelect = $row.find('.unit-select').empty().append('<option value="">Select Unit</option>');
            const discountPercentage = parseFloat($this.data('discountpercentage')) || 0;
            units.forEach(unit => {
                $unitSelect.append($('<option>', {
                    value: unit.id,
                    text: `${discountPercentage > 0 ? `${unit.pivot.price} BDT - Discounted: ${unit.pivot.price - (unit.pivot.price * (discountPercentage / 100))} BDT` : `${unit.pivot.price} BDT`}`,
                    'data-price': unit.pivot.price
                }));
            });
        });

        $(document).on('click', e => {
            if (!$(e.target).closest('.position-relative').length) $suggestionBox.hide();
        });
    };

    const pricingUpdates = () => {
        let totalAmount = 0, productDiscount = 0;

        $('#medicine-order-table tbody tr').each(function() {
            const $row = $(this);
            const unitPrice = parseFloat($row.find('.unit-select option:selected').data('price')) || 0;
            const quantity = parseFloat($row.find('.quantity-input').val()) || 0;
            const $medicineInput = $row.find('.medicine-id');

            // Validate inputs
            if (!unitPrice || quantity < 1) return;

            const discountPercentage = parseFloat($medicineInput.data('discountpercentage')) || 0;
            console.log(discountPercentage);

            let discountPerUnit = 0;
            if (discountPercentage > 0) {
                discountPerUnit = unitPrice * (discountPercentage / 100);
            }

            console.log(discountPerUnit);

            totalAmount += unitPrice * quantity;
            productDiscount += discountPerUnit * quantity;
        });

        const subTotal = totalAmount - productDiscount;
        const voucherDiscount = parseFloat($('#voucher-discount').text()) || 0;
        const deliveryCharge = parseFloat($('#delivery-charge').text()) || 0;
        const payableAmount = subTotal - voucherDiscount + deliveryCharge;

        $('#total-amount').text(totalAmount.toFixed(2));
        $('#product-discount').text(productDiscount.toFixed(2));
        $('#sub-total-amount').text(subTotal.toFixed(2));
        $('#payable-amount').text(payableAmount.toFixed(2));
    };

    const bindPricingEvents = ($row) => {
        $row.find('.unit-select, .quantity-input').on('change input', pricingUpdates);
    };

    const addNewRow = () => {
        rowCounter++;
        const newRow = `
            <tr data-row-id="${rowCounter}">
                <td>${rowCounter}</td>
                <td><div class="medicine-select"></div></td>
                <td>
                    <select class="form-control unit-select" required>
                        <option value="">Select Unit</option>
                    </select>
                </td>
                <td><input type="number" class="form-control quantity-input" min="1" required></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button></td>
            </tr>`;

        $('#medicine-order-table tbody').append(newRow);
        const $newRow = $(`tr[data-row-id="${rowCounter}"]`);
        initMedicineSearch($newRow);
        bindPricingEvents($newRow);
        pricingUpdates();
    };

    $(document)
        .on('click', '#add-medicine-row', addNewRow)
        .on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            pricingUpdates();
        });

    addNewRow(); // Initial row
});
