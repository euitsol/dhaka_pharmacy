<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function pharmacyLogin()
    {
        if (Auth::guard('pharmacy')->check() && pharmacy()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('pharmacy.dashboard');
        }
        return view('pharmacy.login');
    }

    public function pharmacyLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $check = Pharmacy::where('email', $request->email)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('pharmacy')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('pharmacy.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Pharmacy User Not Found');
        }
        return redirect()->route('pharmacy.login');
    }
    public function logout()
    {
        Auth::guard('pharmacy')->logout();
        return redirect()->route('pharmacy.login');
    }
}
