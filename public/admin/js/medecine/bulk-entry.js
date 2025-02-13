$(document).ready(() => {
    let rowCounter = 0

    // Select2 template for cloning
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

    // Configure all Select2 types
    const select2Config = {
        generic: createSelect2({
            placeholder: 'Select Generic Name',
            url: window.AppConfig.urls.product.generics,
            minInput: true
        }),
        category: createSelect2({
            placeholder: 'Select Category',
            url: window.AppConfig.urls.product.categories,
            minInput: true
        }),
        subCategory: createSelect2({
            placeholder: 'Select Sub Category',
            url: window.AppConfig.urls.product.sub_categories,
            minInput: true
        }),
        company: createSelect2({
            placeholder: 'Select Company',
            url: window.AppConfig.urls.product.companies,
            minInput: true
        }),
        unit: createSelect2({
            placeholder: 'Select Unit',
            url: window.AppConfig.urls.product.units,
            minInput: true
        })
    };

    // Initialize Select2 for specific elements in a row
    const initRowSelect2 = ($row) => {
        $row.find('.generic').select2(select2Config.generic);
        $row.find('.category').select2(select2Config.category);
        $row.find('.sub-category').select2(select2Config.subCategory);
        $row.find('.company').select2(select2Config.company);
        $row.find('.unit').select2(select2Config.unit);
    };

    const addNewRow = () => {
        rowCounter++;
        const newRow = `
            <tr data-id="${rowCounter}">
		        <td class="first-part">
                      <div class="d-flex align-items-center">
                          <span>${rowCounter}</span>
                      </div>
                </td>
                <td><input type="text" class="form-control name" placeholder="Medicine name" ></td>
                <td class="generic-container"><select class="form-control generic" style="width: 100%;">
                      <option value="">Select Generic</option>
                  </select></td>
                <td><select class="form-control category" style="width: 100%;">
                      <option value="">Select Category</option>
                  </select></td>
                  <td><select class="form-control sub-category" style="width: 100%;">
                      <option value="">Select Sub Category</option>
                  </select></td>
                  <td><select class="form-control company" style="width: 100%;">
                      <option value="">Select Company</option>
                  </select></td>
                <td>
                      <button type="button" class="btn btn-sm btn-danger remove-row">
                          <i class="fas fa-trash"></i>
                      </button>
                          <button type="button" class="btn btn-sm btn-primary toggle-details ms-2">
                              <i class="fas fa-chevron-down"></i>
                          </button>
                </td>
            </tr>
            <tr class="expanded-row second-part d-none" data-id="${rowCounter}">
                <td colspan="2">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control image-upload" accept="image/*" data-row-id="${rowCounter}">
                    <input type="hidden" class="temp-file-id">
                    <div class="image-preview mt-2" style="max-width: 100px;"></div>
                </td>
                  <td>
                        <label class="form-label">Price (Base price)</label>
                        <input type="number" class="form-control price" placeholder="MRP" step="0.01">
                  </td>
                  <td colspan="2" class="p-2">
                        <div class="form-group">
                            <label class="form-label">Units</label>
                            <select class="form-control unit select2" name="unit[]" multiple>
                                <option value="">Select Unit</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <div class="price-div row mt-2 unit-prices-container">
                            </div>
                        </div>
                  </td>
                  <td colspan="2">
                        <div class="form-check text-center mb-2">
                            <input class="form-check-input hasDiscount" type="checkbox" id="hasDiscount${rowCounter}">
                            <label class="form-check-label" for="hasDiscount${rowCounter}">
                                Has Discount
                            </label>
                        </div>
                        <div class="discount-options d-none row">
                            <div class="col-md-6">
                                <label class="form-label">Discount Amount</label>
                                <input type="number" class="form-control discount_amount" placeholder="Discount Amount">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Discount Precentage</label>
                                <input type="number" class="form-control discount_precentage" placeholder="Discount Precentage">
                            </div>
                        </div>
                  </td>
            </tr>
        `;

        const $newRows = $(newRow);
        $("#medicineTable tbody").append($newRows);

        // Initialize Select2 for the new row
        initRowSelect2($newRows.filter(`[data-id="${rowCounter}"]`));
        initRowSelect2($newRows.filter(`.expanded-row[data-id="${rowCounter}"]`));
    };

    // Event handlers remain the same, but ensure proper cleanup
    $(document).on("click", ".remove-row", function() {
        const rowId = $(this).closest("tr").data("id");
        const $rows = $(`[data-id="${rowId}"]`);

        // Destroy Select2 instances before removal
        $rows.find('select').each(function() {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });

        $rows.remove();
    });

        $("#addNewRow").on("click", addNewRow)

    $(document).on("click", ".toggle-details", function () {
        const rowId = $(this).closest("tr").data("id")
        const detailsRow = $(`.expanded-row[data-id="${rowId}"]`)
        detailsRow.toggleClass("d-none")
        $(this).find("i").toggleClass("fa-chevron-down fa-chevron-up")
    })

    $(document).on('change', '.unit', function() {
        var selectedOptions = $(this).find('option:selected');
        var container = $(this).closest('td').find('.unit-prices-container');
        container.empty();
        if (selectedOptions.length > 0) {
            selectedOptions.each(function() {
                var unitId = $(this).val();
                var unitName = $(this).text().trim();
                var priceDiv = $(`
                    <div class="form-group unit-price-item">
                        <input type="hidden" name="units[][id]" value="${unitId}" class="unit-id">
                        <label>Price for ${unitName}</label>
                        <input type="number" class="form-control unit-price" name="units[][price]" placeholder="Enter price" data-unit-id="${unitId}" step="0.01">
                    </div>
                `);
                container.append(priceDiv);
            });
        }
    });

    $(document).on("change", ".hasDiscount", function () {
        $(this).closest("td").find(".discount-options").toggleClass("d-none", !this.checked)
    })

    $(document).on("change", ".discount_amount", function () {
        const discountPrecentage = $(this).closest("td").find(".discount_precentage")
        discountPrecentage.val('')
        console.log(discountPrecentage.val());

        if($(this).val() > 0)
            discountPrecentage.attr('disabled', 'disabled')
        else
            discountPrecentage.removeAttr('disabled')
    })

    $(document).on("change", ".discount_precentage", function () {
        const discountAmount = $(this).closest("td").find(".discount_amount")
        discountAmount.val('')
        console.log(discountAmount.val());
        if($(this).val() > 0)
            discountAmount.attr('disabled', 'disabled')
        else
            discountAmount.removeAttr('disabled')
    })

    // Add to document ready
    $(document).on('change', '.image-upload', function() {
        const $input = $(this);
        const rowId = $input.closest('tr').data('id');
        const formData = new FormData();
        formData.append('image', $input[0].files[0]);
        formData.append('name', 'image');

        $.ajax({
            url: window.AppConfig.urls.file.upload,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: () => {
                displaySaveAllButton(false);
            },
            success: (response) => {
                const $row = $(`tr[data-id="${rowId}"]`);
                $row.find('.temp-file-id').val(response);
                toastr.success('Image uploaded successfully');
                displaySaveAllButton(true);
            },
            error: (e) => {
                toastr.error('Error uploading image');
                $input.val('');
                displaySaveAllButton(true);
            }
        });
    });

    $("#saveAll").on("click", async (e) => {
        e.preventDefault();
        console.log('save all');
        const medicines = [];
        const medicineMap = {};
        const errors = [];
        const progressModal = $('#progressModal');

        // Collect all medicine data
        $('tr[data-id]').each(function() {
            const rowId = $(this).data('id');
            const $row = $(this);
            const $expandedRow = $(`.expanded-row[data-id="${rowId}"]`);

            const medicineData = {
                name: $row.find('.name').val() ?? '',
                generic_id: $row.find('.generic').val() ?? '',
                pro_cat_id: $row.find('.category').val() ?? '',
                pro_sub_cat_id: $row.find('.sub-category').val() ?? '',
                company_id: $row.find('.company').val() ?? '',
                temp_file_id: $expandedRow.find('.temp-file-id').val() ?? '',
                units: $expandedRow.find('.unit-price-item').map(function() {
                    return {
                        id: $(this).find('.unit-id').val() ?? '',
                        price: $(this).find('.unit-price').val() ?? ''
                    };
                }).get(),
                price: $expandedRow.find('.price').val() ?? '',
                has_discount: $expandedRow.find('.hasDiscount').is(':checked') ? 1 : 0,
                discount_amount: $expandedRow.find('.discount_amount').val() ?? '',
                discount_precentage: $expandedRow.find('.discount_precentage').val() ?? '',
            };

            if (medicineMap[rowId]) {
                Object.assign(medicineMap[rowId], medicineData);
            } else {
                medicineMap[rowId] = medicineData;
                medicines.push({...medicineData, rowId});
            }
        });

        $(progressModal).modal('show');
        $(progressModal).find('#errorList').html('');

        // Process medicines one by one
        for (let i = 0; i < medicines.length; i++) {
            const medicine = medicines[i];
            const progress = ((i + 1) / medicines.length) * 100;

            $(progressModal).find('.progress-bar').css('width', `${progress}%`);
            $(progressModal).find('#progressText').text(`Processing ${i + 1}/${medicines.length}`);

            try {
                console.log(medicine);

                const response = await $.ajax({
                    url: window.AppConfig.urls.product.bulk_create,
                    type: 'POST',
                    data: { medicine },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if (!response.success) {
                    errors.push({
                        rowId: medicine.rowId,
                        errors: response.errors
                    });
                }
            } catch (error) {
                console.log(error);
                errors.push({
                    rowId: medicine.rowId,
                    errors: { general: 'Something went wrong. Please try again' }
                });
            }
        }

        // Update modal with results
        if (errors.length > 0) {
            let errorHtml = '<div class="alert alert-danger"><h6>Errors occurred:</h6><ul>';
            errors.forEach(error => {
                const rowNum = $(`tr[data-id="${error.rowId}"]`).index() + 1;
                const errorMessages = Object.values(error.errors).flat().join(', ');
                errorHtml += `<li>Row ${rowNum}: ${errorMessages}</li>`;
            });
            errorHtml += '</ul></div>';
            $('#errorList').html(errorHtml);

            // Remove successful entries and keep only failed ones
            $('tr[data-id]').each(function() {
                const rowId = $(this).data('id');
                if (!errors.find(e => e.rowId === rowId)) {
                    $(this).remove();
                    $(`.expanded-row[data-id="${rowId}"]`).remove();
                }
            });
        } else {
            progressModal.modal('hide');
            window.location.reload();
        }
    });

    addNewRow()
});

function displaySaveAllButton(isDisplay) {
    $("#saveAll").toggle(isDisplay);
}
