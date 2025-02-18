@extends('hub.layouts.master', ['pageSlug' => 'order_'.titleToSlug($oh->status_string)])
@section('title', 'Order Details')
@push('css')
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
