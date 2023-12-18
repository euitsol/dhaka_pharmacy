<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/img/default/site-logo.jpg') }}" alt="AdminLTE Logo" class="brand-image elevation-3">
    </a>

    <div class="sidebar">

        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('backend/img/default/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name;}}</a>
            </div>
        </div> --}}

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @include('backend.partial.menu')
            </ul>
        </nav>

    </div>

</aside>
