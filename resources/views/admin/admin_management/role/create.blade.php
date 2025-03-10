@extends('admin.layouts.master', ['pageSlug' => 'role'])
@section('title', 'Create Role')
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
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Create Role') }}</h4>
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
                <form method="POST" action="{{ route('am.role.role_create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">

                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter role name"
                                value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>

                        <div class="row">
                            @foreach ($groupedPermissions->chunk(1) as $chunks)
                                <div class="col-md-3">
                                    @foreach ($chunks as $prefix => $permissions)
                                        <h3 class="m-0 pl-4 groupName">
                                            <input type="checkbox" class="prefix-checkbox"
                                                id="prefix-checkbox-{{ $prefix }}" data-prefix="{{ $prefix }}">
                                            <label for="prefix-checkbox-{{ $prefix }}">{{ $prefix }}</label>
                                        </h3>
                                        <ul class="list-items">
                                            @foreach ($permissions as $permission)
                                                <li class="pl-4">
                                                    <input type="checkbox" name="permissions[]"
                                                        id="permission-checkbox-{{ $permission->id }}"
                                                        value="{{ $permission->id }}" class="permission-checkbox">
                                                    <label
                                                        for="permission-checkbox-{{ $permission->id }}">{{ Str::replace('_', ' ', $permission->name) }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Create') }}</button>
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
            $('label[for^="permission-checkbox-"]').on('click', function() {
                var checkboxId = $(this).attr('for');
                $('#' + checkboxId).prop('checked');
            });
            $('label[for^="permission-checkbox-"]').on('click', function() {
                var checkboxId = $(this).attr('for');
                $('#' + checkboxId).prop('checked');
            });
        });
    </script>
@endpush
