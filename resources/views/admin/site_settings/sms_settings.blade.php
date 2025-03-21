<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('SMS Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.sms.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label>{{ __('API URL') }}</label>
                        <input type="text" name="sms_api_url"
                            class="form-control{{ $errors->has('sms_api_url') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Enter sms api url') }}"
                            value="{{ $SiteSettings['sms_api_url'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'sms_api_url'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('API KEY') }}</label>
                        <input type="text" name="sms_api_key"
                            class="form-control{{ $errors->has('sms_api_key') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Enter sms api key') }}"
                            value="{{ $SiteSettings['sms_api_key'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'sms_api_key'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('API SECRET') }}</label>
                        <input type="text" name="sms_api_secret"
                            class="form-control{{ $errors->has('sms_api_secret') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Enter sms api secret') }}"
                            value="{{ $SiteSettings['sms_api_secret'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'sms_api_secret'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('API SENDER ID') }}</label>
                        <input type="text" name="sms_api_sender_id"
                            class="form-control{{ $errors->has('sms_api_sender_id') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Enter sms api sender id') }}"
                            value="{{ $SiteSettings['sms_api_sender_id'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'sms_api_sender_id'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('API STATUS CODE') }}</label>
                        <input type="text" name="sms_api_status_code"
                            class="form-control{{ $errors->has('sms_api_status_code') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Enter sms api secret') }}"
                            value="{{ $SiteSettings['sms_api_status_code'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'sms_api_status_code'])
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
