<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Http\Traits\SmsTrait;

class RegisterController extends Controller
{

    use SmsTrait;
    public function register()
    {
        Session::forget('data');
        if (Auth::guard('web')->check()) {
            return redirect(route('user.dashboard'));
        }
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

        // SMS SEND
        $verification_sms = "Your verification code is $user->otp. Please enter this code to verify your phone.";
        $result = $this->send_otp_sms($user->phone, $verification_sms);


        $s['uid'] = encrypt($user->id);
        $s['otp'] = true;
        $s['title'] = "VERIFY YOUR PHONE NUMBER";
        if ($result === true) {
            $s['message'] = 'Your registration was successful, and a verification code has been sent to your phone.';
        } else {
            $s['message'] = $result;
        }

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
