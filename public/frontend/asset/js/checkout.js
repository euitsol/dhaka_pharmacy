
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    beforeSend: function() {
    },
    complete: function() {
    }
});
const checkoutModule = (() => {
    const operations = {
        getAddressDetails: (url) => $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
        }),
    };

    // Response handlers
    const handleResponse = (response) => {
        if (response.success) {
        } else if (response.requiresLogin) {
            handleLoginRequirement();
        } else {
            handleErrors(response);
        }
    };

    const handleErrors = (response) => {
        console.log(response);

        var errors = response.errors;
        if(errors){
            for (var field in errors) {
                toastr.error(errors[field][0]);
            }
        }else{
            toastr.error(response);
        }
    }

    const handleError = (xhr) => {
        if (xhr.status === 401) handleLoginRequirement();
        else if (xhr.status === 422) handleErrors(xhr.responseJSON);
        else if (xhr.status === 404) handleErrors(xhr.responseJSON);
        else if (xhr.status === 500) toastr.error('An unexpected error occurred. Please try again.');
        else toastr.error('An unexpected error occurred. Please try again.');
    };

    const updateDeliveryTypeSection = (data) => {
        const deliveryTypeContainer = document.getElementById('delivery_type_container');
        var append = '';
        if(data){
            deliveryTypeContainer.innerHTML = ''; // Clear existing content
            data.forEach(item => {
               const {type, charge, expected_delivery_date} = item;
                append += `
                        <div class="col-md-6 mt-4">
                            <div class="delivery-option">
                                <input type="radio" class="delivery-radio" id="${type}" name="delivery_type" value="${type}" data-charge="${charge}" data-expected_delivery_date="${expected_delivery_date}">
                                <label class="delivery-label" for="${type}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="radio-circle"></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">${type.charAt(0).toUpperCase() + type.slice(1)} Delivery</h6>
                                                    <p class="text-muted small mb-1">${type.charAt(0).toUpperCase() + type.slice(1)} delivery charge is ${charge} taka.</p>
                                                    <span class="delivery-time">Estimated delivery: ${expected_delivery_date}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                `;
            });
        }else{
            append += `<div class="text-center w-100 text-danger">Delivery not available in your area.</div>`;
            toastr.error('Delivery not available in your area.');
        }

        deliveryTypeContainer.innerHTML = append; // Append all the elements
    };

    const updateAddressDetails = (id) => {
        if(id){
            const url = window.AppConfig.urls.address.details.replace('id', id);
            operations.getAddressDetails(url)
                .then(response => {
                    updateDeliveryTypeSection(response.delivery_options);
                })
                .catch(handleError);
        }
    };

    const getDeliveryCharge = () =>{
        const selectedRadio = $('.delivery-radio:checked');
        if(selectedRadio.length > 0) {
            return parseFloat(selectedRadio.data('charge')).toFixed(2);
        }

        return '0.00';
    };

    const updateTotalAmount = () => {
        let sumAdd = 0;
        $('.amount-a').each(function() {
            const value = parseFloat($(this).text().replace(/[^0-9.-]+/g, '')) || 0;
            sumAdd += value;
        });

        let sumMinus = 0;
        $('.amount-m').each(function() {
            const value = parseFloat($(this).text().replace(/[^0-9.-]+/g, '')) || 0;
            sumMinus += value;
        });
        const total = Math.ceil(sumAdd - sumMinus);
        $('#total_amount').text(total.toFixed(2));
    };

    const updateDeliveryPrices = () =>{
        const deliveryCharge = getDeliveryCharge();
        $('#delivery_charge').text(deliveryCharge);
        updateTotalAmount();
    };

    const checkoutValidation = () => {
        let isValid = true;

        if(!$('.payment-method:checked').length){
            toastr.error('Plese select payment method');
            isValid = false;
        }

        if(!$('.delivery-radio:checked').length){
            toastr.error('Plese select delivery type');
            isValid = false;
        }

        if(!$('.address').val()){
            toastr.error('Plese select address');
            isValid = false;
        }

        return isValid;
    };

    return {
        operations,
        handleResponse,
        handleError,
        updateDeliveryTypeSection,
        updateAddressDetails,
        updateDeliveryPrices,
        checkoutValidation
    };
})();
$(document).ready(function() {
    checkoutModule.updateAddressDetails($('.address').val());

    $('.address').on('change', function() {
        checkoutModule.updateAddressDetails($(this).val());
    });

    document.addEventListener('change', function(event) {
        if (event.target && event.target.matches('.delivery-radio')) {
            checkoutModule.updateDeliveryPrices();
        }
    });

    $('.confirm_button').on('click', function(e) {
        e.preventDefault();

        if(checkoutModule.checkoutValidation()){
            $('#confirmOrderForm').submit();
        }
    });
});
