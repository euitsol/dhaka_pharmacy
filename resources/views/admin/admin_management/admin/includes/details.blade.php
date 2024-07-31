<table class="table table-striped">
    <tbody>
        <tr>
            <td class="fw-bolder">{{ __('Full Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->name }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Father Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->father_name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Mother Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->mother_name ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Role') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->role->name }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Phone') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->phone ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Email') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->email ?? '--' }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->parent_phone ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Birth Date') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->dob ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Age') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->age ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Identification Type') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->identification_type ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Identification No') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->identification_no ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Gender') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->gender ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Operational Area') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $admin->operation_area->name ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $admin->getStatusBadgeClass() }}">{{ $admin->getStatus() }}</span>
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('KYC Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $admin->getKycStatusClass() }}">{{ $admin->getKycStatus() }}</span>
            </td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Phone Verify') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $admin->getPhoneVerifyClass() }}">{{ $admin->getPhoneVerifyStatus() }}</span>
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Present Address') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $admin->present_address ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Present Address') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $admin->permanent_address ?? '--' }}</td>
        </tr>
    </tbody>
</table>
