/**
 * Payment Modal JS
 * Handles dynamic loading of delivery options based on selected address
 */
document.addEventListener('DOMContentLoaded', function() {
    const paymentModal = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            const addressSelect = document.querySelector('#paymentModal #address');
            if (addressSelect) {
                addressSelect.addEventListener('change', this.handleAddressChange.bind(this));
            }
        },

        handleAddressChange: function(event) {
            const addressId = event.target.value;
            if (addressId) {
                this.updateAddressDetails(addressId);
            } else {
                this.resetDeliveryTypeSection();
            }
        },

        updateAddressDetails: function(addressId) {
            if (addressId) {
                const url = window.AppConfig.urls.address.details.replace("id", addressId);
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        return response.json();
                    })
                    .then(response => {
                        this.updateDeliveryTypeSection(response.delivery_options);
                    })
                    .catch(error => {
                        console.error('Error fetching address details:', error);
                        this.resetDeliveryTypeSection();
                    });
            }
        },

        updateDeliveryTypeSection: function(data) {
            const deliveryTypeContainer = document.getElementById('delivery_type_container');

            if (!data || data.length === 0) {
                deliveryTypeContainer.innerHTML = `
                    <select name="delivery_type" class="form-select" id="delivery_type">
                        <option value="">No delivery options available</option>
                    </select>
                `;
                return;
            }

            let options = '<select name="delivery_type" class="form-select" id="delivery_type" required>';
            options += '<option value="">Select delivery type</option>';

            data.forEach(item => {
                console.log(item);

                const { type, charge, expected_delivery_date } = item;
                const typeCapitalized = type.charAt(0).toUpperCase() + type.slice(1);
                options += `<option value="${type}" data-charge="${charge}" data-expected-delivery-date="${expected_delivery_date}">
                    ${typeCapitalized} Delivery - ${charge} tk (${expected_delivery_date})
                </option>`;
            });

            options += '</select>';
            deliveryTypeContainer.innerHTML = options;

            // Update delivery charge and total amount if needed
            const deliveryType = document.getElementById('delivery_type');
            if (deliveryType) {
                deliveryType.addEventListener('change', this.updateOrderSummary.bind(this));
            }
        },

        updateOrderSummary: function(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            const charge = selectedOption.getAttribute('data-charge');

            // Update delivery charge in the summary if needed
            const deliveryChargeElement = document.getElementById('delivery_charge');
            if (deliveryChargeElement && charge) {
                deliveryChargeElement.textContent = parseFloat(charge).toFixed(2);

                // Recalculate total amount if needed
                this.recalculateTotalAmount();
            }
        },

        recalculateTotalAmount: function() {
            // This function would recalculate the total amount based on subtotal, discounts, and delivery charge
            // Implementation depends on your specific requirements
        },

        resetDeliveryTypeSection: function() {
            const deliveryTypeContainer = document.getElementById('delivery_type_container');
            deliveryTypeContainer.innerHTML = `
                <select name="delivery_type" class="form-select" id="delivery_type">
                    <option value="">Please select an address first</option>
                </select>
            `;
        }
    };

    // Initialize the payment modal functionality
    paymentModal.init();
});
