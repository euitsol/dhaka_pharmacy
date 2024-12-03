<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckKycMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = 'web')
    {
        if ($guard != 'admin') {
            $user = Auth::guard($guard)->user();
            if (!$user) {
                if ($guard == 'rider') {
                    return redirect()->route('rider.login');
                } elseif ($guard == 'pharmacy') {
                    return redirect()->route('pharmacy.login');
                } elseif ($guard == 'dm') {
                    return redirect()->route('district_manager.login');
                } elseif ($guard == 'lam') {
                    return redirect()->route('local_area_manager.login');
                } else {
                    return redirect()->route('login');
                }
            }
            if (!$user->kyc_status) {
                return redirect()->route($guard . '.kyc.notice');
            }
        }
        return $next($request);
    }
}