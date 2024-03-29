<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('dm')->check()){
            return redirect()->route('district_manager.login');
        }

        if((Auth::guard('dm')->check()) && (Auth::guard('dm')->user()->status == 0)){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            flash()->addError('Your account is not active. Please contact support.');
            return redirect()->route('district_manager.login');

        }
        return $next($request);
    }
}
