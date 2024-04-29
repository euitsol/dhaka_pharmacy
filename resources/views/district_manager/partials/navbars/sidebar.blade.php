<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('dm.dashboard') }}" class="simple-text logo-mini">{{ __('DP') }}</a>
            <a href="{{ route('dm.dashboard') }}" class="simple-text logo-normal">{{ __('Dhaka Pharmacy') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'dm_dashboard') class="active" @endif>
                <a href="{{route('dm.dashboard')}}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'dm_dashboard') fa-beat-fade @endif"></i>
                    <p>{{ 'Dashboard' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'district_manager_profile') class="active" @endif>
                <a href="{{route('dm.profile.index')}}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'district_manager_profile') fa-beat-fade @endif"></i>
                    <p>{{ 'My Profile' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'kyc_verification') class="active" @endif>
                <a href="{{route('dm.kyc.verification')}}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'kyc_verification') fa-beat-fade @endif"></i>
                    <p>{{ 'KYC Verification Center' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'lam') class="active" @endif>
                <a href="{{ route('dm.lam.list') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'lam') fa-beat-fade @endif"></i>
                    <p>{{ 'Local Area Manager' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'lam_area') class="active" @endif>
                <a href="{{ route('dm.lam_area.list') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'lam_area') fa-beat-fade @endif"></i>
                    <p>{{ 'Operation Areas' }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'user') class="active" @endif>
                <a href="{{ route('dm.user.list') }}">
                    <i class="fa-solid fa-minus @if ($pageSlug == 'user') fa-beat-fade @endif"></i>
                    <p>{{ 'User Management' }}</p>
                </a>
            </li>
            {{-- <li>
                <a class="@if ($pageSlug == 'district_manager') @else collapsed @endif" data-toggle="collapse"
                    href="#district_manager"
                    @if ($pageSlug == 'district_manager') aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="nav-link-text">{{ __('District Manager') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if ($pageSlug == 'district_manager') show @endif" id="district_manager">
                    <ul class="nav pl-2">
                        <li @if ($pageSlug == 'district_manager') class="active" @endif>
                            <a href="">
                                <i class="fa-solid fa-minus @if ($pageSlug == 'district_manager') fa-beat-fade @endif"></i>
                                <p>{{ 'District Manager' }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}

        </ul>
    </div>
</div>
