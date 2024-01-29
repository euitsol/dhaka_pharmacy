@extends('admin.layouts.master', ['pageSlug' => 'admin'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{$document ? 'col-md-8' : 'col-md-12'}} ">
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
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Email')}}</label>
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter email"
                                value="{{ old('email') }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="form-group">
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
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter new password">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{__('Confirm Password')}}</label>
                            <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                placeholder="Confirm password">
                            @include('alerts.feedback', ['field' => 'password_confirmation'])
                        </div>




                        {{-- Add IP  --}}
                        <div class="form-check form-check-inline col-md-12 ps-0 mt-0 mb-3" >
                            <label class="form-check-label mr-2">
                              <input class="form-check-input" type="checkbox" id="checkbox">
                              <span class="form-check-sign"><strong>{{_('Add IP')}}</strong></span>
                            </label>
                        </div>
                        <div id="ip_inputs" class="mt-2" style="display: none;">
                            <div class="form-group">
                                <label>{{ _('IP Address-1') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="ip[]" class="form-control {{ $errors->has('ip.*') ? ' is-invalid' : '' }} ip" placeholder="{{ _('Enter IP address') }}">
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
        @include('admin.partials.documentation',['document'=>$document])
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            var checkbox = $('#checkbox');
            var targetDiv = $('#ip_inputs');

            if (checkbox.is(':checked')) {
                targetDiv.find('.ip').prop('disabled',false);
                targetDiv.show();
                
            }else {
                targetDiv.find('.ip').prop('disabled',true);
                targetDiv.hide();
            }

            checkbox.on('change', function() {
                if (checkbox.is(':checked')) {
                    targetDiv.find('.ip').prop('disabled',false);
                    targetDiv.show();
                    
                } else {
                    targetDiv.find('.ip').prop('disabled',true);
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
            var data = `<div class="form-group ">
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
