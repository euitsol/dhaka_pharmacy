<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function register(): View
    {
        Session::forget('data');
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

        $s['uid'] = encrypt($user->id);
        $s['otp'] = true;
        $s['title'] = "VERIFY YOUR PHONE NUMBER";
        $s['message'] = 'Your registration was successful, and a verification code has been sent to your phone.';
        Session::put('data', $s);
        return redirect()->route('use.send_otp');
    }
    public function phoneValidation($phone)
    {
        $user = User::where('phone', $phone)->first();
        $data['success'] = false;
        if ($user) {
            $data['success'] = true;
        }
        return response()->json($data);
    }
}
