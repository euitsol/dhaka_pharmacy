<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Database Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
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
    @include('admin.partials.documentation',['document'=>$document])
</div>