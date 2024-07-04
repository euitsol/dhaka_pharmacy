<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\User\ResetPaswordRequest;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\SmsTrait;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SmsTrait;

    public function forgotPassword(): View
    {
        return view('auth.forgot');
    }

    public function forgotPasswordOtp(SendOtpRequest $req)
    {

        $user = User::where('phone', $req->phone)->first();
        $data['user'] = $user;
        if ($user) {
            $user->otp = otp();
            $user->save();
            // SMS SEND
            $verification_sms = "Your verification code is $user->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($user->phone, $verification_sms);
            if ($result == true) {
                $s['uid'] = encrypt($user->id);
                $s['message'] = 'The verification code has been sent successfully.';
                $s['forgot'] = true;
                $s['otp'] = true;
                $s['title'] = "VERIFY YOUR PHONE TO RESET PASSWORD";
                Session::put('data', $s);
                return redirect()->route('use.send_otp');
            } else {
                flash()->addError('Oops! Something went wrong. Please try again.');
                return redirect()->back();
            }
        }
        flash()->addError('User Not Found.');
        return redirect()->back();
    }

    public function resetPassword()
    {
        $session = Session::get('data');
        unset($session['forgot']);
        Session::put('data', $session);
        if (isset(Session::get('data')['uid'])) {
            return view('auth.reset');
        }
        return redirect()->route('login');
    }

    public function resetPasswordStore(ResetPaswordRequest $req)
    {
        $user = User::findOrFail(decrypt(Session::get('data')['uid']));
        $user->password = $req->password;
        $user->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->route('login');
    }
}
