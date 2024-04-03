@extends('admin.layouts.master', ['pageSlug' => 'pg_settings'])
@section('title', 'Payment Gateway Settings')
@section('content')
    @php
        $count = 0;
    @endphp
    <div class="row site_settings px-3">
        <div class="col-md-12 pl-0 pr-0">
            
        </div>
        <div class="tab col-md-2 p-md-3 pl-sm-3">
            <button id="tab1Btn" class="tablinks p-3 btn-success text-white" onclick="openTab(event, 'tab1')">{{__('SSL Commerz')}}</button>
            <button id="tab2Btn" class="tablinks p-3" onclick="openTab(event, 'tab2')">{{__('Bkash')}}</button>
        </div>
        <div class="col-md-10 p-0">
            {{-- Tab-1 --}}
            <div id="tab1" class="tabcontent py-3">
                @php
                    $document = $documents->where('module_key','ssl_commerz')->first();
                @endphp
                @include('admin.payment_gateway.settings.ssl_commerz',['document'=>$document])
            </div>
            <div id="tab2" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key','bkash')->first();
                @endphp
                @include('admin.payment_gateway.settings.bkash',['document'=>$document]);
            </div>


        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/js/site_settings.js') }}"></script>
@endpush
