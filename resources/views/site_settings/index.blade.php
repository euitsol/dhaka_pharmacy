@extends('admin.layouts.master', ['pageSlug' => 'site_settings'])
@section('title', 'Site Settings')
@push('css')
    <style>

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
        </div>
        <div class="col-md-10 p-0">
            {{-- Tab-1 --}}
            <div id="tab1" class="tabcontent py-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">{{ _('General Settings') }}</h5>
                            </div>
                            <form method="POST" action="{{ route('settings.site_settings') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group{{ $errors->has('site_name') ? ' has-danger' : '' }}">
                                        <label>{{ _('Site Name') }}</label>
                                        <input type="text" name="site_name"
                                            class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Site Name') }}"
                                            value="{{ $SiteSettings['site_name'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'site_name'])
                                    </div>

                                    <div class="form-group{{ $errors->has('site_short_name') ? ' has-danger' : '' }}">
                                        <label>{{ _('Site Short Name') }}</label>
                                        <input type="text" name="site_short_name"
                                            class="form-control{{ $errors->has('site_short_name') ? ' is-invalid' : '' }} "
                                            placeholder="{{ _('Site Short Name') }}"
                                            value="{{ $SiteSettings['site_short_name'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'site_short_name'])
                                    </div>

                                    <div class="form-group{{ $errors->has('timezone') ? ' has-danger' : '' }}">
                                        <label>{{ _('Timezone') }}</label>
                                        <select name="timezone"
                                            class="form-control{{ $errors->has('timezone') ? ' is-invalid' : '' }}">
                                            @foreach ($availableTimezones as $at)
                                                <option value="{{ $at['timezone'] }}"
                                                    @if (isset($SiteSettings['timezone']) && $SiteSettings['timezone'] == $at['timezone']) selected @endif>
                                                    {{ $at['name'] ?? '' }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'timezone'])
                                    </div>

                                    <div class="form-group{{ $errors->has('site_logo') ? ' has-danger' : '' }}">
                                        <label>{{ _('Site Logo') }}</label>
                                        <input type="file" name="site_logo"
                                            class="form-control {{ $errors->has('site_logo') ? ' is-invalid' : '' }} image-upload"
                                            @if (isset($SiteSettings['site_logo'])) data-existing-files="{{ storage_url($SiteSettings['site_logo']) }}" data-delete-url="" @endif
                                            accept="image/*">
                                        @include('alerts.feedback', ['field' => 'site_logo'])
                                    </div>

                                    <div class="form-group{{ $errors->has('site_favicon') ? ' has-danger' : '' }}">
                                        <label>{{ _('Site Favicon 16*16') }}</label>

                                        <input type="file" name="site_favicon"
                                            class="form-control {{ $errors->has('site_favicon') ? ' is-invalid' : '' }} image-upload"
                                            @if (isset($SiteSettings['site_favicon'])) data-existing-files="{{ storage_url($SiteSettings['site_favicon']) }}" data-delete-url="{{ storage_url($SiteSettings['site_favicon']) }}" @endif
                                            accept="image/*">
                                        @include('alerts.feedback', ['field' => 'site_favicon'])
                                    </div>

                                    <div class="form-group{{ $errors->has('env') ? ' has-danger' : '' }}">
                                        <label>{{ _('Environment') }}
                                            <small>({{ _('Best to keep in production') }})</small></label>
                                        <select name="env"
                                            class="form-control{{ $errors->has('env') ? ' is-invalid' : '' }}">
                                            <option value="production" @if (isset($SiteSettings['env']) && $SiteSettings['env'] == 'production') selected @endif>
                                                {{ _('Production') }}</option>
                                            <option value="local" @if (isset($SiteSettings['env']) && $SiteSettings['env'] == 'local') selected @endif>
                                                {{ _('Local') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'env'])
                                    </div>

                                    <div class="form-group{{ $errors->has('debug') ? ' has-danger' : '' }}">
                                        <label>{{ _('App Debug') }}
                                            <small>({{ _('Best to keep in false') }})</small></label>
                                        <select name="debug"
                                            class="form-control no-select {{ $errors->has('debug') ? ' is-invalid' : '' }}">
                                            <option value="1" @if (isset($SiteSettings['debug']) && $SiteSettings['debug'] == '1') selected @endif>
                                                {{ _('True') }}</option>
                                            <option value="0" @if (isset($SiteSettings['debug']) && $SiteSettings['debug'] == '0') selected @endif>
                                                {{ _('False') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'debug'])
                                    </div>

                                    <div class="form-group {{ $errors->has('debugbar') ? ' has-danger' : '' }}">
                                        <label>{{ _('Enable Debugbar') }}
                                            <small>({{ _('Best to keep in false') }})</small></label>
                                        <select name="debugbar"
                                            class="form-control no-select  {{ $errors->has('debugbar') ? ' is-invalid' : '' }}">
                                            <option value="1" @if (isset($SiteSettings['debugbar']) && $SiteSettings['debugbar'] == '1') selected @endif>
                                                {{ _('True') }}</option>
                                            <option value="0" @if (isset($SiteSettings['debugbar']) && $SiteSettings['debugbar'] == '0') selected @endif>
                                                {{ _('False') }}</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'debugbar'])
                                    </div>

                                    <div class="form-group {{ $errors->has('date_format') ? ' has-danger' : '' }} row">
                                        <div class="col-md-6">
                                            <label>{{ _('Date Format') }}</label>
                                            <select name="date_format"
                                                class="form-control no-select  {{ $errors->has('date_format') ? ' is-invalid' : '' }}">
                                                <option value="Y-m-d" @if (isset($SiteSettings['date_format']) && $SiteSettings['date_format'] == 'Y-m-d') selected @endif>
                                                    {{ _('YYYY-MM-DD') }}</option>
                                                <option value="d/m/Y" @if (isset($SiteSettings['date_format']) && $SiteSettings['date_format'] == 'd/m/Y') selected @endif>
                                                    {{ _('DD/MM/YYYY') }}</option>
                                                <option value="m/d/Y" @if (isset($SiteSettings['date_format']) && $SiteSettings['date_format'] == 'm/d/Y') selected @endif>
                                                    {{ _('MM/DD/YYYY') }}</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'date_format'])
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ _('Time Format') }}</label>
                                            <select name="time_format"
                                                class="form-control  no-select {{ $errors->has('time_format') ? ' is-invalid' : '' }}">
                                                <option value="H:i:s" @if (isset($SiteSettings['time_format']) && $SiteSettings['time_format'] == 'H:i:s') selected @endif>
                                                    {{ _('24-hour format (HH:mm:ss)') }}</option>
                                                <option value="h:i:s A" @if (isset($SiteSettings['time_format']) && $SiteSettings['time_format'] == 'h:i:s A') selected @endif>
                                                    {{ _('12-hour format (hh:mm:ss AM/PM)') }}</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'time_format'])
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="card-body">
                                <p class="card-text">
                                    {{ _('General Settings') }}
                                </p>
                                <div class="card-description">
                                    {{ _('The role\'s manages user permissions by assigning different roles to users. Each role defines specific access levels and actions a user can perform. It helps ensure proper authorization and security in the system.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="tab2" class="tabcontent py-3" style="display: none">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">{{ _('Email Settings') }}</h5>
                            </div>
                            <form method="POST" action="{{ route('settings.site_settings') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group {{ $errors->has('mail_mailer') ? ' has-danger' : '' }}">
                                        <label>{{ _('Mailer') }}</label>
                                        <select name="mail_mailer"
                                            class="form-control  no-select  {{ $errors->has('mail_mailer') ? ' is-invalid' : '' }}">
                                            <option value="smtp" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'smtp') selected @endif>SMTP
                                                Mailer</option>
                                            <option value="sendmail" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'sendmail') selected @endif>
                                                Sendmail Mailer</option>
                                            <option value="mailgun" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'mailgun') selected @endif>
                                                Mailgun Mailer</option>
                                            <option value="ses" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'ses') selected @endif>
                                                Amazon SES</option>
                                            <option value="postmark" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'postmark') selected @endif>
                                                Postmark Mailer</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'mail_mailer'])
                                    </div>

                                    <div class="form-group {{ $errors->has('mail_host') ? ' has-danger' : '' }}">
                                        <label>{{ _('Host') }}</label>
                                        <input type="text" name="mail_host"
                                            class="form-control {{ $errors->has('mail_host') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Host') }}"
                                            value="{{ $SiteSettings['mail_host'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'mail_host'])
                                    </div>

                                    <div class="form-group{{ $errors->has('mail_port') ? ' has-danger' : '' }}">
                                        <label>{{ _('Port') }}</label>
                                        <input type="text" name="mail_port"
                                            class="form-control {{ $errors->has('mail_port') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Port') }}"
                                            value="{{ $SiteSettings['mail_port'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'mail_port'])
                                    </div>

                                    <div class="form-group {{ $errors->has('mail_username') ? ' has-danger' : '' }}">
                                        <label>{{ _('Mail Username') }}</label>
                                        <input type="text" name="mail_username"
                                            class="form-control{{ $errors->has('mail_username') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Username') }}"
                                            value="{{ $SiteSettings['mail_username'] ?? '' }}" autocomplete="off">
                                        @include('alerts.feedback', ['field' => 'mail_username'])
                                    </div>

                                    <div class="form-group {{ $errors->has('mail_password') ? ' has-danger' : '' }}">
                                        <label>{{ _('Mail Password') }}</label>
                                        <input type="password" name="mail_password"
                                            class="form-control{{ $errors->has('mail_password') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Mail Password') }}"
                                            value="{{ $SiteSettings['mail_password'] ?? '' }}" autocomplete="off">
                                        @include('alerts.feedback', ['field' => 'mail_password'])
                                    </div>


                                    <div class="form-group {{ $errors->has('mail_encription') ? ' has-danger' : '' }}">
                                        <label>{{ _('Mail Encription') }}</label>
                                        <select name="mail_encription"
                                            class="form-control  no-select {{ $errors->has('mail_encription') ? ' is-invalid' : '' }}">
                                            <option value="ssl" @if (isset($SiteSettings['mail_encription']) && $SiteSettings['mail_encription'] == 'ssl') selected @endif>SSL
                                            </option>
                                            <option value="tls" @if (isset($SiteSettings['mail_encription']) && $SiteSettings['mail_encription'] == 'tls') selected @endif>TLS
                                            </option>
                                            <option value="" @if (isset($SiteSettings['mail_encription']) && $SiteSettings['mail_encription'] == '') selected @endif>None
                                            </option>

                                        </select>
                                        @include('alerts.feedback', ['field' => 'mail_encription'])
                                    </div>


                                    <div class="form-group {{ $errors->has('mail_from') ? ' has-danger' : '' }}">
                                        <label>{{ _('Mail From Address') }}</label>
                                        <input type="email" name="mail_from"
                                            class="form-control {{ $errors->has('mail_from') ? ' is-invalid' : '' }}"
                                            placeholder="noreply@example.com"
                                            value="{{ $SiteSettings['mail_from'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'mail_from'])
                                    </div>


                                    <div class="form-group {{ $errors->has('mail_from_name') ? ' has-danger' : '' }}">
                                        <label>{{ _('Mail From Name') }}</label>
                                        <input type="text" name="mail_from_name"
                                            class="form-control{{ $errors->has('mail_from_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Application Name') }}"
                                            value="{{ $SiteSettings['mail_from_name'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'mail_from_name'])
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="card-body">
                                <p class="card-text">
                                    {{ _('Email Settings') }}
                                </p>
                                <div class="card-description">
                                    {{ _('The role\'s manages user permissions by assigning different roles to users. Each role defines specific access levels and actions a user can perform. It helps ensure proper authorization and security in the system.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab3" class="tabcontent py-3" style="display: none">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">{{ _('Database Settings') }}</h5>
                            </div>
                            <form method="POST" action="{{ route('settings.site_settings') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group {{ $errors->has('database_driver') ? ' has-danger' : '' }}">
                                        <label>{{ _('Database Driver') }}</label>
                                        <select name="database_driver"
                                            class="form-control  no-select {{ $errors->has('database_driver') ? ' is-invalid' : '' }}">
                                            <option value="mysql" @if (isset($SiteSettings['database_driver']) && $SiteSettings['database_driver'] == 'mysql') selected @endif>
                                                MySQL</option>
                                            <option value="pgsql" @if (isset($SiteSettings['database_driver']) && $SiteSettings['database_driver'] == 'pgsql') selected @endif>
                                                PostgreSQL</option>
                                            <option value="sqlite" @if (isset($SiteSettings['database_driver']) && $SiteSettings['database_driver'] == 'sqlite') selected @endif>
                                                SQLite</option>
                                            <option value="sqlsrv" @if (isset($SiteSettings['database_driver']) && $SiteSettings['database_driver'] == 'sqlsrv') selected @endif>SQL
                                                Server</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'database_driver'])
                                    </div>

                                    <div class="form-group {{ $errors->has('database_host') ? ' has-danger' : '' }}">
                                        <label>{{ _('Database Host') }}</label>
                                        <input type="text" name="database_host"
                                            class="form-control {{ $errors->has('database_host') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Database Host') }}"
                                            value="{{ $SiteSettings['database_host'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'database_host'])
                                    </div>

                                    <div class="form-group {{ $errors->has('database_port') ? ' has-danger' : '' }}">
                                        <label>{{ _('Database Port') }}</label>
                                        <input type="text" name="database_port"
                                            class="form-control {{ $errors->has('database_port') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Database Port') }}"
                                            value="{{ $SiteSettings['database_port'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'database_port'])
                                    </div>

                                    <div class="form-group{{ $errors->has('database_name') ? ' has-danger' : '' }}">
                                        <label>{{ _('Database Name') }}</label>
                                        <input type="" name="database_name"
                                            class="form-control {{ $errors->has('database_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Database Name') }}"
                                            value="{{ $SiteSettings['database_name'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'database_name'])
                                    </div>

                                    <div class="form-group {{ $errors->has('database_username') ? ' has-danger' : '' }}">
                                        <label>{{ _('Database Username') }}</label>
                                        <input type="text" name="database_username"
                                            class="form-control{{ $errors->has('database_username') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Database Username') }}"
                                            value="{{ $SiteSettings['database_username'] ?? '' }}" autocomplete="off">
                                        @include('alerts.feedback', ['field' => 'database_username'])
                                    </div>

                                    <div class="form-group {{ $errors->has('database_password') ? ' has-danger' : '' }}">
                                        <label>{{ _('Database Password') }}</label>
                                        <input type="password" name="database_password"
                                            class="form-control{{ $errors->has('database_password') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('Database Password') }}"
                                            value="{{ $SiteSettings['database_password'] ?? '' }}" autocomplete="off">
                                        @include('alerts.feedback', ['field' => 'database_password'])
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="card-body">
                                <p class="card-text">
                                    {{ _('Email Settings') }}
                                </p>
                                <div class="card-description">
                                    {{ _('The role\'s manages user permissions by assigning different roles to users. Each role defines specific access levels and actions a user can perform. It helps ensure proper authorization and security in the system.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab4" class="tabcontent py-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">{{ _('SMS Settings') }}</h5>
                            </div>
                            <form method="POST" action="{{ route('settings.site_settings') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">


                                    <div class="form-group{{ $errors->has('api_key') ? ' has-danger' : '' }}">
                                        <label>{{ _('API KEY') }}</label>
                                        <input type="text" name="api_key"
                                            class="form-control{{ $errors->has('api_key') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('ENTER AND SMS API KEY') }}"
                                            value="{{ $SiteSettings['api_key'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'api_key'])
                                    </div>
                                    <div class="form-group{{ $errors->has('api_secret') ? ' has-danger' : '' }}">
                                        <label>{{ _('API SECRET') }}</label>
                                        <input type="text" name="api_secret"
                                            class="form-control{{ $errors->has('api_secret') ? ' is-invalid' : '' }}"
                                            placeholder="{{ _('ENTER AND SMS API SECRET') }}"
                                            value="{{ $SiteSettings['api_secret'] ?? '' }}">
                                        @include('alerts.feedback', ['field' => 'api_secret'])
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="card-body">
                                <p class="card-text">
                                    {{ _('General Settings') }}
                                </p>
                                <div class="card-description">
                                    {{ _('The role\'s manages user permissions by assigning different roles to users. Each role defines specific access levels and actions a user can perform. It helps ensure proper authorization and security in the system.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@push('js_link')
    <script src="{{ asset('backend/js/site_settings.js') }}"></script>
@endpush
