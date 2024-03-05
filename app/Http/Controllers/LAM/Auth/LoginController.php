<?php

namespace App\Http\Controllers\LAM\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\DistrictManager;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;


class LoginController extends BaseController
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


    function lamRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'phone' => 'required|numeric|digits:11|unique:local_area_managers,phone',
            'password' => 'required|min:6|confirmed',
            'dm_id' => 'required|exists:district_managers,id',
        ]);
        LocalAreaManager::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'dm_id' => $request->dm_id,
        ]);
        $credentials = $request->only('phone', 'password');
        Auth::guard('lam')->attempt($credentials);
        return redirect()->route('local_area_manager.login');
    }

    function reference($id){
        $data = DistrictManager::where('id',$id)->first();
        if(!$data){
            return response()->json(['status'=>false]);
        }
        return response()->json(['status'=>true]);
        
    }
    public function logout()
    {
        Auth::guard('lam')->logout();
        return redirect()->route('local_area_manager.login');
    }
}
