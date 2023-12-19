<!-- need to remove -->
{{-- <li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ ($pageSlug == 'dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li> --}}
    @include('backend.partial.menu_buttons', [
        'menuItems' => [
            ['pageSlug' => 'dashboard', 'routeName' => 'dashboard','iconClass'=>'fas fa-home', 'label' => 'Dashboard'],
        ]
    ])
{{-- User Management --}}
<li class="nav-item  
    @if(
        $pageSlug == 'user'||
        $pageSlug == 'permission'||
        $pageSlug == 'role'
    )
        menu-open
    @endif
">
        <a href="#" class="nav-link
        @if(
            $pageSlug == 'user'||
            $pageSlug == 'permission'||
            $pageSlug == 'role'
        )
            active
        @endif
        ">
            <i class="nav-icon fas fa-users"></i>
            <p>
                User Management
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview 
            @if(
                $pageSlug == 'user'||
                $pageSlug == 'permission'||
                $pageSlug == 'role'
            )
                d-block
            @endif"
        >

            @include('backend.partial.menu_buttons', [
                'menuItems' => [
                    ['pageSlug' => 'user', 'routeName' => 'um.user.user_list', 'label' => 'View User'],
                    ['pageSlug' => 'role', 'routeName' => 'um.role.role_list', 'label' => 'View Role'],
                    ['pageSlug' => 'permission', 'routeName' => 'um.permission.permission_list', 'label' => 'View Permission'],
                ]
            ])
            {{-- <li class="nav-item">
                <a href="{{route('um.user.user_list')}}"
                    class="nav-link {{ ($pageSlug == 'user') ? 'active' : '' }}" >
                    <i class="nav-icon fas fa-minus {{ ($pageSlug == 'user') ? 'fa-beat' : '' }}"></i>
                    <p>View Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('um.role.role_list')}}"
                    class="nav-link {{ ($pageSlug == 'role') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus {{ ($pageSlug == 'role') ? 'fa-beat' : '' }}"></i>
                    <p>Users Roles</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('um.permission.permission_list')}}"
                    class="nav-link {{ ($pageSlug == 'permission') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus {{ ($pageSlug == 'permission') ? 'fa-beat' : '' }}"></i>
                    <p>Permission</p>
                </a>
            </li> --}}
        </ul>
    </li>