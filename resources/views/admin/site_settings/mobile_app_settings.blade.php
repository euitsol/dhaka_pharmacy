<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Mobile App Informations') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off">
                @csrf
                <div class="card-body row">

                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('mobile_app_environment') ? ' has-danger' : '' }}">
                            <label>{{ _('App Environment') }}</label>
                            <select name="mobile_app_environment" class="form-control {{ $errors->has('mobile_app_environment') ? ' is-invalid' : '' }}">
                                <option value="production" @if(($SiteSettings['mobile_app_environment'] ?? '') == 'production') selected @endif>Production</option>
                                <option value="local" @if(($SiteSettings['mobile_app_environment'] ?? '') == 'local') selected @endif>Local</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'mobile_app_environment'])
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('maintenance_mode') ? ' has-danger' : '' }}">
                            <label>{{ _('Maintenance Mode') }}</label>
                            <select name="maintenance_mode" class="form-control {{ $errors->has('maintenance_mode') ? ' is-invalid' : '' }}">
                                <option value="true" @if(($SiteSettings['maintenance_mode'] ?? '') == 'true') selected @endif>{{ _('Enabled') }}</option>
                                <option value="false" @if(($SiteSettings['maintenance_mode'] ?? '') == 'false') selected @endif>{{ _('Disabled') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'maintenance_mode'])
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('maintenance_message') ? ' has-danger' : '' }}">
                            <label>{{ _('Maintenance Message') }}</label>
                            <textarea name="maintenance_message"
                                class="form-control {{ $errors->has('maintenance_message') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Service will resume shortly. Thank you for your patience.') }}"
                                rows="3">{{ $SiteSettings['maintenance_message'] ?? null }}</textarea>
                            @include('alerts.feedback', ['field' => 'maintenance_message'])
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('mobile_app_play_store_url') ? ' has-danger' : '' }}">
                            <label>{{ _('Android App Store URL') }}</label>
                            <input type="text" name="mobile_app_play_store_url"
                                class="form-control {{ $errors->has('mobile_app_play_store_url') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('https://play.google.com/store/apps/...') }}" value="{{ $SiteSettings['mobile_app_play_store_url'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'mobile_app_play_store_url'])
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('mobile_app_ios_store_url') ? ' has-danger' : '' }}">
                            <label>{{ _('iOS App Store URL') }}</label>
                            <input type="text" name="mobile_app_ios_store_url"
                                class="form-control {{ $errors->has('mobile_app_ios_store_url') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('https://apps.apple.com/app/...') }}" value="{{ $SiteSettings['mobile_app_ios_store_url'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'mobile_app_ios_store_url'])
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group {{ $errors->has('android_app_version') ? ' has-danger' : '' }}">
                            <label>{{ _('Android App Version') }}</label>
                            <input type="text" name="android_app_version"
                                class="form-control {{ $errors->has('android_app_version') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Example: 1.2.3') }}" value="{{ $SiteSettings['android_app_version'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'android_app_version'])
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group {{ $errors->has('ios_app_version') ? ' has-danger' : '' }}">
                            <label>{{ _('iOS App Version') }}</label>
                            <input type="text" name="ios_app_version"
                                class="form-control {{ $errors->has('ios_app_version') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Example: 2.1.0') }}" value="{{ $SiteSettings['ios_app_version'] ?? '' }}">
                            @include('alerts.feedback', ['field' => 'ios_app_version'])
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->has('mobile_app_force_update') ? ' has-danger' : '' }}">
                            <label>{{ _('Force Update') }}</label>
                            <select name="mobile_app_force_update" class="form-control {{ $errors->has('mobile_app_force_update') ? ' is-invalid' : '' }}">
                                <option value="true" @if(($SiteSettings['mobile_app_force_update'] ?? '') == 'true') selected @endif>{{ _('Enabled') }}</option>
                                <option value="false" @if(($SiteSettings['mobile_app_force_update'] ?? '') == 'false') selected @endif>{{ _('Disabled') }}</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'mobile_app_force_update'])
                        </div>
                    </div>

                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
    @include('admin.partials.documentation', ['document' => $document])
</div>
