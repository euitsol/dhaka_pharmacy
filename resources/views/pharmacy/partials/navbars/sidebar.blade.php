<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'pharmacy_dashboard') class="active" @endif>
                <a href="{{ route('pharmacy.dashboard') }}">
                    <i class="fa-solid fa-chart-line @if ($pageSlug == 'pharmacy_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ 'Dashboard' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'pharmacy_profile') class="active" @endif>
                <a href="{{ route('pharmacy.profile.index') }}">
                    <i class="fa-solid fa-user @if ($pageSlug == 'pharmacy_profile') fa-beat-fade @endif"></i>
                    <p>{{ 'My Profile' }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{ route('pharmacy.kyc.verification') }}">
                    <i class="fa-solid fa-shield-alt @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ 'KYC Verification Center' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'operational_area') class="active" @endif>
                <a href="{{ route('pharmacy.operational_area.list') }}">
                    <i class="fa-solid fa-earth-americas @if ($pageSlug == 'operational_area') fa-beat-fade @endif"></i>
                    <p>{{ 'Operation Areas' }}</p>
                </a>
            </li>

            <li>
                <a class="@if (
                    $pageSlug == 'pending_orders' ||
                        $pageSlug == 'preparing_orders' ||
                        $pageSlug == 'waiting-for-rider_orders' ||
                        $pageSlug == 'picked-up_orders' ||
                        $pageSlug == 'dispute_orders' ||
                        $pageSlug == 'cancel_orders' ||
                        $pageSlug == 'delivered_orders') @else collapsed @endif" data-toggle="collapse"
                    href="#order_managements"
                    @if (
                        $pageSlug == 'pending_orders' ||
                            $pageSlug == 'preparing_orders' ||
                            $pageSlug == 'waiting-for-rider_orders' ||
                            $pageSlug == 'picked-up_orders' ||
                            $pageSlug == 'dispute_orders' ||
                            $pageSlug == 'cancel_orders' ||
                            $pageSlug == 'delivered_orders') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-network-wired"></i>
                    <span class="nav-link-text">{{ __('Order Managements') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse @if (
                    $pageSlug == 'pending_orders' ||
                        $pageSlug == 'preparing_orders' ||
                        $pageSlug == 'waiting-for-rider_orders' ||
                        $pageSlug == 'picked-up_orders' ||
                        $pageSlug == 'dispute_orders' ||
                        $pageSlug == 'cancel_orders' ||
                        $pageSlug == 'delivered_orders') show @endif" id="order_managements">
                    <ul class="nav pl-2">
                        <li @if ($pageSlug == 'pending_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'pending') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'pending_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Pending Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'preparing_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'preparing') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'preparing_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Preparing Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'waiting-for-rider_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'waiting-for-rider') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'waiting-for-rider_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Waiting For Rider Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'picked-up_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'picked-up') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'picked-up_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Picked Up Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'delivered_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'delivered') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'delivered_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Delivered Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'dispute_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'dispute') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'dispute_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Dispute Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'cancel_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index', 'cancel') }}">
                                <i
                                    class="fa-solid fa-minus @if ($pageSlug == 'cancel_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Cancel Orders' }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'feedback') class="active" @endif>
                <a href="{{ route('pharmacy.fdk.index') }}">
                    <i class="fa-regular fa-thumbs-up @if ($pageSlug == 'feedback') fa-beat-fade @endif"></i>
                    <p>{{ 'Feedback' }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
