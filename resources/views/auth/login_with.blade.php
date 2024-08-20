<p class="or-login">{{ __('Or login With') }}</p>
<div class="other-login">
    <a href="{{ route('login_with_google') }}" class="google">
        <img src="{{ asset('user/user_login/img/logos--google-icon.svg') }}" alt="">
        <span>{{ __('Google') }}</span>
    </a>
    <a href="{{ route('login_with_facebook') }}" class="facebook">
        <img src="{{ asset('user/user_login/img/logos--facebook.svg') }}" alt="">
        <span>{{ __('Facebook') }}</span>
    </a>
</div>
