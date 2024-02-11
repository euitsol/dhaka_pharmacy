<?php

namespace App\Http\Controllers\LAM\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function lamLogin()
    {
        if (Auth::guard('lam')->check() && lam()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('lam.dashboard');
        }
        return view('local_area_manager.login');
    }

    public function lamLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        $check = LocalAreaManager::where('phone', $request->phone)->first();
        if(isset($check)){
            if($check->status == 1){
                if (Auth::guard('lam')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('lam.dashboard');
                }
                flash()->addError('Invalid credentials');
            }else{
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        }else{
            flash()->addError('Local Area Manager Not Found');
        }
        return redirect()->route('local_area_manager.login');
    }
}
