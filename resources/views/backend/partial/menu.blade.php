<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ ($pageSlug == 'dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
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
        <a href="#" class="nav-link">
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
            <li class="nav-item">
                <a href="{{route('um.user.user_list')}}"
                    class="nav-link">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>View Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#"
                    class="nav-link">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Users Roles</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#"
                    class="nav-link">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Permission</p>
                </a>
            </li>
        </ul>
    </li>