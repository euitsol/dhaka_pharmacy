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
        </ul>
    </div>
</div>
