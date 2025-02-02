<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">
            @include('hub.partials.menu_buttons', [
                'menuItems' => [
                    [
                        'pageSlug' => 'dashboard',
                        'routeName' => 'hub.dashboard',
                        'iconClass' => 'fa-solid fa-chart-line',
                        'label' => 'Dashboard',
                    ],
                ],
            ])
        </ul>
    </div>
</div>
