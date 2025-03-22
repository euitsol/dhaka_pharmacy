
<p class="or-login">{{ __('Or login With') }}</p>
<div class="other-login">
    <a href="{{ route('google.redirect') }}" class="google">
        <img src="{{ asset('user/user_login/img/logos--google-icon.svg') }}" alt="">
        <span>{{ __('Google') }}</span>
    </a>
    <a href="{{ route('fb.redirect') }}" class="facebook d-none">
        <img src="{{ asset('user/user_login/img/logos--facebook.svg') }}" alt="">
        <span>{{ __('Facebook') }}</span>
    </a>
</div>
