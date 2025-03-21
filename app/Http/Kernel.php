<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SetLocale::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'admin' => [
            'web',
            'auth:admin', // Use the 'admin' guard for admin routes
        ],
        'pharmacy' => [
            'web',
            'auth:pharmacy', // Use the 'pharmacy' guard for pharmacy routes
        ],
        'dm' => [
            'web',
            'auth:dm', // Use the 'dm' guard for dm routes
        ],
        'lam' => [
            'web',
            'auth:lam', // Use the 'lam' guard for lam routes
        ],
        'rider' => [
            'web',
            'auth:rider', // Use the 'rider' guard for rider routes
        ],
        'staff' => [
            'web',
            'auth:staff', // Use the 'rider' guard for rider routes
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'permission' => \App\Http\Middleware\CheckPermissionMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'pharmacy' => \App\Http\Middleware\PharmacyMiddleware::class,
        'dm' => \App\Http\Middleware\DistrictManagerMiddleware::class,
        'lam' => \App\Http\Middleware\LocalAreaManagerMiddleware::class,
        'rider' => \App\Http\Middleware\RiderMiddleware::class,
        'user_phone_verify' => \App\Http\Middleware\UserPhoneVerify::class,
        'lam_phone_verify' => \App\Http\Middleware\LamPhoneVerify::class,
        'dm_phone_verify' => \App\Http\Middleware\DmPhoneVerify::class,
        'check_kyc' => \App\Http\Middleware\CheckKycMiddleware::class,
        'staff' => \App\Http\Middleware\StaffMiddleware::class,
        'webhook.auth' => \App\Http\Middleware\VerifyWebhookToken::class,
    ];
}
