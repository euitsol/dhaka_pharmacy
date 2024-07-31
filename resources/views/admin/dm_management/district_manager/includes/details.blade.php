<div class="row details">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td class="fw-bolder">{{ __('Full Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->name }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Father Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->father_name ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Mother Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->mother_name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Phone') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->phone }}</td>

            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->parent_phone ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Birth Date') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->dob ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Age') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->age ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Identification Type') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->identification_type ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Identification No') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->identification_no ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Gender') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->gender ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Operational Area') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $dm->operation_area->name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $dm->getStatusBadgeClass() }}">{{ $dm->getStatus() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('KYC Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $dm->getKycStatusClass() }}">{{ $dm->getKycStatus() }}</span>
                </td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Phone Verify') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $dm->getPhoneVerifyClass() }}">{{ $dm->getPhoneVerifyStatus() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Present Address') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">{{ $dm->present_address ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Present Address') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">{{ $dm->permanent_address ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('CV') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">
                    @if (!empty($dm->cv))
                        <a class="btn btn-primary" target="_blank"
                            href="{{ route('dm_management.district_manager.download.district_manager_profile', base64_encode($dm->cv)) }}"><i
                                class="fa-solid fa-download"></i></a>
                    @else
                        {{ __('--') }}
                    @endif
                </td>
            </tr>
            {{-- @if (!empty($dm->cv))
                <tr>
                    <td colspan="7">
                        <iframe src="{{ pdf_storage_url($dm->cv) }}" width="100%" height="600px"></iframe>
                    </td>
                </tr>
            @endif --}}
        </tbody>
    </table>
</div>
