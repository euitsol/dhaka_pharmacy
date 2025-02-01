<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Contact Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Reciever Email') }}</label>
                        <input type="text" name="contact_receiver_email"
                            class="form-control{{ $errors->has('contact_receiver_email') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Enter point name') }}"
                            value="{{ $SiteSettings['contact_receiver_email'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'contact_receiver_email'])
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
