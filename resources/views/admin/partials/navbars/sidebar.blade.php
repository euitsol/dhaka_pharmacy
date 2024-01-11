<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('dashboard') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('dashboard') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'dashboard',
                        'routeName' => 'dashboard',
                        'iconClass' => 'fa-solid fa-chart-line',
                        'label' => 'Dashboard',
                    ],
                ],
            ])
            {{-- Admin Management --}}
            <li>
                <a class="@if ($pageSlug == 'role' || $pageSlug == 'permission' || $pageSlug == 'admin') @else collapsed @endif" data-toggle="collapse"
                    href="#admin-management"
                    @if ($pageSlug == 'role' || $pageSlug == 'permission' || $pageSlug == 'admin') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="nav-link-text">{{ __('Admin Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if ($pageSlug == 'role' || $pageSlug == 'permission' || $pageSlug == 'admin') show @endif" id="admin-management">
                    <ul class="nav pl-2">
                        @include('admin.partials.menu_buttons', [
                            'menuItems' => [
                                [
                                    'pageSlug' => 'admin',
                                    'routeName' => 'am.admin.admin_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'label' => 'Admins',
                                ],
                                [
                                    'pageSlug' => 'role',
                                    'routeName' => 'am.role.role_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'label' => 'Roles',
                                ],
                                [
                                    'pageSlug' => 'permission',
                                    'routeName' => 'am.permission.permission_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'label' => 'Permission',
                                ],
                            ],
                        ])
                    </ul>
                </div>
            </li>
            {{-- User Management --}}
            @if(mainMenuCheck(['user','user_kyc_list','user_kyc_settings']))
                <li>
                    <a class="@if ($pageSlug == 'user' || $pageSlug == 'kyc' || $pageSlug == 'user_kyc_list' || $pageSlug == 'user_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#user-management"
                        @if ($pageSlug == 'user' || $pageSlug == 'kyc' || $pageSlug == 'user_kyc_list' || $pageSlug == 'user_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-users"></i>
                        <span class="nav-link-text">{{ __('User Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'user' || $pageSlug == 'kyc' || $pageSlug == 'user_kyc_list' || $pageSlug == 'user_kyc_settings') show @endif" id="user-management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    ['pageSlug' => 'user', 'routeName' => 'um.user.user_list', 'label' => 'Users'],
                            
                                    [
                                        'pageSlug' => ['user_kyc_list', 'user_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'user_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'KYC List',
                                                'subRouteName' => 'um.user_kyc.kyc_list.user_kyc_list',
                                                'subPageSlug' => 'user_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'um.user_kyc.user_kyc_settings',
                                                'subPageSlug' => 'user_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Pharmacy Management --}}
            @if(mainMenuCheck(['pharmacy','pharmacy_kyc_list','pharmacy_kyc_settings']))
                <li>
                    <a class="@if ($pageSlug == 'pharmacy' || $pageSlug == 'kyc' || $pageSlug == 'pharmacy_kyc_list' || $pageSlug == 'pharmacy_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#pharmacy-management"
                        @if ($pageSlug == 'pharmacy' || $pageSlug == 'kyc' || $pageSlug == 'pharmacy_kyc_list' || $pageSlug == 'pharmacy_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-kit-medical"></i>
                        <span class="nav-link-text">{{ __('Pharmacy Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'pharmacy' || $pageSlug == 'kyc' || $pageSlug == 'pharmacy_kyc_list' || $pageSlug == 'pharmacy_kyc_settings') show @endif" id="pharmacy-management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    ['pageSlug' => 'pharmacy', 'routeName' => 'pm.pharmacy.pharmacy_list', 'label' => 'Pharmacies'],
                            
                                    [
                                        'pageSlug' => ['pharmacy_kyc_list', 'pharmacy_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'pharmacy_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'KYC List',
                                                'subRouteName' => 'pm.pharmacy_kyc.kyc_list.pharmacy_kyc_list',
                                                'subPageSlug' => 'pharmacy_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'pm.pharmacy_kyc.pharmacy_kyc_settings',
                                                'subPageSlug' => 'pharmacy_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'site_settings',
                        'routeName' => 'settings.site_settings',
                        'iconClass' => 'fa-solid fa-gears',
                        'label' => 'Site Settings',
                    ],
                ],
            ])
        </ul>
    </div>
</div>

