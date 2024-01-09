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
    public function adminLogin(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('admin.login');
    }

    public function adminLoginCheck(Request $request):RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('dashboard');
        }
    }

    public function pharmacyLogin(): View
    {
        if (Auth::guard('pharmacy')->check()) {
            return redirect()->route('dashboard');
        }
        return view('pharmacy.login');
    }

    public function pharmacyLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('pharmacy')->attempt($credentials)) {
            return redirect()->route('pharmacy.profile');
        }
    }

    
}
