<table class="table table-striped m-0">
    <tbody>
        <tr>
            <td class="fw-bolder">{{ __('Pharmacy Name') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->name }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Pharmacy / Responsible Person Phone') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->phone }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Emergency Contact') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->emergency_phone ?? 'null' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Email') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->email ?? 'null' }}</td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Identification Type') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->identificationType() ?? 'null' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Identification Document') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                @if ($pharmacy->identification_file)
                    <a class="btn btn-info btn-sm"
                        href="{{ route('pm.pharmacy.download.pharmacy_list', base64_encode($pharmacy->identification_file)) }}"><i
                            class="fa-regular fa-circle-down"></i></a>
                @else
                    {{ __('null') }}
                @endif
            </td>

        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Operational Area') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->operation_area->name ?? 'null' }}</td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Operational Sub Area') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->operation_sub_area->name ?? 'null' }}</td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Operational Sub Area') }}</td>
            <td>{{ __(':') }}</td>
            <td>{{ $pharmacy->operation_sub_area->name ?? 'null' }}</td>
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
                <span class="{{ $pharmacy->getEmailVerifyClass() }}">{{ $pharmacy->getEmailVerifyStatus() }}</span>
            </td>
            <td>|</td>
            <td class="fw-bolder">{{ __('KYC Status') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                <span class="{{ $pharmacy->getKycStatusClass() }}">{{ $pharmacy->getKycStatus() }}</span>
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Created Date') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                {{ timeFormate($pharmacy->created_at) }}
            </td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Created By') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                {{ c_user_name($pharmacy->created_creater) }}
            </td>
        </tr>
        <tr>
            <td class="fw-bolder">{{ __('Updated Date') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                {{ $pharmacy->created_at != $pharmacy->updated_at ? timeFormate($pharmacy->created_at) : 'null' }}
            </td>
            <td>|</td>
            <td class="fw-bolder">{{ __('Created By') }}</td>
            <td>{{ __(':') }}</td>
            <td>
                {{ u_user_name($pharmacy->created_updater) }}
            </td>
        </tr>
    </tbody>
</table>
