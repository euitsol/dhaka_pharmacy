<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'lam_dashboard') class="active" @endif>
                <a href="{{ route('lam.dashboard') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'lam_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ 'Dashboard' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'local_area_manager_profile') class="active" @endif>
                <a href="{{ route('lam.profile.index') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'local_area_manager_profile') fa-beat-fade @endif"></i>
                    <p>{{ 'My Profile' }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{ route('lam.kyc.verification') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ 'KYC Verification Center' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'user') class="active" @endif>
                <a href="{{ route('lam.user.list') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'user') fa-beat-fade @endif"></i>
                    <p>{{ 'User Management' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'operational_area') class="active" @endif>
                <a href="{{ route('lam.operational_area.list') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'operational_area') fa-beat-fade @endif"></i>
                    <p>{{ 'Operation Areas' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'feedback') class="active" @endif>
                <a href="{{ route('lam.fdk.index') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'feedback') fa-beat-fade @endif"></i>
                    <p>{{ 'Feedback' }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
