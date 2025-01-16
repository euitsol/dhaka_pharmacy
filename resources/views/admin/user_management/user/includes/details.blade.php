<table class="table table-striped">
    <tbody>
        <tr>
            <td class="fw-bolder">{{ __('Full Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->name }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Father Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->father_name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Mother Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->mother_name ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Phone') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->phone }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->emergency_phone ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Birth Date') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->dob ?? '--' }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Age') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->age ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Identification Type') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->identificationType() ?? '--' }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Identification No') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->identification_no ?? '--' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Gender') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->getGender() ?? '--' }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Added By') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $user->creater ? $user->creater->name : $user->name }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $user->getStatusBadgeClass() }}">{{ $user->getStatus() }}</span>
            </td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('KYC Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $user->getKycStatusClass() }}">{{ $user->getKycStatus() }}</span>
            </td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Phone Verify') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $user->getPhoneVerifyClass() }}">{{ $user->getPhoneVerifyStatus() }}</span>
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Identification File') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">
                @if (!empty($user->identification_file))
                    <a class="btn btn-primary" target="_blank"
                        href="{{ route('um.user.download.user_profile', base64_encode($user->identification_file)) }}"><i
                            class="fa-solid fa-download"></i></a>
                @else
                    {{ __('--') }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Bio') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $user->bio ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Present Address') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $user->present_address ?? '--' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Present Address') }}</td>
            <td>{{ __(':') }}</td>
            <td colspan="5">{{ $user->permanent_address ?? '--' }}</td>
        </tr>
    </tbody>
</table>
