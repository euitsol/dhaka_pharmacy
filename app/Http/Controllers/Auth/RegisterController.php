<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisterController extends BaseController
{
    public function register(): View
    {
        return view('auth.register');
    }
    protected function rStore(UserRegistrationRequest $req)
    {
        $user =  new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->password = Hash::make($req->password);
        $user->otp = otp();
        $user->save();
        $s['data']= encrypt($user->id);
        $s['message'] = 'Your registration was successful, and a verification code has been sent to your phone.';
        return redirect()->route('use.send_otp',$s);
    }
    public function phoneValidation($phone){
        $user = User::where('phone',$phone)->first();
        $data['success'] = false;
        if($user){
            $data['success'] = true;
        }
        return response()->json($data);
    }
}
