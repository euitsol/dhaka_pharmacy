<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'lam_dashboard') class="active" @endif>
                <a href="{{ route('lam.dashboard') }}">
                    <i class="fa-solid fa-chart-line @if ($pageSlug == 'lam_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'user') class="active" @endif>
                <a href="{{ route('lam.user.list') }}">
                    <i class="fa-solid fa-users @if ($pageSlug == 'user') fa-beat-fade @endif"></i>
                    <p>{{ __('User Management') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'wm') class="active" @endif>
                <a href="{{ route('lam.wm.list') }}">
                    <i class="fa-regular fa-credit-card @if ($pageSlug == 'wm') fa-beat-fade @endif"></i>
                    <p>{{ __('Withdraw Method') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'earning') class="active" @endif>
                <a href="{{ route('lam.earning.index') }}">
                    <i
                        class="fa-solid fa-hand-holding-dollar @if ($pageSlug == 'earning') fa-beat-fade @endif"></i>
                    <p>{{ __('My Earnings') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{ route('lam.kyc.verification') }}">
                    <i class="fa-solid fa-shield-alt @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ __('KYC Verification Center') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'local_area_manager_profile') class="active" @endif>
                <a href="{{ route('lam.profile.index') }}">
                    <i class="fa-solid fa-user @if ($pageSlug == 'local_area_manager_profile') fa-beat-fade @endif"></i>
                    <p>{{ __('My Profile') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'operational_area') class="active" @endif>
                <a href="{{ route('lam.operational_area.list') }}">
                    <i class="fa-solid fa-earth-americas @if ($pageSlug == 'operational_area') fa-beat-fade @endif"></i>
                    <p>{{ __('Operation Areas') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'feedback') class="active" @endif>
                <a href="{{ route('lam.fdk.index') }}">
                    <i class="fa-regular fa-thumbs-up @if ($pageSlug == 'feedback') fa-beat-fade @endif"></i>
                    <p>{{ __('Feedback') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
