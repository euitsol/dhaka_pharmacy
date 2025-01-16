<table class="table table-striped">
    <tbody>
        <tr>
            <td class="fw-bolder">{{ __('Full Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->name }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Role') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->role->name }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Email') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->email ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $admin->getStatusBadgeClass() }}">{{ $admin->getStatus() }}</span>
            </td>
        </tr>
    </tbody>
</table>
