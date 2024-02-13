<?php

namespace App\Http\Controllers\DM\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\DistrictManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function dmLogin()
    {
        if (Auth::guard('dm')->check() && dm()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('dm.dashboard');
        }
        return view('district_manager.login');
    }

    public function dmLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');
        $check = DistrictManager::where('phone', $request->phone)->first();
        if(isset($check)){
            if($check->status == 1){
                if (Auth::guard('dm')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('dm.dashboard');
                }
                flash()->addError('Invalid credentials');
            }else{
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        }else{
            flash()->addError('District Manager Not Found');
        }
        return redirect()->route('district_manager.login');
        
        
    }
}
