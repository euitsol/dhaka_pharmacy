@extends('admin.layouts.master', ['pageSlug' => 'admin'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Admin') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'am.admin.admin_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('am.admin.admin_create') }}">
                        @csrf
                        <div class="form-group">

                            <label>{{__('Name')}}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Email')}}</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email"
                                value="{{ old('email') }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="form-group {{ $errors->has('role') ? ' has-danger' : '' }}">
                            <label>{{ __('Role') }}</label>
                            <select name="role" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}">
                                <option selected hidden>{{ __('Select Role') }}</option>
                                @foreach ($roles as $role)
                                    <option {{ old('role') == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'role'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Password')}}</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Confirm Password')}}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm password">
                        </div>




                        {{-- Add IP  --}}
                        <div class="form-check form-check-inline col-md-12 ps-0 mt-0 mb-3" >
                            <label class="form-check-label mr-2">
                              <input class="form-check-input" type="checkbox" id="checkbox">
                              <span class="form-check-sign"><strong>{{_('Add IP')}}</strong></span>
                            </label>
                        </div>
                        <div id="ip_inputs" class="mt-2" style="display: none;">
                            <div class="form-group {{ $errors->has('ip.*') ? ' has-danger' : '' }}">
                                <label>{{ _('IP Address-1') }}</label>
                                <div class="input-group mb-3">
                                    <input type="tel" name="ip[]" class="form-control {{ $errors->has('ip.*') ? ' is-invalid' : '' }} ip" placeholder="{{ _('Enter IP address') }}">
                                    <span class="btn btn-sm btn-secondary m-0 px-3 add_ip" style="line-height:24px;" data-count="1"><i class="tim-icons icon-simple-add"></i></span>
                                </div>
                                @include('alerts.feedback', ['field' => 'ip.*'])
                            </div>
                        </div>

                        {{-- Add IP  --}}


                        <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="card-header">
                        <b>{{__('User')}}</b>
                    </p>
                    <div class="card-body">
                        <p><b>User Name:</b> This field is required. It is a text field with character limit of 6-255 characters </p>

                        <p><b>Email:</b> This field is required and unique. It is a email field with a maximum character limit of 255. The entered value must follow the standard email format (e.g., user@example.com).</p>

                        <p><b>Password:</b> This field is required. It is a password field. Password strength should meet the specified criteria (e.g., include uppercase and lowercase letters, numbers, and special characters). The entered password should be a minimum of 6 characters.</p>

                        <p><b>Confirm Password:</b> This field is required. It is a password field. It should match the entered password in the "Password" field.</p>

                        <p><b>Role:</b> This field is required. This is an option field. It represents the user's role.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            var checkbox = $('#checkbox');
            var targetDiv = $('#ip_inputs');

            if (checkbox.is(':checked')) {
                targetDiv.show();
                
            }else {
                targetDiv.hide();
            }

            checkbox.on('change', function() {
                if (checkbox.is(':checked')) {
                    targetDiv.show();
                    
                } else {
                    targetDiv.find('.ip').val('');
                    targetDiv.find('.delete_ip').closest('.input-group').parent().remove();
                    targetDiv.hide();
                }
            });
        });
    </script>
    <script>

        $(document).on('click', '.add_ip', function() {
            let count = $(this).data('count') + 1;
            $(this).data('count', count);
            var data = `<div class="form-group {{ $errors->has('ip.*') ? ' has-danger' : '' }}">
                                <label>{{ _('IP Address-${count}') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="ip[]" class="form-control {{ $errors->has('ip.*') ? ' is-invalid' : '' }} ip" placeholder="{{ _('Enter IP address') }}">
                                    <span class="btn btn-sm btn-danger m-0 px-3 delete_ip" style="line-height:24px;" data-count="${count}"><i class="tim-icons icon-trash-simple"></i></span>
                                </div>
                                @include('alerts.feedback', ['field' => 'ip.*'])
                            </div>
                        `;

            // $('.addedField').append(form);
            $(this).closest('#ip_inputs').append(data);
        });

        $(document).on('click', '.delete_ip', function() {
            $(this).closest('.input-group').parent().remove();
        });
    </script>
@endpush
