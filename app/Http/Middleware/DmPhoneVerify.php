<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DmPhoneVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (dm()->is_verify == 1) {
            return $next($request);
        } else {
            flash()->addError('Please verify your phone number first');
            return redirect()->route('district_manager.phone.verify.notice');
        }
    }
}