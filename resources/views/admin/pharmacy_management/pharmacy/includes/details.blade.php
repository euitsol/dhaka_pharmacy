<div class="row details">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td class="fw-bolder">{{ __('Full Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->name }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Phone') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->phone }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->parent_phone ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Identification Type') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->identification_type ?? '--' }}</td>

            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Identification No') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->identification_no ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Operational Area') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->operation_area->name ?? '--' }}</td>

            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Operational Sub Area') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->operation_sub_area->name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $pharmacy->getStatusBadgeClass() }}">{{ $pharmacy->getStatus() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Email Verify') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span
                        class="{{ $pharmacy->getEmailVerifyClass() }}">{{ $pharmacy->getEmailVerifyStatus() }}</span>
                </td>
                <td>|</td>
                <td class="fw-bolder">{{ __('KYC Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $pharmacy->getKycStatusClass() }}">{{ $pharmacy->getKycStatus() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Present Address') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">{{ $pharmacy->present_address ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Present Address') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">{{ $pharmacy->permanent_address ?? '--' }}</td>
            </tr>
        </tbody>
    </table>
</div>
