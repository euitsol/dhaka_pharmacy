<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('admin.dashboard') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
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

            {{-- DM Management --}}
            @if (mainMenuCheck(['district_manager_list', 'dm_kyc_list', 'dm_kyc_settings']))
                <li>
                    <a class="@if (
                        $pageSlug == 'district_manager' ||
                            $pageSlug == 'dm_kyc_list' ||
                            $pageSlug == 'dm_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#district_manager"
                        @if (
                            $pageSlug == 'district_manager' ||
                                $pageSlug == 'dm_kyc_list' ||
                                $pageSlug == 'dm_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span class="nav-link-text">{{ __('DM Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if (
                        $pageSlug == 'district_manager' ||
                            $pageSlug == 'dm_kyc_list' ||
                            $pageSlug == 'dm_kyc_settings') show @endif" id="district_manager">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'district_manager',
                                        'routeName' => 'dm_management.district_manager.district_manager_list',
                                        'label' => 'District Manager',
                                    ],
                                    [
                                        'pageSlug' => ['dm_kyc_list', 'dm_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'district_manager_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'KYC List',
                                                'subRouteName' =>
                                                    'dm_management.dm_kyc.kyc_list.district_manager_kyc_list',
                                                'subPageSlug' => 'dm_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' =>
                                                    'dm_management.dm_kyc.district_manager_kyc_settings',
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
            @if (mainMenuCheck(['local_area_manager_list']))
                <li>
                    <a class="@if ($pageSlug == 'local_area_manager' || $pageSlug == 'lam_kyc_list' || $pageSlug == 'lam_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#local_area_manager"
                        @if ($pageSlug == 'local_area_manager' || $pageSlug == 'lam_kyc_list' || $pageSlug == 'lam_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-map"></i>
                        <span class="nav-link-text">{{ __('LAM Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'local_area_manager' || $pageSlug == 'lam_kyc_list' || $pageSlug == 'lam_kyc_settings') show @endif" id="local_area_manager">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'local_area_manager',
                                        'routeName' => 'lam_management.local_area_manager.local_area_manager_list',
                                        'label' => 'Local Area Manager',
                                    ],
                                    [
                                        'pageSlug' => ['lam_kyc_list', 'lam_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'local_area_manager_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'KYC List',
                                                'subRouteName' =>
                                                    'lam_management.lam_kyc.kyc_list.local_area_manager_kyc_list',
                                                'subPageSlug' => 'lam_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' =>
                                                    'lam_management.lam_kyc.local_area_manager_kyc_settings',
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
            {{-- @if (mainMenuCheck(['rider_list'])) --}}
                <li>
                    <a class="@if ($pageSlug == 'rider' || $pageSlug == 'rider_kyc_list' || $pageSlug == 'rider_kyc_settings') @else collapsed @endif" data-toggle="collapse"
                        href="#rider"
                        @if ($pageSlug == 'rider' || $pageSlug == 'rider_kyc_list' || $pageSlug == 'rider_kyc_settings') aria-expanded="true" @else aria-expanded="false" @endif>
                        <i class="fa-solid fa-map"></i>
                        <span class="nav-link-text">{{ __('Rider Management') }}</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse @if ($pageSlug == 'rider' || $pageSlug == 'rider_kyc_list' || $pageSlug == 'rider_kyc_settings') show @endif" id="rider">
                        <ul class="nav pl-2">
                            @include('admin.partials.menu_buttons', [
                                'menuItems' => [
                                    [
                                        'pageSlug' => 'rider',
                                        'routeName' => 'rider_management.rider.rider_list',
                                        'label' => 'Rider',
                                    ],
                                    [
                                        'pageSlug' => ['rider_kyc_list', 'rider_kyc_settings'],
                                        'routeName' => 'submenu',
                                        'label' => 'KYC Verification Center',
                                        'id' => 'rider_kyc',
                                        'subMenu' => [
                                            [
                                                'subLabel' => 'KYC List',
                                                'subRouteName' =>
                                                    'rider_management.rider_kyc.kyc_list.rider_kyc_list',
                                                'subPageSlug' => 'rider_kyc_list',
                                            ],
                                            [
                                                'subLabel' => 'KYC Settings',
                                                'subRouteName' =>
                                                    'rider_management.rider_kyc.rider_kyc_settings',
                                                'subPageSlug' => 'rider_kyc_settings',
                                            ],
                                        ],
                                    ],
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            {{-- @endif --}}


            {{-- Operational Area Management --}}
            <li>
                <a class="@if (
                        $pageSlug == 'operation_area' ||
                        $pageSlug == 'operation_sub_area') @else collapsed @endif" data-toggle="collapse"
                    href="#opa"
                    @if (
                            $pageSlug == 'operation_area' ||
                            $pageSlug == 'operation_sub_area') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span class="nav-link-text">{{ __('Operational Areas') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if (
                        $pageSlug == 'operation_area' ||
                        $pageSlug == 'operation_sub_area') show @endif" id="opa">
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



            {{-- Product Management --}}
            @if (mainMenuCheck([
                    'generic_name_list',
                    'company_name_list',
                    'medicine_strength_list',
                    'medicine_unit_list',
                    'medicine_category_list',
                    'product_category_list',
                    'medicine_list',
                    'product_sub_category_list',
                ]))
                <li>
                    <a class="@if (
                        $pageSlug == 'medicine_generic_name' ||
                            $pageSlug == 'medicine_company_name' ||
                            $pageSlug == 'medicine_strength' ||
                            $pageSlug == 'medicine_category' ||
                            $pageSlug == 'product_category' ||
                            $pageSlug == 'product_sub_category' ||
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
                                ],
                            ])
                        </ul>
                    </div>
                </li>
            @endif


            {{-- Notifications --}}
            {{-- @if (mainMenuCheck(['ns'])) --}}
            <li>
                <a class="@if ($pageSlug == 'push_notification') @else collapsed @endif" data-toggle="collapse"
                    href="#notification"
                    @if ($pageSlug == 'push_notification') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-users-gear"></i>
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
            {{-- @endif --}}

            
            {{-- Payment Gateways --}}
            {{-- @if (mainMenuCheck(['ns'])) --}}
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
            {{-- @endif --}}

           

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

            {{-- Order Managements --}}
            {{-- @if (mainMenuCheck(['ns'])) --}}
            <li>
                <a class="@if ($pageSlug == 'order_Success' || $pageSlug == 'order_details' || $pageSlug == 'order_Failed' || $pageSlug == 'order_Cancel' || $pageSlug == 'order_Pending' || $pageSlug == 'order_Initiated') @else collapsed @endif" data-toggle="collapse"
                    href="#order_management"
                    @if ($pageSlug == 'order_Success' || $pageSlug == 'order_details' || $pageSlug == 'order_Failed' || $pageSlug == 'order_Cancel' || $pageSlug == 'order_Pending' || $pageSlug == 'order_Initiated') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-truck-fast"></i>
                    <span class="nav-link-text">{{ __('Order Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if ($pageSlug == 'order_Success' || $pageSlug == 'order_details' || $pageSlug == 'order_Failed' || $pageSlug == 'order_Cancel' || $pageSlug == 'order_Pending' || $pageSlug == 'order_Initiated') show @endif" id="order_management">
                    <ul class="nav pl-2">
                        @include('admin.partials.menu_buttons', [
                            'menuItems' => [
                                [
                                    'pageSlug' => 'order_Pending',
                                    'routeName' => 'om.order.order_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'pending',
                                    'label' => 'Order List (Pending)',
                                ],
                                [
                                    'pageSlug' => 'order_Initiated',
                                    'routeName' => 'om.order.order_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'initiated',
                                    'label' => 'Order List (Initiated)',
                                ],
                                [
                                    'pageSlug' => 'order_Success',
                                    'routeName' => 'om.order.order_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'success',
                                    'label' => 'Order List (Success)',
                                ],
                                [
                                    'pageSlug' => 'order_Failed',
                                    'routeName' => 'om.order.order_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'failed',
                                    'label' => 'Order List (Failed)',
                                ],
                                [
                                    'pageSlug' => 'order_Cancel',
                                    'routeName' => 'om.order.order_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'cancel',
                                    'label' => 'Order List (Cancel)',
                                ],
                            ],
                        ])
                    </ul>
                </div>
            </li>
            {{-- @endif --}}
            {{-- Payment Managements --}}
            {{-- @if (mainMenuCheck(['ns'])) --}}

            {{-- Distributed Order  --}}
            <li>
                <a class="@if ($pageSlug == 'order_distributed' || $pageSlug == 'order_preparing' || $pageSlug == 'order_waiting-for-pickup' || $pageSlug == 'order_picked-up' || $pageSlug == 'order_finish') @else collapsed @endif" data-toggle="collapse"
                    href="#distributed_order"
                    @if ($pageSlug == 'order_distributed' || $pageSlug == 'order_preparing' || $pageSlug == 'order_waiting-for-pickup' || $pageSlug == 'order_picked-up' || $pageSlug == 'order_finish') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-truck-fast"></i>
                    <span class="nav-link-text">{{ __('Distributed Orders') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if ($pageSlug == 'order_distributed' || $pageSlug == 'order_preparing' || $pageSlug == 'order_waiting-for-pickup' || $pageSlug == 'order_picked-up' || $pageSlug == 'order_finish') show @endif" id="distributed_order">
                    <ul class="nav pl-2">
                        @include('admin.partials.menu_buttons', [
                            'menuItems' => [
                                [
                                    'pageSlug' => 'order_distributed',
                                    'routeName' => 'do.do_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'distributed',
                                    'label' => 'Distributed',
                                ],
                                [
                                    'pageSlug' => 'order_preparing',
                                    'routeName' => 'do.do_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'preparing',
                                    'label' => 'Preparing',
                                ],
                                [
                                    'pageSlug' => 'order_waiting-for-pickup',
                                    'routeName' => 'do.do_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'waiting-for-pickup',
                                    'label' => 'Waiting For Pickup',
                                ],
                                [
                                    'pageSlug' => 'order_picked-up',
                                    'routeName' => 'do.do_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'picked-up',
                                    'label' => 'Picked Up',
                                ],
                                [
                                    'pageSlug' => 'order_finish',
                                    'routeName' => 'do.do_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'finish',
                                    'label' => 'Finish',
                                ],
                            ],
                        ])
                    </ul>
                </div>
            </li>




            {{-- Payment Management  --}}
            <li>
                <a class="@if ($pageSlug == 'payment_Success' || $pageSlug == 'payment_details' || $pageSlug == 'payment_Failed' || $pageSlug == 'payment_Cancel' || $pageSlug == 'payment_Pending' || $pageSlug == 'payment_Processing') @else collapsed @endif" data-toggle="collapse"
                    href="#payment_management"
                    @if ($pageSlug == 'payment_Success' || $pageSlug == 'payment_details' || $pageSlug == 'payment_Failed' || $pageSlug == 'payment_Cancel' || $pageSlug == 'payment_Pending' || $pageSlug == 'payment_Processing') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-credit-card"></i>
                    <span class="nav-link-text">{{ __('Payment Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if ($pageSlug == 'payment_Success' || $pageSlug == 'payment_details' || $pageSlug == 'payment_Failed' || $pageSlug == 'payment_Cancel' || $pageSlug == 'payment_Pending' || $pageSlug == 'payment_Processing') show @endif" id="payment_management">
                    <ul class="nav pl-2">
                        @include('admin.partials.menu_buttons', [
                            'menuItems' => [
                                [
                                    'pageSlug' => 'payment_Pending',
                                    'routeName' => 'pym.payment.payment_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'pending',
                                    'label' => 'Payment List (Pending)',
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
                                    'pageSlug' => 'payment_Processing',
                                    'routeName' => 'pym.payment.payment_list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'processing',
                                    'label' => 'Payment List (Processing)',
                                ],
                            ],
                        ])
                    </ul>
                </div>
            </li>
            {{-- @endif --}}
        </ul>
    </div>
</div>
