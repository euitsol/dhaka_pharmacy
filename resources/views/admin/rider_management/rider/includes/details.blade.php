<table class="table table-striped">
    <tbody>
        <tr>
            <td class="fw-bolder">{{ __('Full Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->name }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Father Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->father_name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Mother Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->mother_name ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Phone') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->phone }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->emergency_phone ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Birth Date') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->dob ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Age') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->age ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Identification Type') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->identificationType() ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Identification No') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->identification_no ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Gender') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->getGender() ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Operational Area') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $rider->operation_area->name ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $rider->getStatusBadgeClass() }}">{{ $rider->getStatus() }}</span>
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('KYC Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $rider->getKycStatusClass() }}">{{ $rider->getKycStatus() }}</span>
            </td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Phone Verify') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $rider->getPhoneVerifyClass() }}">{{ $rider->getPhoneVerifyStatus() }}</span>
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Present Address') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $rider->present_address ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Present Address') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $rider->permanent_address ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('CV') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">
                @if (!empty($rider->cv))
                    <a class="btn btn-primary" target="_blank"
                        href="{{ route('rm.rider.download.rider_profile', base64_encode($rider->cv)) }}"><i
                            class="fa-solid fa-download"></i></a>
                @else
                    {{ __('--') }}
                @endif
            </td>
        </tr>
    </tbody>
</table>
