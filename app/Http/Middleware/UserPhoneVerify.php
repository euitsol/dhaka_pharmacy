<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserPhoneVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(user()->is_verify === 1){
            return $next($request);
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
        }else{
            $s['uid']= encrypt(user()->id);
            $s['otp'] = true;
            $s['title'] = "VERIFY YOUR PHONE NUMBER";
            $s['message'] = "Please verify your phone number.";
            Session::put('data', $s);
            Auth::guard('web')->logout();
            return redirect()->route('use.send_otp');
        }

    }
}
