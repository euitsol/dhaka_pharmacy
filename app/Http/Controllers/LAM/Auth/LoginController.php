<?php

namespace App\Http\Controllers\lam\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function lamLogin()
    {
        if (Auth::guard('lam')->check()) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('local_area_manager.profile');
        }
        return view('local_area_manager.login');
    }

    public function lamLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::guard('lam')->attempt($credentials)) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('local_area_manager.profile');
        }
        flash()->addError('Invalid credentials');
        return redirect()->route('local_area_manager.login');
    }
}
