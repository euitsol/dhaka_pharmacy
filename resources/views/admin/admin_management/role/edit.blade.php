@extends('admin.layouts.master', ['pageSlug' => 'role'])

@section('title', 'Edit Role')

@push('css')
    <style>
        .groupName {
            background: #cdcdcd;
            border-bottom: 2px solid #182456;
            font-weight: bold;
            text-transform: uppercase;
        }

        .groupName label {
            color: #000;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .list-items li {
            list-style: none;
            background: #cdcdcd;
            border-bottom: 2px solid #182456;
        }

        .list-items li label {
            color: #000;
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
@endpush

@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Update Role') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'am.role.role_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('am.role.role_edit', $role->id) }}" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label>{{ _('Role Name') }}</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Name') }}" value="{{ $role->name }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="row">
                            @foreach ($groupedPermissions->chunk(count($groupedPermissions) / 2) as $chunks)
                                <div class="col-md-3">
                                    @foreach ($chunks as $prefix => $permissions)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="m-0 pl-4 groupName">
                                                    <input type="checkbox" class="prefix-checkbox"
                                                        id="prefix-checkbox-{{ $prefix }}"
                                                        data-prefix="{{ $prefix }}">
                                                    <label
                                                        for="prefix-checkbox-{{ $prefix }}">{{ $prefix }}</label>
                                                </h3>
                                                <ul class="list-items">
                                                    @foreach ($permissions as $permission)
                                                        <li class="pl-4">
                                                            <input type="checkbox" name="permissions[]"
                                                                id="permission-checkbox-{{ $permission->id }}"
                                                                value="{{ $permission->id }}" class="permission-checkbox"
                                                                @if ($role->hasPermissionTo($permission->name)) @checked(true) @endif>
                                                            <label
                                                                for="permission-checkbox-{{ $permission->id }}">{{ Str::replace('_', ' ', $permission->name) }}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ _('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p class="card-header">
                        <b>User</b>
                    </p>
                    <div class="card-body">
                        <p><b>User Name:</b> This field is required. It is a text field with character limit of 6-255
                            characters </p>

                        <p><b>Email:</b> This field is required and unique. It is a email field with a maximum character
                            limit of 255. The entered value must follow the standard email format (e.g., user@example.com).
                        </p>

                        <p><b>Password:</b> This field is required. It is a password field. Password strength should meet
                            the specified criteria (e.g., include uppercase and lowercase letters, numbers, and special
                            characters). The entered password should be a minimum of 6 characters.</p>

                        <p><b>Confirm Password:</b> This field is required. It is a password field. It should match the
                            entered password in the "Password" field.</p>

                        <p><b>Role:</b> This field is required. This is an option field. It represents the user's role.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.prefix-checkbox').each(function() {
                var allBox = $(this).closest('h3').next('ul').find('.permission-checkbox');
                var allChecked = allBox.length === allBox.filter(':checked').length;
                $(this).prop('checked', allChecked);
            });
            $('.prefix-checkbox').on('click', function() {
                var prefix = $(this).data('prefix');
                var permissionCheckboxes = $(this).closest('h3').next('ul').find('.permission-checkbox');
                var isChecked = $(this).prop('checked');

                permissionCheckboxes.prop('checked', isChecked);

            });


            $('.permission-checkbox').on('click', function() {
                var checkboxId = $(this).attr('id');
                var prefix = $(this).closest('ul').prev('h3').find('.prefix-checkbox');
                var permissionCheckboxes = $(this).closest('ul').find('.permission-checkbox');
                var isAllChecked = permissionCheckboxes.length === permissionCheckboxes.filter(':checked')
                    .length;

                prefix.prop('checked', isAllChecked);
            });

            // Handle click event on text elements
            $('label[for^="permission-checkbox-"]').on('click', function() {
                var checkboxId = $(this).attr('for');
                $('#' + checkboxId).prop('checked'); // Trigger the associated checkbox click event
            });
            $('label[for^="permission-checkbox-"]').on('click', function() {
                var checkboxId = $(this).attr('for');
                $('#' + checkboxId).prop('checked'); // Trigger the associated checkbox click event
            });
        });
    </script>
@endpush
