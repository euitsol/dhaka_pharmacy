<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AdminLoginController extends Controller
{
    public function adminLogin(){
        return view('backend.admin.login');
    }

    public function adminLoginCheck(AdminRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed
            return redirect()->route('dashboard'); // Replace 'admin.dashboard' with your actual admin dashboard route
        } else {
            // Authentication failed
            return back()->withInput()->withStatus(__("Invalid credentials"));
        }
    }
}
