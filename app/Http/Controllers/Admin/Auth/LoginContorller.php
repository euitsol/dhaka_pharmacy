<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginContorller extends Controller
{
    public function adminLogin():RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('dashboard');
        }
        return redirect()->route('admin.login');
    }

    public function adminLoginCheck(Request $request):RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('dashboard');
        }
        flash()->addError('Invalid credentials');
        return redirect()->route('admin.login');
    }  
}
