<table class="table table-striped user_datatable">
    <thead>
        <tr>
            <th>{{ __('SL') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('KYC Status') }}</th>
            <th>{{ __('Phone Verify') }}</th>
            <th>{{ __('Created date') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td> {{ $loop->iteration }} </td>
                <td> {{ $user->name }} </td>
                <td>
                    <span class="{{ $user->getStatusBadgeClass() }}">{{ $user->getStatus() }}</span>
                </td>
                <td>
                    <span class="{{ $user->getKycStatusClass() }}">{{ $user->getKycStatus() }}</span>
                </td>
                <td>
                    <span class="{{ $user->getPhoneVerifyClass() }}">{{ $user->getPhoneVerifyStatus() }}</span>
                </td>
                <td>{{ timeFormate($user->created_at) }}</td>
                <td>
                    @include('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'dm.user.profile',
                                'params' => [$user->id],
                                'target' => '_blank',
                                'label' => 'Profile',
                            ],
                        ],
                    ])


                </td>
            </tr>
        @endforeach

    </tbody>
</table>
@include('admin.partials.datatable', [
    'columns_to_show' => [0, 1, 2, 3, 4, 5],
    'mainClass' => 'user_datatable',
])
