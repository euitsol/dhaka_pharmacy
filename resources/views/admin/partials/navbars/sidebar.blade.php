<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('dashboard') }}" class="simple-text logo-mini">{{ _('DP') }}</a>
            <a href="{{ route('dashboard') }}" class="simple-text logo-normal">{{ _('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">
              @include('admin.partials.menu_buttons', [
                'menuItems' => [
                    ['pageSlug' => 'dashboard', 'routeName' => 'dashboard', 'iconClass' => 'fa-solid fa-chart-line', 'label' => 'Dashboard'],
                    ]
               ])


            {{-- Admin Management --}}
            <li>
                <a class="@if(
                        $pageSlug == 'role' ||
                        $pageSlug == 'permission'||
                        $pageSlug == 'admin'
                    )@else collapsed @endif" data-toggle="collapse" href="#admin-management" @if (
                        $pageSlug == 'role' ||
                        $pageSlug == 'permission'||
                        $pageSlug == 'admin'
                    ) aria-expanded="true" @else aria-expanded="false"@endif>
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="nav-link-text" >{{ __('Admin Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if (
                    $pageSlug == 'role' ||
                    $pageSlug == 'permission'||
                    $pageSlug == 'admin'
                ) show @endif" id="admin-management">
                    <ul class="nav pl-2">
                        @include('admin.partials.menu_buttons', [
                            'menuItems' => [
                                ['pageSlug' => 'admin', 'routeName' => 'am.admin.admin_list', 'iconClass' => 'fa-solid fa-minus', 'label' => 'Admins'],
                                ['pageSlug' => 'role', 'routeName' => 'am.role.role_list', 'iconClass' => 'fa-solid fa-minus', 'label' => 'Roles'],
                                ['pageSlug' => 'permission', 'routeName' => 'am.permission.permission_list', 'iconClass' => 'fa-solid fa-minus', 'label' => 'Permission'],
                            ]
                        ])
                    </ul>
                </div>
            </li>
            {{-- User Management --}}
            <li>
                <a class="@if(
                        $pageSlug == 'user'
                    )@else collapsed @endif" data-toggle="collapse" href="#user-management" @if (
                        $pageSlug == 'user'
                    ) aria-expanded="true" @else aria-expanded="false"@endif>
                    <i class="fa-solid fa-users"></i>
                    <span class="nav-link-text" >{{ __('User Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if (
                    $pageSlug == 'user'
                ) show @endif" id="user-management">
                    <ul class="nav pl-2">
                        @include('admin.partials.menu_buttons', [
                            'menuItems' => [
                                ['pageSlug' => 'user', 'routeName' => 'um.user.user_list', 'iconClass' => 'fa-solid fa-minus', 'label' => 'Users'],
                            ]
                        ])
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
