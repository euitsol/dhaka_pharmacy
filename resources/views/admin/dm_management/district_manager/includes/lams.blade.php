<table class="table table-striped lam_datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Phone') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('KYC Status') }}</th>
            <th>{{ __('Phone Verify') }}</th>
            <th>{{ __('Created date') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($dm->lams as $lam)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $lam->name }} </td>
                <td> {{ $lam->phone }} </td>
                <td>
                    <span class="{{ $lam->getStatusBadgeClass() }}">{{ $lam->getStatus() }}</span>
                </td>
                <td>
                    <span class="{{ $lam->getKycStatusClass() }}">{{ $lam->getKycStatus() }}</span>
                </td>
                <td>
                    <span class="{{ $lam->getPhoneVerifyClass() }}">{{ $lam->getPhoneVerifyStatus() }}</span>
                </td>
                <td>{{ timeFormate($lam->created_at) }}</td>
                <td>
                    @include('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'lam_management.local_area_manager.local_area_manager_profile',
                                'params' => [$lam->id],
                                'target' => '_blank',
                                'label' => 'Profile',
                            ],
                        ],
                    ])
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
@include('admin.partials.datatable', [
    'columns_to_show' => [0, 1, 2, 3, 4, 5, 6],
    'mainClass' => 'lam_datatable',
])
