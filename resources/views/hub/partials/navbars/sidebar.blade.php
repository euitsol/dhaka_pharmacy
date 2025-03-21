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

            <li>
                <a class="@if ($pageSlug == 'order_assigned' || $pageSlug == 'order_collecting' || $pageSlug == 'order_collected' || $pageSlug == 'order_prepared' || $pageSlug == 'order_dispatched' || $pageSlug == 'order_all') @else collapsed @endif" data-toggle="collapse"
                    href="#om"
                    @if ($pageSlug == 'order_assigned' || $pageSlug == 'order_collecting' || $pageSlug == 'order_collected' || $pageSlug == 'order_prepared' || $pageSlug == 'order_dispatched' || $pageSlug == 'order_all') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-truck"></i>
                    <span class="nav-link-text">{{ __('Order Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if ($pageSlug == 'order_assigned' || $pageSlug == 'order_collecting' || $pageSlug == 'order_collected' || $pageSlug == 'order_prepared' || $pageSlug == 'order_dispatched' || $pageSlug == 'order_all') show @endif" id="om">
                    <ul class="nav pl-2">
                        @include('hub.partials.menu_buttons', [
                            'menuItems' => [
                                [
                                    'pageSlug' => 'order_assigned',
                                    'routeName' => 'hub.order.list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'assigned',
                                    'label' => 'Assigned Orders',
                                ],
                                [
                                    'pageSlug' => 'order_collecting',
                                    'routeName' => 'hub.order.list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'collecting',
                                    'label' => 'Collecting Orders',
                                ],
                                [
                                    'pageSlug' => 'order_collected',
                                    'routeName' => 'hub.order.list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'collected',
                                    'label' => 'Collected Orders',
                                ],
                                [
                                    'pageSlug' => 'order_prepared',
                                    'routeName' => 'hub.order.list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'prepared',
                                    'label' => 'Prepared Orders',
                                ],
                                [
                                    'pageSlug' => 'order_dispatched',
                                    'routeName' => 'hub.order.list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'dispatched',
                                    'label' => 'Dispatched Orders',
                                ],
                                [
                                    'pageSlug' => 'order_all',
                                    'routeName' => 'hub.order.list',
                                    'iconClass' => 'fa-solid fa-minus',
                                    'params' => 'all',
                                    'label' => 'All Orders',
                                ],
                            ],
                        ])
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>
