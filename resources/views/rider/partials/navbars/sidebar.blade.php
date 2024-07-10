<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'rider_dashboard') class="active" @endif>
                <a href="{{ route('rider.dashboard') }}">
                    <i class="fa-solid fa-chart-line @if ($pageSlug == 'rider_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ 'Dashboard' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'rider_profile') class="active" @endif>
                <a href="{{ route('rider.profile.index') }}">
                    <i class="fa-solid fa-user @if ($pageSlug == 'rider_profile') fa-beat-fade @endif"></i>
                    <p>{{ 'My Profile' }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{ route('rider.kyc.verification') }}">
                    <i class="fa-solid fa-shield-alt @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ 'KYC Verification Center' }}</p>
                </a>
            </li>
            <li>
                <a class="@if (
                    $pageSlug == 'dispute_orders' ||
                        $pageSlug == 'assigned_orders' ||
                        $pageSlug == 'picking-up_orders' ||
                        $pageSlug == 'picked-up_orders' ||
                        $pageSlug == 'delivered_orders' ||
                        $pageSlug == 'delivering_orders') @else collapsed @endif" data-toggle="collapse"
                    href="#order_managements"
                    @if (
                        $pageSlug == 'dispute_orders' ||
                            $pageSlug == 'assigned_orders' ||
                            $pageSlug == 'picking-up_orders' ||
                            $pageSlug == 'picked-up_orders' ||
                            $pageSlug == 'delivered_orders' ||
                            $pageSlug == 'delivering_orders') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-network-wired"></i>
                    <span class="nav-link-text">{{ __('Order Managements') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse @if (
                    $pageSlug == 'dispute_orders' ||
                        $pageSlug == 'assigned_orders' ||
                        $pageSlug == 'picking-up_orders' ||
                        $pageSlug == 'picked-up_orders' ||
                        $pageSlug == 'delivered_orders' ||
                        $pageSlug == 'delivering_orders') show @endif" id="order_managements">
                    <ul class="nav pl-2">

                        <li @if ($pageSlug == 'assigned_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'assigned') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'assigned_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Assigned Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'picked-up_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'picked-up') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'picked-up_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Picked Up Orders' }}</p>
                            </a>
                        </li>
                        {{-- <li @if ($pageSlug == 'picking-up_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'picking-up') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'picking-up_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Picking Up' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'picked-up_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'picked-up') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'picked-up_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Picked Up' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'delivering_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'delivering') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'delivering_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Delivering' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'delivered_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'delivered') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'delivered_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Delivered' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'dispute_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index', 'dispute') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'dispute_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Dispute' }}</p>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'earning') class="active" @endif>
                <a href="{{ route('rider.earning.index') }}">
                    <i
                        class="fa-solid fa-hand-holding-dollar @if ($pageSlug == 'earning') fa-beat-fade @endif"></i>
                    <p>{{ 'My Earnings' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'feedback') class="active" @endif>
                <a href="{{ route('rider.fdk.index') }}">
                    <i class="fa-regular fa-thumbs-up @if ($pageSlug == 'feedback') fa-beat-fade @endif"></i>
                    <p>{{ 'Feedback' }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
