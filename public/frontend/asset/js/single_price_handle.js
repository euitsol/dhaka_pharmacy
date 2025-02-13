(function (window, $, undefined) {
    'use strict';

    const PriceCalculator = {
        selectors: {
            unitName: '.unit_name',
            totalPrice: '.total_price',
            totalRegularPrice: '.total_regular_price',
            itemQuantity: '.item_quantity:checked',
            quantityInput: '.quantity_input',
            cartButton: '.cart-btn',
            minusQty: '.minus_qty',
            plusQty: '.plus_qty',
            productContent: '.product_content'
        },

        init() {
            if (!this.elementsExist()) return;

            this.cacheElements();
            this.initializeEventHandlers();
            this.updatePrices(this.getCurrentQuantity());
        },

        elementsExist() {
            return $(this.selectors.unitName).length > 0;
        },

        cacheElements() {
            this.$unitName = $(this.selectors.unitName);
            this.$totalPrice = $(this.selectors.totalPrice);
            this.$totalRegularPrice = $(this.selectors.totalRegularPrice);
            this.$cartButton = $(this.selectors.cartButton);
            this.$quantityInput = $(this.selectors.quantityInput);
        },

        initializeEventHandlers() {
            $(document)
                .on('change', this.selectors.itemQuantity, this.handleUnitChange.bind(this))
                .on('input', this.selectors.quantityInput, this.handleQuantityInput.bind(this))
                .on('click', this.selectors.plusQty, () => this.adjustQuantity(1))
                .on('click', this.selectors.minusQty, () => this.adjustQuantity(-1));
        },

        handleUnitChange(e) {
            const $target = $(e.target);
            const quantity = this.getCurrentQuantity();

            $(this.selectors.productContent)
                .find(this.selectors.cartButton)
                .attr('data-unit_id', $target.data('id'));

            this.updatePrices(quantity, $target);
        },

        handleQuantityInput(e) {
            const quantity = this.parseQuantity(e.target.value);
            this.updateButtonState(quantity);
            this.updateCartButtonQuantity(quantity);
            this.updatePrices(quantity);
        },

        adjustQuantity(increment) {
            const currentQuantity = this.getCurrentQuantity();
            const newQuantity = Math.max(1, currentQuantity + increment);

            this.$quantityInput.val(newQuantity);
            this.updateButtonState(newQuantity);
            this.updateCartButtonQuantity(newQuantity);
            this.updatePrices(newQuantity);
        },

        updatePrices(quantity, unitElement = null) {
            const unit = unitElement || $(this.selectors.itemQuantity);
            if (!unit.length) return;

            this.safeUpdate(this.$unitName, unit.data('name'));

            const price = this.calculatePrice(unit.data('total_price'), quantity);
            const regularPrice = this.calculatePrice(unit.data('total_regular_price'), quantity);

            this.safeUpdate(this.$totalPrice, price);
            this.safeUpdate(this.$totalRegularPrice, regularPrice);
        },

        calculatePrice(basePrice, quantity) {
            return typeof numberFormat === 'function'
                ? numberFormat(basePrice * quantity, 2)
                : (basePrice * quantity).toFixed(2);
        },

        safeUpdate($element, value) {
            if ($element.length) {
                $element.html(value);
            }
        },

        getCurrentQuantity() {
            return this.parseQuantity(this.$quantityInput.val());
        },

        parseQuantity(value) {
            const quantity = parseInt(value, 10);
            return isNaN(quantity) ? 1 : Math.max(1, quantity);
        },

        updateButtonState(quantity) {
            $(this.selectors.minusQty).toggleClass('disabled', quantity <= 1);
        },

        updateCartButtonQuantity(quantity) {
            if (this.$cartButton.length) {
                this.$cartButton.attr('data-quantity', quantity);
            }
        }
    };

    $(document).ready(() => PriceCalculator.init());
})(window, jQuery);
