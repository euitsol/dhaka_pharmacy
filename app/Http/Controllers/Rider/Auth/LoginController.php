<?php

namespace App\Http\Controllers\Rider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function riderLogin()
    {

        if (Auth::guard('rider')->check() && rider()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('rider.dashboard');
        }
        return view('rider.login');
    }

    public function riderLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        $check = Rider::where('phone', $request->phone)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('rider')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('rider.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Local Area Manager Not Found');
        }
        return redirect()->route('rider.login');
    }

    public function logout()
    {
        Auth::guard('rider')->logout();
        return redirect()->route('rider.login');
    }
}
