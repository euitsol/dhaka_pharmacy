<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('SMS Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
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
    @include('admin.partials.documentation',['document'=>$document])
</div>