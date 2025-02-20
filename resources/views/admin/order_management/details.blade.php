@extends('admin.layouts.master', ['pageSlug' => 'order_'.titleToSlug($order->status_string, '_')])
@section('title', slugToTitle($order->status_string).' Order Details')
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/ordermanagement.css') }}">
    <style>
        .order_details, .order_timeline{
            height: 25rem;
            overflow:auto;
        }
        .hub-display {
            padding: 6px 12px;
            border-radius: 4px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
    </style>
@endpush
@section('content')
{{ 'order_'.titleToSlug($order->status_string, '_') }}
    <div class="order_details_wrap">
        <div class="row px-3">
            <div class="card px-0">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-6">
                            @include('admin.order_management.partials.order_details', [
                                'order' => $order
                            ])
                        </div>
                        <div class="col-md-6">
                            @include('admin.order_management.partials.order_timeline', [
                                'timelines' => $order->timelines,
                                'order_status' => $order->status,
                            ])
                        </div>
                        <div class="col-md-12 mt-2">
                            @include('admin.order_management.partials.order_items', [
                                'products' => $order->productsWithHubPharmacy,
                                'order_status' => $order->status,
                                'order_id' => $order->id,
                                'hubs' => $hubs
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
        // $(document).ready(function() {
        //     var order_details_height = $('.order_details').height();
        //     $('.order_items').height(order_details_height + 'px');
        // });
    </script>
@endpush
