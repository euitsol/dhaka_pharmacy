<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        if (Auth::check()) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('user.profile');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('user.profile');
        }
        flash()->addError('Invalid credentials');
        return redirect()->route('login');
    }








    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        } elseif (Auth::guard('pharmacy')->check()) {
            Auth::guard('pharmacy')->logout();
            return redirect()->route('pharmacy.login');
        } elseif (Auth::guard('dm')->check()) {
            Auth::guard('dm')->logout();
            return redirect()->route('district_manager.login');
        } elseif (Auth::guard('lam')->check()) {
            Auth::guard('lam')->logout();
            return redirect()->route('local_area_manager.login');
        } elseif (Auth::check()) {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
