<div class="row details">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td class="fw-bolder">{{ __('Full Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->name }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Designation') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->designation ?? 'Local Area Manager' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Father Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->father_name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Mother Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->mother_name ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Phone') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->phone }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->parent_phone ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Birth Date') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->dob ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Age') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->age ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Identification Type') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->identification_type ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Identification No') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->identification_no ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Gender') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->gender ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('District Manager') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->dm->name }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Operational Area') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $lam->dm->operation_area->name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Operational Area') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    {{ $lam->operation_sub_area->name ?? '<span class="badge badge-warning">__("Area not allocated")</span>' }}
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $lam->getStatusBadgeClass() }}">{{ $lam->getStatus() }}</span>
                </td>
                <td>|</td>
                <td class="fw-bolder">{{ __('KYC Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $lam->getKycStatusClass() }}">{{ $lam->getKycStatus() }}</span>
                </td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Present Address') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">{{ $lam->present_address ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Present Address') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">{{ $lam->permanent_address ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('CV') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">
                    @if (!empty($lam->cv))
                        <a class="btn btn-primary" target="_blank"
                            href="{{ route('dm_management.district_manager.download.district_manager_profile', base64_encode($lam->cv)) }}"><i
                                class="fa-solid fa-download"></i></a>
                    @else
                        {{ __('--') }}
                    @endif
                </td>
            </tr>
            {{-- @if (!empty($lam->cv))
                <tr>
                    <td colspan="7">
                        <iframe src="{{ pdf_storage_url($lam->cv) }}" width="100%" height="600px"></iframe>
                    </td>
                </tr>
            @endif --}}
        </tbody>
    </table>
</div>
