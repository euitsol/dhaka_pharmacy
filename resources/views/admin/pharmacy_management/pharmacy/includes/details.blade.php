<div class="row details">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td class="fw-bolder">{{ __('Full Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->name }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Designation') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->designation ?? 'District Manager' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Father Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->father_name ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Mother Name') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->mother_name ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Phone') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->phone }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->parent_phone ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Birth Date') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->dob ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Age') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->age ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Identification Type') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->identification_type ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Identification No') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->identification_no ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Gender') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->gender ?? '--' }}</td>
                <td>|</td>
                <td class="fw-bolder">{{ __('Operational Area') }}</td>
                <td>{{ __(':') }}</td>
                <td>{{ $pharmacy->operation_area->name ?? '--' }}</td>
            </tr>
            <tr>
                <td class="fw-bolder">{{ __('Status') }}</td>
                <td>{{ __(':') }}</td>
                <td>
                    <span class="{{ $pharmacy->getStatusBadgeClass() }}">{{ $pharmacy->getStatus() }}</span>
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
            <tr>
                <td class="fw-bolder">{{ __('CV') }}</td>
                <td>{{ __(':') }}</td>
                <td colspan="5">
                    @if (!empty($pharmacy->cv))
                        <a class="btn btn-primary" target="_blank"
                            href="{{ route('dm_management.district_manager.download.district_manager_profile', base64_encode($pharmacy->cv)) }}"><i
                                class="fa-solid fa-download"></i></a>
                    @else
                        {{ __('--') }}
                    @endif
                </td>
            </tr>
            {{-- @if (!empty($pharmacy->cv))
                <tr>
                    <td colspan="7">
                        <iframe src="{{ pdf_storage_url($pharmacy->cv) }}" width="100%" height="600px"></iframe>
                    </td>
                </tr>
            @endif --}}
        </tbody>
    </table>
</div>
