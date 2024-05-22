<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('rider.dashboard') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('rider.dashboard') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'rider_dashboard') class="active" @endif>
                <a href="{{ route('rider.dashboard') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'rider_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ 'Dashboard' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'rider_profile') class="active" @endif>
                <a href="{{ route('rider.profile.index') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'rider_profile') fa-beat-fade @endif"></i>
                    <p>{{ 'My Profile' }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{route('rider.kyc.verification')}}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ 'KYC Verification Center' }}</p>
                </a>
            </li>
            <li>
                <a class="@if ($pageSlug == 'dispute_orders' || $pageSlug == 'cancel_orders' || $pageSlug == 'cancel-complete_orders' || $pageSlug == 'ongoing_orders' || $pageSlug == 'collect_orders' || $pageSlug == 'delivered_orders' || $pageSlug == 'complete_orders') @else collapsed @endif" data-toggle="collapse"
                    href="#order_managements"
                    @if ($pageSlug == 'dispute_orders' || $pageSlug == 'cancel_orders' || $pageSlug == 'cancel-complete_orders' || $pageSlug == 'ongoing_orders' || $pageSlug == 'collect_orders' || $pageSlug == 'delivered_orders' || $pageSlug == 'complete_orders') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-network-wired"></i>
                    <span class="nav-link-text">{{ __('Order Managements') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse @if ($pageSlug == 'dispute_orders' || $pageSlug == 'cancel_orders' || $pageSlug == 'cancel-complete_orders' || $pageSlug == 'ongoing_orders' || $pageSlug == 'collect_orders' || $pageSlug == 'delivered_orders' || $pageSlug == 'complete_orders') show @endif" id="order_managements">
                    <ul class="nav pl-2">
                        
                        <li @if ($pageSlug == 'ongoing_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','ongoing') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'ongoing_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'My Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'collect_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','collect') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'collect_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Collect Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'delivered_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','delivered') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'delivered_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Delivered Orders' }}</p>
                            </a>
                        </li>
                        
                        <li @if ($pageSlug == 'complete_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','complete') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'complete_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Complete Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'dispute_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','dispute') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'dispute_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Dispute Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'cancel_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','cancel') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'cancel_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Cancel Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'cancel-complete_orders') class="active" @endif>
                            <a href="{{ route('rider.order_management.index','cancel-complete') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'cancel-complete_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Cancel Complete Orders' }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
