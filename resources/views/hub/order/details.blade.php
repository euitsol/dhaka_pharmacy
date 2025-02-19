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
    $(document).on('input', '.unit_price', function() {
        let row = $(this).closest('.card');
        let quantity = parseFloat(row.find('.quantity').text()) || 0;
        let price = parseFloat($(this).val()) || 0;

        // Calculate unit total
        let unitTotal = quantity * price;
        row.find('.unit_total_price').text(unitTotal.toFixed(2));
        row.find('.unit_total').show();

        // Calculate grand total
        let grandTotal = 0;
        $('.unit_total_price').each(function() {
            grandTotal += parseFloat($(this).text()) || 0;
        });
        $('.total_collecting_price').text(grandTotal.toFixed(2));
    });

    $('#order_collecting_form').on('submit', function(e) {
        e.preventDefault();

        // $('.pharmacy_id')
    })
});
</script>
@endpush
