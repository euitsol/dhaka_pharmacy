<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function pharmacyLogin()
    {
        if (Auth::guard('pharmacy')->check()) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('pharmacy.profile');
        }
        return view('pharmacy.login');
    }

    public function pharmacyLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('pharmacy')->attempt($credentials)) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('pharmacy.profile');
        }
        flash()->addError('Invalid credentials');
        return redirect()->route('pharmacy.login');
    }
}
