<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('SMS Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.sms.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label>{{ _('API URL') }}</label>
                        <input type="text" name="api_url"
                            class="form-control{{ $errors->has('api_url') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('Enter sms api url') }}" value="{{ $SiteSettings['api_url'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'api_url'])
                    </div>
                    <div class="form-group">
                        <label>{{ _('API KEY') }}</label>
                        <input type="text" name="api_key"
                            class="form-control{{ $errors->has('api_key') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('Enter sms api key') }}" value="{{ $SiteSettings['api_key'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'api_key'])
                    </div>
                    <div class="form-group">
                        <label>{{ _('API SECRET') }}</label>
                        <input type="text" name="api_secret"
                            class="form-control{{ $errors->has('api_secret') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('Enter sms api secret') }}"
                            value="{{ $SiteSettings['api_secret'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'api_secret'])
                    </div>
                    <div class="form-group">
                        <label>{{ _('API SENDER ID') }}</label>
                        <input type="text" name="api_sender_id"
                            class="form-control{{ $errors->has('api_sender_id') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('Enter sms api sender id') }}"
                            value="{{ $SiteSettings['api_sender_id'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'api_sender_id'])
                    </div>
                    <div class="form-group">
                        <label>{{ _('API STATUS CODE') }}</label>
                        <input type="text" name="api_status_code"
                            class="form-control{{ $errors->has('api_status_code') ? ' is-invalid' : '' }}"
                            placeholder="{{ _('Enter sms api secret') }}"
                            value="{{ $SiteSettings['api_status_code'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'api_status_code'])
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
