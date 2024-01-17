@extends('admin.layouts.master', ['pageSlug' => 'site_settings'])
@section('title', 'Site Settings')
@push('css_link')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
@endpush
@push('css')
    <style>

    .white-content .btn:not([data-action]):hover {
        box-shadow: none !important;
    }
    .btn:not([data-action]):hover, .navbar .navbar-nav>a.btn:not([data-action]):hover {
        box-shadow: none !important;
        transform: none !important;
        -webkit-transform: none !important;
    }




    /* Circle  */
    .toggle.ios,
    .toggle-on.ios,
    .toggle-off.ios {
        border-radius: 20rem;
    }
    .toggle.ios .toggle-handle {
        border-radius: 20rem;
    }


    /* Squer */
    .toggle.android {
        border-radius: 0px;
    }
    .toggle.android .toggle-handle {
        border-radius: 0px;
    }
    </style>
@endpush

@section('content')
    @php
        $count = 0;
    @endphp
    <div class="row site_settings px-3">
        <div class="col-md-12 pl-0 pr-0">
            @include('alerts.success')
        </div>
        <div class="tab col-md-2 p-md-3 pl-sm-3">
            <button id="defaultOpen" class="tablinks p-3 btn-success text-white" onclick="openTab(event, 'tab1')">General
                Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab2')">Email Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab3')">Database Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab4')">SMS Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab5')">Notification Settings</button>
        </div>
        <div class="col-md-10 p-0">
            {{-- Tab-1 --}}
            <div id="tab1" class="tabcontent py-3">
                @include('site_settings.general_settings')
            </div>


            <div id="tab2" class="tabcontent py-3" style="display: none">
                @include('site_settings.email_settings')
            </div>

            <div id="tab3" class="tabcontent py-3" style="display: none">
                @include('site_settings.database_settings')
            </div>

            <div id="tab4" class="tabcontent py-3">
                @include('site_settings.sms_settings')
            </div>
            <div id="tab5" class="tabcontent py-3">
                @include('site_settings.notification')
            </div>


        </div>
    </div>
@endsection
@push('js_link')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>
@endpush
@push('js')
    <script src="{{ asset('backend/js/site_settings.js') }}"></script>
@endpush
