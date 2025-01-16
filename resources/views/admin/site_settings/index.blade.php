@extends('admin.layouts.master', ['pageSlug' => 'site_settings'])
@section('title', 'Application Settings')
@push('css_link')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
@endpush

@section('content')
    @php
        $count = 0;
    @endphp
    <div class="row site_settings px-3">
        <div class="col-md-12 pl-0 pr-0">

        </div>
        <div class="tab col-md-2 p-md-3 pl-sm-3">
            <button id="tab1Btn" class="tablinks p-3 btn-success text-white"
                onclick="openTab(event, 'tab1')">{{ __('General
                                                                                                                                                                                                                                                                                                                                Settings') }}</button>
            <button id="tab2Btn" class="tablinks p-3" onclick="openTab(event, 'tab2')">{{ __('Email Settings') }}</button>
            <button id="tab3Btn" class="tablinks p-3"
                onclick="openTab(event, 'tab3')">{{ __('Database Settings') }}</button>
            <button id="tab4Btn" class="tablinks p-3" onclick="openTab(event, 'tab4')">{{ __('SMS Settings') }}</button>
            <button id="tab5Btn" class="tablinks p-3"
                onclick="openTab(event, 'tab5')">{{ __('Notification Settings') }}</button>
            <button id="tab6Btn" class="tablinks p-3"
                onclick="openTab(event, 'tab6')">{{ __('Email Templates') }}</button>
            <button id="tab7Btn" class="tablinks p-3" onclick="openTab(event, 'tab7')">{{ __('Point Setting') }}</button>
            <button id="tab8Btn" class="tablinks p-3" onclick="openTab(event, 'tab8')">{{ __('Mapbox Setting') }}</button>
            <button id="tab9Btn" class="tablinks p-3"
                onclick="openTab(event, 'tab9')">{{ __('Social Login Setting') }}</button>
        </div>
        <div class="col-md-10 p-0">
            {{-- Tab-1 --}}
            <div id="tab1" class="tabcontent py-3">
                @php
                    $document = $documents->where('module_key', 'general_settings')->first();
                @endphp
                @include('admin.site_settings.general_settings', ['document' => $document])
            </div>

            <div id="tab2" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'email_settings')->first();
                @endphp
                @include('admin.site_settings.email_settings', ['document' => $document]);
            </div>

            <div id="tab3" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'database_settings')->first();
                @endphp
                @include('admin.site_settings.database_settings', ['document' => $document])
            </div>

            <div id="tab4" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'sms_settings')->first();
                @endphp
                @include('admin.site_settings.sms_settings', ['document' => $document])
            </div>
            <div id="tab5" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'notification_settings')->first();
                @endphp
                @include('admin.site_settings.notification_settings', ['document' => $document])
            </div>
            <div id="tab6" class="tabcontent py-3" style="display: none">
                @include('admin.site_settings.email_templates')
            </div>
            <div id="tab7" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'point_settings')->first();
                @endphp
                @include('admin.site_settings.point_settings', ['document' => $document])
            </div>
            <div id="tab8" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'mapbox_settings')->first();
                @endphp
                @include('admin.site_settings.mapbox_settings', ['document' => $document])
            </div>
            <div id="tab9" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key', 'social_login_settings')->first();
                @endphp
                @include('admin.site_settings.social_login_settings', ['document' => $document])
            </div>


        </div>
    </div>
@endsection
@push('js_link')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>
@endpush
@push('js')
    <script src="{{ asset('admin/js/site_settings.js') }}"></script>
@endpush
