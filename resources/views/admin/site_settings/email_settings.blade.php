<div class="row">
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Email Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group {{ $errors->has('mail_mailer') ? ' has-danger' : '' }}">
                        <label>{{ __('Mailer') }}</label>
                        <select name="mail_mailer"
                            class="form-control  no-select  {{ $errors->has('mail_mailer') ? ' is-invalid' : '' }}">
                            <option value="smtp" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'smtp') selected @endif>
                                {{ __('SMTP Mailer') }}</option>
                            <option value="sendmail" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'sendmail') selected @endif>
                                {{ __('Sendmail Mailer') }}</option>
                            <option value="mailgun" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'mailgun') selected @endif>
                                {{ __('Mailgun Mailer') }}</option>
                            <option value="ses" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'ses') selected @endif>
                                {{ __('Amazon SES') }}</option>
                            <option value="postmark" @if (isset($SiteSettings['mail_mailer']) && $SiteSettings['mail_mailer'] == 'postmark') selected @endif>
                                {{ __('Postmark Mailer') }}</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'mail_mailer'])
                    </div>

                    <div class="form-group {{ $errors->has('mail_host') ? ' has-danger' : '' }}">
                        <label>{{ __('Host') }}</label>
                        <input type="text" name="mail_host"
                            class="form-control {{ $errors->has('mail_host') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Host') }}" value="{{ $SiteSettings['mail_host'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'mail_host'])
                    </div>

                    <div class="form-group{{ $errors->has('mail_port') ? ' has-danger' : '' }}">
                        <label>{{ __('Port') }}</label>
                        <input type="text" name="mail_port"
                            class="form-control {{ $errors->has('mail_port') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Port') }}" value="{{ $SiteSettings['mail_port'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'mail_port'])
                    </div>

                    <div class="form-group {{ $errors->has('mail_username') ? ' has-danger' : '' }}">
                        <label>{{ __('Mail Username') }}</label>
                        <input type="text" name="mail_username"
                            class="form-control{{ $errors->has('mail_username') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Username') }}" value="{{ $SiteSettings['mail_username'] ?? '' }}"
                            autocomplete="off">
                        @include('alerts.feedback', ['field' => 'mail_username'])
                    </div>

                    <div class="form-group {{ $errors->has('mail_password') ? ' has-danger' : '' }}">
                        <label>{{ __('Mail Password') }}</label>
                        <input type="password" name="mail_password"
                            class="form-control{{ $errors->has('mail_password') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Mail Password') }}" value="{{ $SiteSettings['mail_password'] ?? '' }}"
                            autocomplete="off">
                        @include('alerts.feedback', ['field' => 'mail_password'])
                    </div>


                    <div class="form-group {{ $errors->has('mail_encription') ? ' has-danger' : '' }}">
                        <label>{{ __('Mail Encription') }}</label>
                        <select name="mail_encription"
                            class="form-control  no-select {{ $errors->has('mail_encription') ? ' is-invalid' : '' }}">
                            <option value="ssl" @if (isset($SiteSettings['mail_encription']) && $SiteSettings['mail_encription'] == 'ssl') selected @endif>
                                {{ __('SSL') }}
                            </option>
                            <option value="tls" @if (isset($SiteSettings['mail_encription']) && $SiteSettings['mail_encription'] == 'tls') selected @endif>
                                {{ __('TLS') }}
                            </option>
                            <option value="" @if (isset($SiteSettings['mail_encription']) && $SiteSettings['mail_encription'] == '') selected @endif>
                                {{ __('None') }}
                            </option>

                        </select>
                        @include('alerts.feedback', ['field' => 'mail_encription'])
                    </div>


                    <div class="form-group {{ $errors->has('mail_from') ? ' has-danger' : '' }}">
                        <label>{{ __('Mail From Address') }}</label>
                        <input type="email" name="mail_from"
                            class="form-control {{ $errors->has('mail_from') ? ' is-invalid' : '' }}"
                            placeholder="noreply@example.com" value="{{ $SiteSettings['mail_from'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'mail_from'])
                    </div>


                    <div class="form-group {{ $errors->has('mail_from_name') ? ' has-danger' : '' }}">
                        <label>{{ __('Mail From Name') }}</label>
                        <input type="text" name="mail_from_name"
                            class="form-control{{ $errors->has('mail_from_name') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Application Name') }}"
                            value="{{ $SiteSettings['mail_from_name'] ?? '' }}">
                        @include('alerts.feedback', ['field' => 'mail_from_name'])
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
