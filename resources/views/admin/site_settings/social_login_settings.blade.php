<div class="card">
    <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h4 class="title">{{ __('Socail Login Facebook API') }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group {{ $errors->has('fb_client_id') ? ' has-danger' : '' }}">
                <label>{{ _('Client ID') }}</label>
                <input type="text" name="fb_client_id"
                    class="form-control {{ $errors->has('fb_client_id') ? ' is-invalid' : '' }}"
                    placeholder="{{ _('Client ID') }}" value="{{ $SiteSettings['fb_client_id'] ?? '' }}">
                @include('alerts.feedback', ['field' => 'fb_client_id'])
            </div>

            <div class="form-group{{ $errors->has('fb_client_secret') ? ' has-danger' : '' }}">
                <label>{{ _('Client Secret') }}</label>
                <input type="text" name="fb_client_secret"
                    class="form-control {{ $errors->has('fb_client_secret') ? ' is-invalid' : '' }}"
                    placeholder="{{ _('Client Secret') }}" value="{{ $SiteSettings['fb_client_secret'] ?? '' }}">
                @include('alerts.feedback', ['field' => 'fb_client_secret'])
            </div>

            <div class="form-group {{ $errors->has('fb_redirect_url') ? ' has-danger' : '' }}">
                <label>{{ _('Redurect URL') }}</label>
                <input type="text" name="fb_redirect_url"
                    class="form-control{{ $errors->has('fb_redirect_url') ? ' is-invalid' : '' }}"
                    placeholder="{{ _('Redirect URL') }}" value="{{ $SiteSettings['fb_redirect_url'] ?? '' }}"
                    autocomplete="off">
                @include('alerts.feedback', ['field' => 'fb_redirect_url'])
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
        </div>
    </form>
</div>
<div class="card">
    <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h4 class="title">{{ __('Socail Login Google API') }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group {{ $errors->has('google_client_id') ? ' has-danger' : '' }}">
                <label>{{ _('Client ID') }}</label>
                <input type="text" name="google_client_id"
                    class="form-control {{ $errors->has('google_client_id') ? ' is-invalid' : '' }}"
                    placeholder="{{ _('Client ID') }}" value="{{ $SiteSettings['google_client_id'] ?? '' }}">
                @include('alerts.feedback', ['field' => 'google_client_id'])
            </div>

            <div class="form-group{{ $errors->has('google_client_secret') ? ' has-danger' : '' }}">
                <label>{{ _('Client Secret') }}</label>
                <input type="text" name="google_client_secret"
                    class="form-control {{ $errors->has('google_client_secret') ? ' is-invalid' : '' }}"
                    placeholder="{{ _('Client Secret') }}" value="{{ $SiteSettings['google_client_secret'] ?? '' }}">
                @include('alerts.feedback', ['field' => 'google_client_secret'])
            </div>

            <div class="form-group {{ $errors->has('google_redirect_url') ? ' has-danger' : '' }}">
                <label>{{ _('Redurect URL') }}</label>
                <input type="text" name="google_redirect_url"
                    class="form-control{{ $errors->has('google_redirect_url') ? ' is-invalid' : '' }}"
                    placeholder="{{ _('Redirect URL') }}" value="{{ $SiteSettings['google_redirect_url'] ?? '' }}"
                    autocomplete="off">
                @include('alerts.feedback', ['field' => 'google_redirect_url'])
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
        </div>
    </form>
</div>
