<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('pharmacy.dashboard') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('pharmacy.dashboard') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'pharmacy_dashboard') class="active" @endif>
                <a href="{{ route('pharmacy.dashboard') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'pharmacy_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ 'Dashboard' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'pharmacy_profile') class="active" @endif>
                <a href="{{ route('pharmacy.profile.index') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'pharmacy_profile') fa-beat-fade @endif"></i>
                    <p>{{ 'My Profile' }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{route('pharmacy.kyc.verification')}}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ 'KYC Verification Center' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'operational_area') class="active" @endif>
                <a href="{{ route('pharmacy.operational_area.list') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'operational_area') fa-beat-fade @endif"></i>
                    <p>{{ 'Operation Areas' }}</p>
                </a>
            </li>

            <li>
                <a class="@if ($pageSlug == 'pending_orders' || $pageSlug == 'distributed_orders' || $pageSlug == 'dispute_orders') @else collapsed @endif" data-toggle="collapse"
                    href="#order_managements"
                    @if ($pageSlug == 'pending_orders' || $pageSlug == 'distributed_orders' || $pageSlug == 'dispute_orders') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-network-wired"></i>
                    <span class="nav-link-text">{{ __('Order Managements') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse @if ($pageSlug == 'pending_orders' || $pageSlug == 'waiting-for-rider_orders' || $pageSlug == 'dispute_orders' || $pageSlug == 'old-disputed_orders' || $pageSlug == 'complete_orders') show @endif" id="order_managements">
                    <ul class="nav pl-2">
                        <li @if ($pageSlug == 'pending_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index','pending') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'pending_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Pending Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'waiting-for-rider_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index','waiting-for-rider') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'waiting-for-rider_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Waiting For Rider Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'dispute_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index','dispute') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'dispute_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Dispute Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'old-disputed_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index','old-disputed') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'old-disputed_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Old Disputed Orders' }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'complete_orders') class="active" @endif>
                            <a href="{{ route('pharmacy.order_management.index','complete') }}">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'complete_orders') fa-beat-fade @endif"></i>
                                <p>{{ 'Complete Orders' }}</p>
                            </a>
                        </li>
                        




                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
