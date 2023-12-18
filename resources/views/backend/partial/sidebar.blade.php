
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/img/default/site-logo.jpg') }}"
             alt="{{ config('app.name') }}"
             class="brand-image img-square elevation-3">
    </a>


    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('backend.partial.menu')
            </ul>
        </nav>
    </div>

</aside>