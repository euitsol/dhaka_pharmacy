/**
 * Payment Modal JS
 * Handles dynamic loading of delivery options based on selected address
 * and updates order summary calculations
 */
document.addEventListener('DOMContentLoaded', function() {
    const paymentModal = {
        // Store order details
        selectedDeliveryCharge: 0,

        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Address select change event
            const addressSelect = document.querySelector('#paymentModal #address');
            if (addressSelect) {
                addressSelect.addEventListener('change', this.handleAddressChange.bind(this));

                // Trigger change event if a default address is already selected
                if (addressSelect.value) {
                    const event = new Event('change');
                    addressSelect.dispatchEvent(event);
                }
            }

            // Delivery type change event
            const deliveryTypeSelect = document.querySelector('#paymentModal #delivery_type');
            if (deliveryTypeSelect) {
                deliveryTypeSelect.addEventListener('change', this.handleDeliveryTypeChange.bind(this));
            }

            // Payment method change event
            const paymentMethodSelect = document.querySelector('#paymentModal #payment_method');
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', this.handlePaymentMethodChange.bind(this));
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
            const deliveryTypeSelect = document.getElementById('delivery_type');

            if (!deliveryTypeSelect) {
                console.error('Delivery type select element not found');
                return;
            }

            // Clear existing options
            deliveryTypeSelect.innerHTML = '';

            if (!data || data.length === 0) {
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'No delivery options available';
                deliveryTypeSelect.appendChild(defaultOption);
                return;
            }

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select delivery type';
            deliveryTypeSelect.appendChild(defaultOption);

            // Add delivery options
            data.forEach(item => {
                const { name, type, charge, delivery_time_hours, expected_delivery_date } = item;
                const option = document.createElement('option');
                option.value = type;
                option.setAttribute('data-charge', charge);
                option.setAttribute('data-expected-delivery-date', expected_delivery_date);
                option.textContent = `${name} - ${charge} tk (${expected_delivery_date})`;
                deliveryTypeSelect.appendChild(option);
            });

            // Enable the select
            deliveryTypeSelect.classList.remove('disabled');
        },

        handleDeliveryTypeChange: function(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const charge = selectedOption.getAttribute('data-charge');
                if (charge) {
                    this.selectedDeliveryCharge = parseFloat(charge);
                    this.updateOrderSummary();
                }
            }
        },

        handlePaymentMethodChange: function(event) {
            // Handle payment method change if needed
            const paymentMethod = event.target.value;
            console.log('Payment method changed to:', paymentMethod);
        },

        updateOrderSummary: function() {
            // Update delivery charge based on selected delivery type
            const deliveryChargeElement = document.querySelector('#paymentModal .delivery-charge');
            if (deliveryChargeElement) {
                deliveryChargeElement.textContent = this.selectedDeliveryCharge.toFixed(2);
            }

            // Calculate and update total payable
            // Get current values from the DOM
            const totalPayableElement = document.querySelector('#paymentModal .total-payable');
            const subTotalElement = document.querySelector('#paymentModal .sub-total');
            const productDiscountElement = document.querySelector('#paymentModal .product-discount');
            const voucherDiscountElement = document.querySelector('#paymentModal .voucher-discount');

            if (totalPayableElement && subTotalElement && productDiscountElement && voucherDiscountElement) {
                const subTotal = parseFloat(subTotalElement.textContent || 0);
                const productDiscount = parseFloat(productDiscountElement.textContent || 0);
                const voucherDiscount = parseFloat(voucherDiscountElement.textContent || 0);
                const deliveryCharge = this.selectedDeliveryCharge;

                const totalPayable = subTotal - productDiscount - voucherDiscount + deliveryCharge;
                totalPayableElement.textContent = totalPayable.toFixed(2);
            }
        },

        resetDeliveryTypeSection: function() {
            const deliveryTypeSelect = document.getElementById('delivery_type');
            if (deliveryTypeSelect) {
                deliveryTypeSelect.innerHTML = '';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Please select an address first';
                deliveryTypeSelect.appendChild(defaultOption);

                deliveryTypeSelect.classList.add('disabled');

                // Reset delivery charge
                this.selectedDeliveryCharge = 0;
                this.updateOrderSummary();
            }
        }
    };

    // Initialize the payment modal functionality
    paymentModal.init();
});
