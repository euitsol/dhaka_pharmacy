<!-- need to remove -->
{{-- <li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ ($pageSlug == 'dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li> --}}
@include('backend.partial.menu_buttons', [
    'menuItems' => [
        [
            'pageSlug' => 'dashboard',
            'routeName' => 'dashboard',
            'iconClass' => 'fas fa-home',
            'label' => 'Dashboard',
        ],
    ],
])
{{-- Admin Management --}}
<li class="nav-item  
    @if ($pageSlug == 'user' || $pageSlug == 'permission' || $pageSlug == 'role') menu-open @endif
    ">
    <a href="#" class="nav-link
        @if ($pageSlug == 'user' || $pageSlug == 'permission' || $pageSlug == 'role') active @endif
        ">
        <i class="nav-icon fas fa-users"></i>
        <p>
            User Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview 
            @if ($pageSlug == 'user' || $pageSlug == 'permission' || $pageSlug == 'role') d-block @endif">

        @include('backend.partial.menu_buttons', [
            'menuItems' => [
                ['pageSlug' => 'user', 'routeName' => 'um.user.user_list', 'label' => 'View User'],
                ['pageSlug' => 'role', 'routeName' => 'um.role.role_list', 'label' => 'View Role'],
                [
                    'pageSlug' => 'permission',
                    'routeName' => 'um.permission.permission_list',
                    'label' => 'View Permission',
                ],
            ],
        ])
    </ul>
</li>
@include('backend.partial.menu_buttons', [
    'menuItems' => [
        [
            'pageSlug' => 'users',
            'routeName' => 'umm.user.user_list',
            'iconClass' => 'fas fa-users',
            'label' => 'Users',
        ],
    ],
])
