<?php

namespace App\Http\Controllers\DM\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function dmLogin()
    {
        if (Auth::guard('dm')->check()) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('dm.dashboard');
        }
        return view('district_manager.login');
    }

    public function dmLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::guard('dm')->attempt($credentials)) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('dm.dashboard');
        }
        flash()->addError('Invalid credentials');
        return redirect()->route('district_manager.login');
    }
}
