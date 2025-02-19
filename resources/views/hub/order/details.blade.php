@extends('hub.layouts.master', ['pageSlug' => 'order_'.titleToSlug($oh->status_string)])
@section('title', 'Order Details')
@push('css_link')
    <link rel="stylesheet" href="{{ asset('hub/css/order_details.css') }}">
@endpush
@push('css')
<style>
    .order_details, .order_timeline{
        height: 25rem;
        overflow:auto;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">{{ __('Order Details') }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <span class="badge {{ $oh->status_bg }}">{{ slugToTitle($oh->status_string) }}</span>
                        {{ 'order_'.titleToSlug($oh->status_string) }}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('hub.order.includes.order_details',[
                            'order_hub' => $oh,
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('hub.order.includes.order_timeline',[
                            'timelines' => $timelines,
                            'order_status' => optional($oh->order)->status
                        ])
                    </div>
                    <div class="col-md-12 mt-3">
                        @include('hub.order.includes.order_items', [
                            'order_hub_products' => $oh->orderhubproducts,
                            'order' => $oh->order
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    const OrderCollector = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $(document).on('input', '.unit_price', this.handlePriceCalculation);
            $('#order_collecting_form').on('submit', this.handleFormSubmission);
        },

        handlePriceCalculation: function() {
            const row = $(this).closest('.card');
            const quantity = parseFloat(row.find('.quantity').text()) || 0;
            const price = parseFloat($(this).val()) || 0;

            // Calculate unit total
            const unitTotal = quantity * price;
            row.find('.unit_total_price').text(unitTotal.toFixed(2));
            row.find('.unit_total').show();

            OrderCollector.updateGrandTotal();
        },

        updateGrandTotal: function() {
            let grandTotal = 0;
            $('.unit_total_price').each(function() {
                grandTotal += parseFloat($(this).text()) || 0;
            });
            $('.total_collecting_price').text(grandTotal.toFixed(2));
        },

        validateForm: function() {
            let isValid = true;
            const errors = [];

            // Reset previous validation states
            $('.pharmacy_id, .unit_price').removeClass('is-invalid');

            // Validate each order item
            $('.product-container').each(function(index) {
                const pharmacySelect = $(this).find('.pharmacy_id');
                const unitPrice = $(this).find('.unit_price');
                const itemNumber = index + 1;

                if (!pharmacySelect.val()) {
                    isValid = false;
                    pharmacySelect.addClass('is-invalid');
                    errors.push(`Please select pharmacy for item #${itemNumber}`);
                }

                if (!unitPrice.val() || parseFloat(unitPrice.val()) <= 0) {
                    isValid = false;
                    unitPrice.addClass('is-invalid');
                    errors.push(`Please enter valid collecting price for item #${itemNumber}`);
                }
            });

            return {
                isValid: isValid,
                errors: errors
            };
        },

        handleFormSubmission: function(e) {
            const validation = OrderCollector.validateForm();

            if (!validation.isValid) {
                e.preventDefault();
                confirm('Are you sure collect this order?')
                toastr.error(validation.errors.join('\n'));
                return false;
            }

            return true;
        }
    };
    OrderCollector.init();
});
</script>
@endpush
