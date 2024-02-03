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
            @if (mainMenuCheck(['role_list', 'permission_list', 'admin_list']))
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
            @endif

            {{-- User Management --}}
            @if (mainMenuCheck(['user_list', 'user_kyc_list', 'user_kyc_settings']))
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
            @if (mainMenuCheck(['pharmacy_list', 'pharmacy_kyc_list', 'pharmacy_kyc_settings']))
                <li>
                    <a class="@if (
                        $pageSlug == 'pharmacy' ||
                            $pageSlug == 'kyc' ||
                            $pageSlug == 'pharmacy_kyc_list' ||
                            $pageSlug == 'pharmacy_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#pharmacy-management"
                        @if (
                            $pageSlug == 'pharmacy' ||
                                $pageSlug == 'kyc' ||
                                $pageSlug == 'pharmacy_kyc_list' ||
                                $pageSlug == 'pharmacy_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-kit-medical"></i>
                        <span class="nav-link-text">{{ __('Pharmacy Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if (
                        $pageSlug == 'pharmacy' ||
                            $pageSlug == 'kyc' ||
                            $pageSlug == 'pharmacy_kyc_list' ||
                            $pageSlug == 'pharmacy_kyc_settings') show @endif" id="pharmacy-management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'pharmacy',
                                        'routeName' => 'pm.pharmacy.pharmacy_list',
                                        'label' => 'Pharmacies',
                                    ],
                            
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

            {{-- DM & LAM Management --}}
            @if (mainMenuCheck(['district_manager_list', 'local_area_manager_list']))
                <li>
                    <a class="@if ($pageSlug == 'district_manager' || $pageSlug == 'local_area_manager') @else collapsed @endif" data-toggle="collapse"
                        href="#district_manager"
                        @if ($pageSlug == 'district_manager' || $pageSlug == 'local_area_manager') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-user-tie"></i>
                        <span class="nav-link-text">{{ __('DM & LAM Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'district_manager' || $pageSlug == 'local_area_manager') show @endif" id="district_manager">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'district_manager',
                                        'routeName' => 'dmlam.district_manager.district_manager_list',
                                        'label' => 'District Manager',
                                    ],
                                    [
                                        'pageSlug' => 'local_area_manager',
                                        'routeName' => 'dmlam.local_area_manager.local_area_manager_list',
                                        'label' => 'Local Area Manager',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif
            {{-- Product Management --}}
            @if (mainMenuCheck([
                    'generic_name_list',
                    'company_name_list',
                    'medicine_strength_list',
                    'medicine_unit_list',
                    'medicine_category_list',
                    'product_category_list',
                    'medicine_list',
                ]))
                <li>
                    <a class="@if (
                        $pageSlug == 'medicine_generic_name' ||
                            $pageSlug == 'medicine_company_name' ||
                            $pageSlug == 'medicine_strength' ||
                            $pageSlug == 'medicine_category' ||
                            $pageSlug == 'product_category' ||
                            $pageSlug == 'medicine' ||
                            $pageSlug == 'medicine_unit') @else collapsed @endif" data-toggle="collapse"
                        href="#product_management"
                        @if (
                            $pageSlug == 'medicine_generic_name' ||
                                $pageSlug == 'medicine_company_name' ||
                                $pageSlug == 'medicine_strength' ||
                                $pageSlug == 'medicine_category' ||
                                $pageSlug == 'product_category' ||
                                $pageSlug == 'medicine' ||
                                $pageSlug == 'medicine_unit') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-capsules"></i>
                        <span class="nav-link-text">{{ __('Product Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if (
                        $pageSlug == 'medicine_generic_name' ||
                            $pageSlug == 'medicine_company_name' ||
                            $pageSlug == 'medicine_strength' ||
                            $pageSlug == 'medicine_category' ||
                            $pageSlug == 'product_category' ||
                            $pageSlug == 'medicine' ||
                            $pageSlug == 'medicine_unit') show @endif" id="product_management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'medicine',
                                        'routeName' => 'product.medicine.medicine_list',
                                        'label' => 'Medicine',
                                    ],
                                    [
                                        'pageSlug' => 'product_category',
                                        'routeName' => 'product.product_category.product_category_list',
                                        'label' => 'Product Category',
                                    ],
                                    [
                                        'pageSlug' => 'medicine_generic_name',
                                        'routeName' => 'product.generic_name.generic_name_list',
                                        'label' => 'Generic Name',
                                    ],
                                    [
                                        'pageSlug' => 'medicine_company_name',
                                        'routeName' => 'product.company_name.company_name_list',
                                        'label' => 'Company Name',
                                    ],
                                    [
                                        'pageSlug' => 'medicine_category',
                                        'routeName' => 'product.medicine_category.medicine_category_list',
                                        'label' => 'Medicine Category',
                                    ],
                                    [
                                        'pageSlug' => 'medicine_strength',
                                        'routeName' => 'product.medicine_strength.medicine_strength_list',
                                        'label' => 'Medicine Strength',
                                    ],
                                    [
                                        'pageSlug' => 'medicine_unit',
                                        'routeName' => 'product.medicine_unit.medicine_unit_list',
                                        'label' => 'Medicine Unit',
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
                        'label' => 'Application Settings',
                    ],
                ],
            ])
        </ul>
    </div>
</div>
