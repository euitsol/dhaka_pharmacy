@extends('admin.layouts.master', ['pageSlug' => 'site_settings'])
@section('title', 'Site Settings')
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
            <button id="defaultOpen" class="tablinks p-3 btn-success text-white" onclick="openTab(event, 'tab1')">General
                Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab2')">Email Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab3')">Database Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab4')">SMS Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab5')">Notification Settings</button>
            <button class="tablinks p-3 " onclick="openTab(event, 'tab6')">Email Templates</button>
        </div>
        <div class="col-md-10 p-0">
            {{-- Tab-1 --}}
            <div id="tab1" class="tabcontent py-3">
                @php
                    $document = $documents->where('module_key','general_settings')->first();
                @endphp
                @include('site_settings.general_settings',['document'=>$document])
            </div>

            <div id="tab2" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key','email_settings')->first();
                @endphp
                @include('site_settings.email_settings',['document'=>$document]);
            </div>

            <div id="tab3" class="tabcontent py-3" style="display: none">
                @php
                    $document = $documents->where('module_key','database_settings')->first();
                @endphp
                @include('site_settings.database_settings',['document'=>$document])
            </div>

            <div id="tab4" class="tabcontent py-3">
                @php
                    $document = $documents->where('module_key','sms_settings')->first();
                @endphp
                @include('site_settings.sms_settings',['document'=>$document])
            </div>
            <div id="tab5" class="tabcontent py-3">
                @php
                    $document = $documents->where('module_key','notification_settings')->first();
                @endphp
                @include('site_settings.notification_settings',['document'=>$document])
            </div>
            <div id="tab6" class="tabcontent py-3">
                @include('site_settings.email_templates')
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
