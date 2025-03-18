<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('General Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group{{ $errors->has('site_name') ? ' has-danger' : '' }}">
                        <label>{{ __('Site Name') }}</label>
                        <input type="text" name="site_name"
                            class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Site Name') }}" value="{{ $SiteSettings['site_name'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'site_name'])
                    </div>

                    <div class="form-group{{ $errors->has('site_short_name') ? ' has-danger' : '' }}">
                        <label>{{ __('Site Short Name') }}</label>
                        <input type="text" name="site_short_name"
                            class="form-control{{ $errors->has('site_short_name') ? ' is-invalid' : '' }} "
                            placeholder="{{ __('Site Short Name') }}"
                            value="{{ $SiteSettings['site_short_name'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'site_short_name'])
                    </div>

                    <div class="form-group{{ $errors->has('timezone') ? ' has-danger' : '' }}">
                        <label>{{ __('Timezone') }}</label>
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
                        <label>{{ __('Site Logo') }}</label>
                        <input type="file" name="site_logo"
                            class="form-control {{ $errors->has('site_logo') ? ' is-invalid' : '' }} image-upload"
                            @if (isset($SiteSettings['site_logo'])) data-existing-files="{{ storage_url($SiteSettings['site_logo']) }}" data-delete-url="" @endif
                            accept="image/*">
                        @include('alerts.feedback', ['field' => 'site_logo'])
                    </div>

                    <div class="form-group{{ $errors->has('site_favicon') ? ' has-danger' : '' }}">
                        <label>{{ __('Site Favicon 16*16') }}</label>

                        <input type="file" name="site_favicon"
                            class="form-control {{ $errors->has('site_favicon') ? ' is-invalid' : '' }} image-upload"
                            @if (isset($SiteSettings['site_favicon'])) data-existing-files="{{ storage_url($SiteSettings['site_favicon']) }}" data-delete-url="{{ storage_url($SiteSettings['site_favicon']) }}" @endif
                            accept="image/*">
                        @include('alerts.feedback', ['field' => 'site_favicon'])
                    </div>

                    <div class="form-group{{ $errors->has('env') ? ' has-danger' : '' }}">
                        <label>{{ __('Environment') }}
                            <small>({{ __('Best to keep in production') }})</small></label>
                        <select name="env" class="form-control{{ $errors->has('env') ? ' is-invalid' : '' }}">
                            <option value="production" @if (isset($SiteSettings['env']) && $SiteSettings['env'] == 'production') selected @endif>
                                {{ __('Production') }}</option>
                            <option value="local" @if (isset($SiteSettings['env']) && $SiteSettings['env'] == 'local') selected @endif>
                                {{ __('Local') }}</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'env'])
                    </div>

                    <div class="form-group{{ $errors->has('debug') ? ' has-danger' : '' }}">
                        <label>{{ __('App Debug') }}
                            <small>({{ __('Best to keep in false') }})</small></label>
                        <select name="debug"
                            class="form-control no-select {{ $errors->has('debug') ? ' is-invalid' : '' }}">
                            <option value="1" @if (isset($SiteSettings['debug']) && $SiteSettings['debug'] == '1') selected @endif>
                                {{ __('True') }}</option>
                            <option value="0" @if (isset($SiteSettings['debug']) && $SiteSettings['debug'] == '0') selected @endif>
                                {{ __('False') }}</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'debug'])
                    </div>

                    <div class="form-group {{ $errors->has('debugbar') ? ' has-danger' : '' }}">
                        <label>{{ __('Enable Debugbar') }}
                            <small>({{ __('Best to keep in false') }})</small></label>
                        <select name="debugbar"
                            class="form-control no-select  {{ $errors->has('debugbar') ? ' is-invalid' : '' }}">
                            <option value="1" @if (isset($SiteSettings['debugbar']) && $SiteSettings['debugbar'] == '1') selected @endif>
                                {{ __('True') }}</option>
                            <option value="0" @if (isset($SiteSettings['debugbar']) && $SiteSettings['debugbar'] == '0') selected @endif>
                                {{ __('False') }}</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'debugbar'])
                    </div>

                    <div class="form-group {{ $errors->has('date_format') ? ' has-danger' : '' }} row">
                        <div class="col-md-6">
                            <label>{{ __('Date Format') }}</label>
                            <select name="date_format"
                                class="form-control no-select  {{ $errors->has('date_format') ? ' is-invalid' : '' }}">
                                <option value="Y-m-d" @if (isset($SiteSettings['date_format']) && $SiteSettings['date_format'] == 'Y-m-d') selected @endif>
                                    {{ __('YYYY-MM-DD') }}</option>
                                <option value="d/m/Y" @if (isset($SiteSettings['date_format']) && $SiteSettings['date_format'] == 'd/m/Y') selected @endif>
                                    {{ __('DD/MM/YYYY') }}</option>
                                <option value="m/d/Y" @if (isset($SiteSettings['date_format']) && $SiteSettings['date_format'] == 'm/d/Y') selected @endif>
                                    {{ __('MM/DD/YYYY') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'date_format'])
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('Time Format') }}</label>
                            <select name="time_format"
                                class="form-control  no-select {{ $errors->has('time_format') ? ' is-invalid' : '' }}">
                                <option value="H:i:s" @if (isset($SiteSettings['time_format']) && $SiteSettings['time_format'] == 'H:i:s') selected @endif>
                                    {{ __('24-hour format (HH:mm:ss)') }}</option>
                                <option value="h:i:s A" @if (isset($SiteSettings['time_format']) && $SiteSettings['time_format'] == 'h:i:s A') selected @endif>
                                    {{ __('12-hour format (hh:mm:ss AM/PM)') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'time_format'])
                        </div>
                    </div>

                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
    @include('admin.partials.documentation', ['document' => $document])
</div>
