<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'dashboard',
                        'routeName' => 'admin.dashboard',
                        'iconClass' => 'fa-solid fa-chart-line',
                        'label' => 'Dashboard',
                    ],
                ],
            ])

            {{-- Admin Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['am.'],
                    'routes' => ['admin_list', 'role_list', 'permission_list'],
                ]))
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
            @if (mainMenuCheck([
                    'prefixes' => ['um.'],
                    'routes' => ['user_list', 'us_kyc_list', 'u_kyc_create'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'user' || $pageSlug == 'us_kyc_list' || $pageSlug == 'u_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#user-management"
                        @if ($pageSlug == 'user' || $pageSlug == 'us_kyc_list' || $pageSlug == 'u_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-user-check"></i>
                        <span class="nav-link-text">{{ __('User Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'user' || $pageSlug == 'us_kyc_list' || $pageSlug == 'u_kyc_settings') show @endif" id="user-management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'user',
                                        'routeName' => 'um.user.user_list',
                                        'label' => 'users',
                                    ],
                            
                                    [
                                        'pageSlug' => ['us_kyc_list', 'u_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'user_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'Submitted KYC List',
                                                'subRouteName' => 'um.user_kyc.submitted_kyc.us_kyc_list',
                                                'subPageSlug' => 'us_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'um.user_kyc.settings.u_kyc_create',
                                                'subPageSlug' => 'u_kyc_settings',
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
            @if (mainMenuCheck([
                    'prefixes' => ['pm.'],
                    'routes' => ['pharmacy_list', 'ps_kyc_list', 'p_kyc_create'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'pharmacy' || $pageSlug == 'ps_kyc_list' || $pageSlug == 'p_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#pharmacy-management"
                        @if ($pageSlug == 'pharmacy' || $pageSlug == 'ps_kyc_list' || $pageSlug == 'p_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-kit-medical"></i>
                        <span class="nav-link-text">{{ __('Pharmacy Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'pharmacy' || $pageSlug == 'ps_kyc_list' || $pageSlug == 'p_kyc_settings') show @endif" id="pharmacy-management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'pharmacy',
                                        'routeName' => 'pm.pharmacy.pharmacy_list',
                                        'label' => 'Pharmacies',
                                    ],
                            
                                    [
                                        'pageSlug' => ['ps_kyc_list', 'p_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'pharmacy_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'Submitted KYC List',
                                                'subRouteName' => 'pm.pharmacy_kyc.submitted_kyc.ps_kyc_list',
                                                'subPageSlug' => 'ps_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'pm.pharmacy_kyc.settings.p_kyc_create',
                                                'subPageSlug' => 'p_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- DM Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['dm_management.'],
                    'routes' => ['district_manager_list', 'dm_kyc_create', 'dms_kyc_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'district_manager' || $pageSlug == 'dms_kyc_list' || $pageSlug == 'dm_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#district_manager"
                        @if ($pageSlug == 'district_manager' || $pageSlug == 'dms_kyc_list' || $pageSlug == 'dm_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-people-roof"></i>
                        <span class="nav-link-text">{{ __('DM Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'district_manager' || $pageSlug == 'dms_kyc_list' || $pageSlug == 'dm_kyc_settings') show @endif" id="district_manager">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'district_manager',
                                        'routeName' => 'dm_management.district_manager.district_manager_list',
                                        'label' => 'District Manager',
                                    ],
                                    [
                                        'pageSlug' => ['dms_kyc_list', 'dm_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'district_manager_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'Submitted KYC List',
                                                'subRouteName' =>
                                                    'dm_management.dm_kyc.submitted_kyc.dms_kyc_list',
                                                'subPageSlug' => 'dms_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'dm_management.dm_kyc.settings.dm_kyc_create',
                                                'subPageSlug' => 'dm_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- LAM Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['lam_management.'],
                    'routes' => ['local_area_manager_list', 'lam_kyc_create', 'lams_kyc_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'local_area_manager' || $pageSlug == 'lams_kyc_list' || $pageSlug == 'lam_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#local_area_manager"
                        @if ($pageSlug == 'local_area_manager' || $pageSlug == 'lams_kyc_list' || $pageSlug == 'lam_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-people-group"></i>
                        <span class="nav-link-text">{{ __('LAM Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'local_area_manager' || $pageSlug == 'lams_kyc_list' || $pageSlug == 'lam_kyc_settings') show @endif" id="local_area_manager">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'local_area_manager',
                                        'routeName' => 'lam_management.local_area_manager.local_area_manager_list',
                                        'label' => 'Local Area Manager',
                                    ],
                                    [
                                        'pageSlug' => ['lams_kyc_list', 'lam_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'local_area_manager_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'Submitted KYC List',
                                                'subRouteName' =>
                                                    'lam_management.lam_kyc.submitted_kyc.lams_kyc_list',
                                                'subPageSlug' => 'lams_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'lam_management.lam_kyc.settings.lam_kyc_create',
                                                'subPageSlug' => 'lam_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif
            {{-- Rider Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['rm.'],
                    'routes' => ['rider_list', 'rs_kyc_list', 'r_kyc_create'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'rider' || $pageSlug == 'rs_kyc_list' || $pageSlug == 'r_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#rider-management"
                        @if ($pageSlug == 'rider' || $pageSlug == 'rs_kyc_list' || $pageSlug == 'r_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-person-biking"></i>
                        <span class="nav-link-text">{{ __('Rider Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'rider' || $pageSlug == 'rs_kyc_list' || $pageSlug == 'r_kyc_settings') show @endif" id="rider-management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'rider',
                                        'routeName' => 'rm.rider.rider_list',
                                        'label' => 'Riders',
                                    ],
                            
                                    [
                                        'pageSlug' => ['rs_kyc_list', 'r_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'rider_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'Submitted KYC List',
                                                'subRouteName' => 'rm.rider_kyc.submitted_kyc.rs_kyc_list',
                                                'subPageSlug' => 'rs_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' => 'rm.rider_kyc.settings.r_kyc_create',
                                                'subPageSlug' => 'r_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif
            {{-- Latest Offer --}}
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'latest_offer',
                        'routeName' => 'latest_offer.lf_list',
                        'iconClass' => 'fa-solid fa-bullhorn',
                        'label' => 'Latest Offer',
                    ],
                ],
            ])

            {{-- User Tips --}}
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'user_tips',
                        'routeName' => 'user_tips.tips_list',
                        'iconClass' => 'fa-regular fa-lightbulb',
                        'label' => 'User Tips',
                    ],
                ],
            ])

            {{-- Operational Area Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['opa.'],
                    'routes' => ['operation_area_list', 'operation_sub_area_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'operation_area' || $pageSlug == 'operation_sub_area') @else collapsed @endif" data-toggle="collapse"
                        href="#opa"
                        @if ($pageSlug == 'operation_area' || $pageSlug == 'operation_sub_area') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-earth-americas"></i>
                        <span class="nav-link-text">{{ __('Operational Areas') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'operation_area' || $pageSlug == 'operation_sub_area') show @endif" id="opa">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'operation_area',
                                        'routeName' => 'opa.operation_area.operation_area_list',
                                        'label' => 'Operation Areas',
                                    ],
                                    [
                                        'pageSlug' => 'operation_sub_area',
                                        'routeName' => 'opa.operation_sub_area.operation_sub_area_list',
                                        'label' => 'Operation Sub Areas',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Hub Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['hm.'],
                    'routes' => ['hub_list', 'hub_staff_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'hub' || $pageSlug == 'hub_staff') @else collapsed @endif" data-toggle="collapse"
                        href="#hub"
                        @if ($pageSlug == 'hub' || $pageSlug == 'hub_staff') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-earth-americas"></i>
                        <span class="nav-link-text">{{ __('Hub Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'hub' || $pageSlug == 'hub_staff') show @endif" id="hub">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'hub',
                                        'routeName' => 'hm.hub.hub_list',
                                        'label' => 'Hubs',
                                    ],
                                    [
                                        'pageSlug' => 'hub_staff',
                                        'routeName' => 'hm.hub_staff.hub_staff_list',
                                        'label' => 'Hub Staffs',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Product Management --}}
            @if (mainMenuCheck([
                    'prefixes' => ['product.'],
                    'routes' => [
                        'medicine_list',
                        'product_category_list',
                        'product_sub_category_list',
                        'generic_name_list',
                        'company_name_list',
                        'medicine_strength_list',
                        'medicine_unit_list',
                        'medicine_dose_list',
                    ],
                ]))
                <li>
                    <a class="@if (
                        $pageSlug == 'medicine_generic_name' ||
                            $pageSlug == 'medicine_company_name' ||
                            $pageSlug == 'medicine_strength' ||
                            $pageSlug == 'medicine_category' ||
                            $pageSlug == 'product_category' ||
                            $pageSlug == 'product_sub_category' ||
                            $pageSlug == 'medicine_dose' ||
                            $pageSlug == 'medicine' ||
                            $pageSlug == 'medicine_unit') @else collapsed @endif" data-toggle="collapse"
                        href="#product_management"
                        @if (
                            $pageSlug == 'medicine_generic_name' ||
                                $pageSlug == 'medicine_company_name' ||
                                $pageSlug == 'medicine_strength' ||
                                $pageSlug == 'medicine_category' ||
                                $pageSlug == 'product_category' ||
                                $pageSlug == 'product_sub_category' ||
                                $pageSlug == 'medicine_dose' ||
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
                            $pageSlug == 'medicine_dose' ||
                            $pageSlug == 'product_sub_category' ||
                            $pageSlug == 'medicine' ||
                            $pageSlug == 'medicine_unit') show @endif" id="product_management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'medicine',
                                        'routeName' => 'product.medicine.medicine_list',
                                        'label' => 'Product',
                                    ],
                                    [
                                        'pageSlug' => 'product_category',
                                        'routeName' => 'product.product_category.product_category_list',
                                        'label' => 'Product Category',
                                    ],
                                    [
                                        'pageSlug' => 'product_sub_category',
                                        'routeName' => 'product.product_sub_category.product_sub_category_list',
                                        'label' => 'Product Sub Category',
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
                                    // [
                                    //     'pageSlug' => 'medicine_category',
                                    //     'routeName' => 'product.medicine_category.medicine_category_list',
                                    //     'label' => 'Medicine Dosage',
                                    // ],
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
                                    [
                                        'pageSlug' => 'medicine_dose',
                                        'routeName' => 'product.medicine_dose.medicine_dose_list',
                                        'label' => 'Medicine Dose',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Notifications --}}
            @if (mainMenuCheck([
                    'prefixes' => ['push.'],
                    'routes' => ['ns'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'push_notification') @else collapsed @endif" data-toggle="collapse"
                        href="#notification"
                        @if ($pageSlug == 'push_notification') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-regular fa-bell"></i>
                        <span class="nav-link-text">{{ __('Notifications') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'push_notification') show @endif" id="notification">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'push_notification',
                                        'routeName' => 'push.ns',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'label' => 'Push Notification',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Order By Prescription --}}
            @if (mainMenuCheck([
                    'prefixes' => ['obp.'],
                    'routes' => ['obp_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'ubp_pending' || $pageSlug == 'ubp_ordered' || $pageSlug == 'ubp_cancel') @else collapsed @endif" data-toggle="collapse"
                        href="#ubp"
                        @if ($pageSlug == 'ubp_pending' || $pageSlug == 'ubp_ordered' || $pageSlug == 'ubp_cancel') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-regular fa-newspaper"></i>
                        <span class="nav-link-text">{{ __('Order By Prescription') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'ubp_pending' || $pageSlug == 'ubp_ordered' || $pageSlug == 'ubp_cancel') show @endif" id="ubp">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'ubp_pending',
                                        'routeName' => 'obp.obp_list',
                                        'params' => 'pending',
                                        'label' => 'Pending',
                                    ],
                                    [
                                        'pageSlug' => 'ubp_ordered',
                                        'routeName' => 'obp.obp_list',
                                        'params' => 'ordered',
                                        'label' => 'Ordered',
                                    ],
                                    [
                                        'pageSlug' => 'ubp_cancel',
                                        'routeName' => 'obp.obp_list',
                                        'params' => 'cancel',
                                        'label' => 'Cancel',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Order Managements --}}
            @if (mainMenuCheck([
                    'prefixes' => ['om.'],
                    'routes' => ['order_list'],
                ]))
                <li>
                    <a class="@if (
                        $pageSlug == 'order_Initiated' ||
                            $pageSlug == 'order_Submitted' ||
                            $pageSlug == 'order_Processed' ||
                            $pageSlug == 'order_Waiting-for-rider' ||
                            $pageSlug == 'order_Delivered' ||
                            $pageSlug == 'order_Assigned' ||
                            $pageSlug == 'order_Canceled') @else collapsed @endif" data-toggle="collapse"
                        href="#order_management"
                        @if (
                            $pageSlug == 'order_Initiated' ||
                                $pageSlug == 'order_Submitted' ||
                                $pageSlug == 'order_Processed' ||
                                $pageSlug == 'order_Waiting-for-rider' ||
                                $pageSlug == 'order_Delivered' ||
                                $pageSlug == 'order_Assigned' ||
                                $pageSlug == 'order_Canceled') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-truck-fast"></i>
                        <span class="nav-link-text">{{ __('Order Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if (
                        $pageSlug == 'order_Initiated' ||
                            $pageSlug == 'order_Submitted' ||
                            $pageSlug == 'order_Processed' ||
                            $pageSlug == 'order_Waiting-for-rider' ||
                            $pageSlug == 'order_Delivered' ||
                            $pageSlug == 'order_Assigned' ||
                            $pageSlug == 'order_Canceled') show @endif" id="order_management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'order_Initiated',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'initiated',
                                        'label' => 'Initiated Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_Submitted',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'submitted',
                                        'label' => 'Submitted Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_Processed',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'processed',
                                        'label' => 'Processed Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_Waiting-for-rider',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'waiting-for-rider',
                                        'label' => 'Waiting For Rider',
                                    ],
                                    [
                                        'pageSlug' => 'order_Assigned',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'assigned',
                                        'label' => 'Assigned Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_Delivered',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'delivered',
                                        'label' => 'Delivered Orders',
                                    ],
                                    // [
                                    //     'pageSlug' => 'order_Failed',
                                    //     'routeName' => 'om.order.order_list',
                                    //     'iconClass' => 'fa-solid fa-minus',
                                    //     'params' => 'failed',
                                    //     'label' => 'Failed Orders',
                                    // ],
                                    [
                                        'pageSlug' => 'order_Canceled',
                                        'routeName' => 'om.order.order_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'canceled',
                                        'label' => 'Cancelled Orders',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Distributed Order  --}}
            {{-- @if (mainMenuCheck([
        'prefixes' => ['do.'],
        'routes' => ['do_list'],
    ]))
                <li>
                    <a class="@if ($pageSlug == 'order_pending' || $pageSlug == 'order_preparing' || $pageSlug == 'dispute_orders' || $pageSlug == 'order_dispute' || $pageSlug == 'order_cancel' || $pageSlug == 'order_waiting-for-pickup' || $pageSlug == 'order_waiting-for-rider' || $pageSlug == 'order_picked-up' || $pageSlug == 'order_delivered' || $pageSlug == 'order_finish') @else collapsed @endif" data-toggle="collapse"
                        href="#distributed_order"
                        @if ($pageSlug == 'order_pending' || $pageSlug == 'order_preparing' || $pageSlug == 'dispute_orders' || $pageSlug == 'order_dispute' || $pageSlug == 'order_cancel' || $pageSlug == 'order_waiting-for-pickup' || $pageSlug == 'order_waiting-for-rider' || $pageSlug == 'order_picked-up' || $pageSlug == 'order_delivered' || $pageSlug == 'order_finish') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-network-wired"></i>
                        <span class="nav-link-text">{{ __('Distributed Orders') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'order_pending' || $pageSlug == 'order_preparing' || $pageSlug == 'dispute_orders' || $pageSlug == 'order_dispute' || $pageSlug == 'order_cancel' || $pageSlug == 'order_waiting-for-pickup' || $pageSlug == 'order_waiting-for-rider' || $pageSlug == 'order_picked-up' || $pageSlug == 'order_delivered' || $pageSlug == 'order_finish') show @endif" id="distributed_order">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'order_pending',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'pending',
                                        'label' => 'Pending Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_preparing',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'preparing',
                                        'label' => 'Preparing Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_waiting-for-rider',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'waiting-for-rider',
                                        'label' => 'Waiting For Rider Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_waiting-for-pickup',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'waiting-for-pickup',
                                        'label' => 'Waiting For Pickup Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_picked-up',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'picked-up',
                                        'label' => 'Picked Up Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_delivered',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'delivered',
                                        'label' => 'Delivered Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_finish',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'finish',
                                        'label' => 'Finish Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_dispute',
                                        'routeName' => 'do.dispute.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'dispute',
                                        'label' => 'Dispute Orders',
                                    ],
                                    [
                                        'pageSlug' => 'order_cancel',
                                        'routeName' => 'do.do_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'cancel',
                                        'label' => 'Cancel Orders',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif --}}


            {{-- Payment Management  --}}
            @if (mainMenuCheck([
                    'prefixes' => ['pym.'],
                    'routes' => ['payment_list'],
                ]))
                <li>
                    <a class="@if (
                        $pageSlug == 'payment_Success' ||
                            $pageSlug == 'payment_Failed' ||
                            $pageSlug == 'payment_Cancel' ||
                            $pageSlug == 'payment_Initiated' ||
                            $pageSlug == 'payment_Unkhown') @else collapsed @endif" data-toggle="collapse"
                        href="#payment_management"
                        @if (
                            $pageSlug == 'payment_Success' ||
                                $pageSlug == 'payment_Failed' ||
                                $pageSlug == 'payment_Cancel' ||
                                $pageSlug == 'payment_Initiated' ||
                                $pageSlug == 'payment_Unkhown') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-credit-card"></i>
                        <span class="nav-link-text">{{ __('Payment Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if (
                        $pageSlug == 'payment_Success' ||
                            $pageSlug == 'payment_Failed' ||
                            $pageSlug == 'payment_Cancel' ||
                            $pageSlug == 'payment_Initiated' ||
                            $pageSlug == 'payment_Unkhown') show @endif" id="payment_management">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'payment_Initiated',
                                        'routeName' => 'pym.payment.payment_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'initiated',
                                        'label' => 'Payment List (Initiated)',
                                    ],
                                    [
                                        'pageSlug' => 'payment_Success',
                                        'routeName' => 'pym.payment.payment_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'success',
                                        'label' => 'Payment List (Success)',
                                    ],
                                    [
                                        'pageSlug' => 'payment_Failed',
                                        'routeName' => 'pym.payment.payment_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'failed',
                                        'label' => 'Payment List (Failed)',
                                    ],
                                    [
                                        'pageSlug' => 'payment_Cancel',
                                        'routeName' => 'pym.payment.payment_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'cancel',
                                        'label' => 'Payment List (Cancel)',
                                    ],
                                    [
                                        'pageSlug' => 'payment_Unkhown',
                                        'routeName' => 'pym.payment.payment_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'unkhown',
                                        'label' => 'Payment List (Unkhown)',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif
            {{-- Withdraw Method Request  --}}
            @if (mainMenuCheck([
                    'prefixes' => ['withdraw_method.'],
                    'routes' => ['wm_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'wm_Pending' || $pageSlug == 'wm_Verified' || $pageSlug == 'wm_Declined') @else collapsed @endif" data-toggle="collapse"
                        href="#wm"
                        @if ($pageSlug == 'wm_Pending' || $pageSlug == 'wm_Verified' || $pageSlug == 'wm_Declined') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-regular fa-credit-card"></i>
                        <span class="nav-link-text">{{ __('Withdraw Method Request') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'wm_Pending' || $pageSlug == 'wm_Verified' || $pageSlug == 'wm_Declined') show @endif" id="wm">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'wm_Pending',
                                        'routeName' => 'withdraw_method.wm_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'pending',
                                        'label' => 'Pending',
                                    ],
                                    [
                                        'pageSlug' => 'wm_Verified',
                                        'routeName' => 'withdraw_method.wm_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'verified',
                                        'label' => 'Verified',
                                    ],
                                    [
                                        'pageSlug' => 'wm_Declined',
                                        'routeName' => 'withdraw_method.wm_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'declined',
                                        'label' => 'Declined',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Payment Clearance  --}}
            @if (mainMenuCheck([
                    'prefixes' => ['pc.'],
                    'routes' => ['pc_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'pc_Payment-declined' || $pageSlug == 'pc_Pending-clearance' || $pageSlug == 'pc_Earning') @else collapsed @endif" data-toggle="collapse"
                        href="#pc"
                        @if ($pageSlug == 'pc_Payment-declined' || $pageSlug == 'pc_Pending-clearance' || $pageSlug == 'pc_Earning') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span class="nav-link-text">{{ __('Payment Clearance') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'pc_Payment-declined' || $pageSlug == 'pc_Pending-clearance' || $pageSlug == 'pc_Earning') show @endif" id="pc">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'pc_Pending-clearance',
                                        'routeName' => 'pc.pc_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'pending-clearance',
                                        'label' => 'Pending',
                                    ],
                                    [
                                        'pageSlug' => 'pc_Earning',
                                        'routeName' => 'pc.pc_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'earning',
                                        'label' => 'Payments',
                                    ],
                                    [
                                        'pageSlug' => 'pc_Payment-declined',
                                        'routeName' => 'pc.pc_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'payment-declined',
                                        'label' => 'Declined',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Withdraw Request  --}}
            @if (mainMenuCheck([
                    'prefixes' => ['withdraw.'],
                    'routes' => ['w_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'w_Pending' || $pageSlug == 'w_Accepted' || $pageSlug == 'w_Declined') @else collapsed @endif" data-toggle="collapse"
                        href="#withdraw"
                        @if ($pageSlug == 'w_Pending' || $pageSlug == 'w_Accepted' || $pageSlug == 'w_Declined') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-hourglass-half"></i>
                        <span class="nav-link-text">{{ __('Withdraw Request') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'w_Pending' || $pageSlug == 'w_Accepted' || $pageSlug == 'w_Declined') show @endif" id="withdraw">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'w_Pending',
                                        'routeName' => 'withdraw.w_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'pending',
                                        'label' => 'Pending',
                                    ],
                                    [
                                        'pageSlug' => 'w_Accepted',
                                        'routeName' => 'withdraw.w_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'accepted',
                                        'label' => 'Accepted',
                                    ],
                                    [
                                        'pageSlug' => 'w_Declined',
                                        'routeName' => 'withdraw.w_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'params' => 'declined',
                                        'label' => 'Declined',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif





            {{-- Feedback --}}
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'feedback',
                        'routeName' => 'feedback.fdk_list',
                        'iconClass' => 'fa-regular fa-thumbs-up',
                        'label' => 'Feedback',
                    ],
                ],
            ])
            {{-- Review --}}
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'review',
                        'routeName' => 'review.review_products',
                        'iconClass' => 'fa-regular fa-star-half-alt',
                        'label' => 'Review',
                    ],
                ],
            ])

            {{-- Payment Gateways --}}
            @if (mainMenuCheck([
                    'prefixes' => ['payment_gateway.'],
                    'routes' => ['pg_ssl_commerz'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'ssl_commerz') @else collapsed @endif" data-toggle="collapse"
                        href="#payment_gateway"
                        @if ($pageSlug == 'ssl_commerz') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-money-check-alt"></i>
                        <span class="nav-link-text">{{ __('Payment Gateways') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'ssl_commerz') show @endif" id="payment_gateway">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'ssl_commerz',
                                        'routeName' => 'payment_gateway.pg_ssl_commerz',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'label' => 'SSL Commerz',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Payment Gateways --}}
            @if (mainMenuCheck([
                    'prefixes' => ['st.'],
                    'routes' => ['ticket_list'],
                ]))
                <li>
                    <a class="@if ($pageSlug == 'ticket') @else collapsed @endif" data-toggle="collapse"
                        href="#st"
                        @if ($pageSlug == 'ticket') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-money-check-alt"></i>
                        <span class="nav-link-text">{{ __('Support') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'ticket') show @endif" id="st">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'ticket',
                                        'routeName' => 'st.ticket_list',
                                        'iconClass' => 'fa-solid fa-minus',
                                        'label' => 'Ticket',
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Documentation --}}
            @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'doc',
                        'routeName' => 'doc.doc_list',
                        'iconClass' => 'fa-solid fa-bullhorn',
                        'label' => 'Documentation',
                    ],
                ],
            ])

            {{-- Site Settings --}}
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
