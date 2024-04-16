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
        </ul>
    </div>
</div>
