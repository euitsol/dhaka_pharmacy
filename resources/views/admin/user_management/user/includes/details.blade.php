<div class="row details">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td class="fw-bolder">{{ __('Full Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->name }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Designation') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->designation ?? 'General User' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Father Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->father_name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Mother Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->mother_name ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Phone') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->phone }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->parent_phone ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Birth Date') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->dob ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Age') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->age ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Identification Type') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->identification_type ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Identification No') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->identification_no ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Gender') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->gender ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Added By') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $user->creater ? $user->creater->name : $user->name }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $user->getStatusBadgeClass() }}">{{ $user->getStatus() }}</span>
                </td>
                <td>|</td>
                <td class="fw-bolder">{{ __('KYC Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $user->getKycStatusClass() }}">{{ $user->getKycStatus() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Phone Verify') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">
                    <span class="{{ $user->getPhoneVerifyClass() }}">{{ $user->getPhoneVerifyStatus() }}</span>
                </td>
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
            <tr>
                <td class="fw-bolder">{{ __('CV') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">
                    @if (!empty($user->cv))
                        <a class="btn btn-primary" target="_blank"
                            href="{{ route('dm_management.district_manager.download.district_manager_profile', base64_encode($user->cv)) }}"><i
                                class="fa-solid fa-download"></i></a>
                    @else
                        {{ __('--') }}
                    @endif
                </td>
            </tr>
            {{-- @if (!empty($user->cv))
                <tr>
                    <td colspan="7">
                        <iframe src="{{ pdf_storage_url($user->cv) }}" width="100%" height="600px"></iframe>
                    </td>
                </tr>
            @endif --}}
        </tbody>
    </table>
</div>