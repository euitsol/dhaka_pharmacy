<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Notification Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('settings.notification.site_settings') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row text-center">
                        
                        <div class="form-group col-md-3">
                            <label class="d-block">{{ _('Email Verification') }}</label>
                            <input type="checkbox" value="{{$SiteSettings['email_verification'] ?? 0}}" class="valueToggle" name='email_verification' data-toggle="toggle" data-onlabel="ON" data-offlabel="OFF" data-onstyle="success" data-offstyle="danger" data-style="ios">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="d-block">{{ _('SMS Verification') }}</label>
                            <input type="checkbox" value="{{$SiteSettings['sms_verification'] ?? 0}}" class="valueToggle" name='sms_verification' data-toggle="toggle" data-onlabel="ON" data-offlabel="OFF" data-onstyle="success" data-offstyle="danger" data-style="ios">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="d-block">{{ _('User Registration') }}</label>
                            <input type="checkbox" value="{{$SiteSettings['user_registration'] ?? 0}}" class="valueToggle" name='user_registration' data-toggle="toggle" data-onlabel="ON" data-offlabel="OFF" data-onstyle="success" data-offstyle="danger" data-style="ios">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="d-block">{{ _('User KYC') }}</label>
                            <input type="checkbox" value="{{$SiteSettings['user_kyc'] ?? 0}}" class="valueToggle" name='user_kyc' data-toggle="toggle" data-onlabel="ON" data-offlabel="OFF" data-onstyle="success" data-offstyle="danger" data-style="ios">
                        </div>
                    </div>



                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-user">
            <div class="card-body">
                <p class="card-text">
                    {{ _('General Settings') }}
                </p>
                <div class="card-description">
                    {{ _('The role\'s manages user permissions by assigning different roles to users. Each role defines specific access levels and actions a user can perform. It helps ensure proper authorization and security in the system.') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Set the initial state of the checkbox based on the value
            $('.valueToggle').each(function() {
                if ($(this).val() == 1) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            $('.valueToggle').change(function() {
                $(this).val($(this).prop('checked') ? 1 : 0);
            });
        });
    </script>
@endpush
