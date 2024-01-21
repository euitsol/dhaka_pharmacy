<div class="row">
    <div class="{{ isset($document->title) ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Email Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.update.site_settings') }}" autocomplete="off"
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
    @include('admin.partials.documentation',['document'=>$document])
</div>