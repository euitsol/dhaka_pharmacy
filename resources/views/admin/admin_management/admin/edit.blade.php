@extends('admin.layouts.master', ['pageSlug' => 'admin'])
@section('title', 'Edit Admin')
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Edit Admin') }}</h4>
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
                <form method="POST" action="{{ route('am.admin.admin_edit', $admin->id) }}">
                    @csrf
                    <div class="card-body">
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Enter name') }}" value="{{ $admin->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="email"
                                class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Enter email') }}" value="{{ $admin->email }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Role') }}</label>
                            <select name="role" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}">
                                @foreach ($roles as $role)
                                    <option {{ $admin->role->id == $role->id ? 'selected' : '' }}
                                        value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'role'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Enter new password') }}">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation"
                                class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Confirm password') }}">
                            @include('alerts.feedback', ['field' => 'password_confirmation'])
                        </div>
                        {{-- Add IP  --}}
                        <div class="form-check form-check-inline col-md-12 ps-0 mt-0 mb-3">
                            <label class="form-check-label mr-2">
                                <input class="form-check-input" type="checkbox" id="checkbox"
                                    @if (is_array(json_decode($admin->ip, true)) && !empty(json_decode($admin->ip, true))) checked @endif>
                                <span class="form-check-sign"><strong>{{ __('Add IP') }}</strong></span>
                            </label>
                        </div>
                        <div id="ip_inputs" class="mt-2" style="display: none;">
                            @if (is_array(json_decode($admin->ip, true)))
                                @foreach (json_decode($admin->ip, true) as $key => $ip)
                                    <div class="form-group">
                                        <label>{{ __('IP Address-' . $key + 1) }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="ip[]"
                                                class="form-control {{ $errors->has('ip') ? ' is-invalid' : '' }}"
                                                value="{{ $ip }}">
                                            @if ($key > 0)
                                                <span class="btn btn-sm btn-danger m-0 px-3 delete_ip"
                                                    style="line-height:24px;" data-count="{{ $key + 1 }}"><i
                                                        class="tim-icons icon-trash-simple"></i></span>
                                            @else
                                                <span class="btn btn-sm btn-secondary m-0 px-3 add_ip"
                                                    style="line-height:24px;"
                                                    data-count="{{ count(json_decode($admin->ip, true)) }}"><i
                                                        class="tim-icons icon-simple-add"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="form-group">
                                    <label>{{ __('IP Address-1') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="ip[]"
                                            class="form-control {{ $errors->has('ip.*') ? ' is-invalid' : '' }} ip"
                                            placeholder="{{ __('Enter IP address') }}">
                                        <span class="btn btn-sm btn-secondary m-0 px-3 add_ip" style="line-height:24px;"
                                            data-count="1"><i class="tim-icons icon-simple-add"></i></span>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'ip.*'])
                                </div>
                            @endif

                        </div>

                        {{-- Add IP  --}}

                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var checkbox = $('#checkbox');
            var targetDiv = $('#ip_inputs');

            if (checkbox.is(':checked')) {
                targetDiv.find('.ip').prop('disabled', false);
                targetDiv.show();


            } else {
                targetDiv.find('.ip').prop('disabled', true);
                targetDiv.hide();
            }

            checkbox.on('change', function() {
                if (checkbox.is(':checked')) {
                    targetDiv.find('.ip').prop('disabled', false);
                    targetDiv.show();

                } else {
                    targetDiv.find('.ip').prop('disabled', true);
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
            var data = `<div class="form-group">
                                <label>{{ __('IP Address-${count}') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="ip[]" class="form-control {{ $errors->has('ip.*') ? ' is-invalid' : '' }} ip" placeholder="{{ __('Enter IP address') }}">
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
