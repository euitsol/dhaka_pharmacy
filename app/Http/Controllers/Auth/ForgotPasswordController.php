<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotSentOtpRequest;
use App\Http\Requests\User\ResetPaswordRequest;
use App\Models\User;
use Illuminate\View\View;
use App\Http\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.forgot');
    }

    public function forgotPasswordOtp(ForgotSentOtpRequest $req)
    {

        $user = User::where('phone', $req->phone)->first();
        if ($user) {
            $user->otp = otp();
            $user->phone_verified_at = Carbon::now();
            $user->save();
            // SMS SEND
            $verification_sms = "Your verification code is $user->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($user->phone, $verification_sms);
            if ($result === true) {
                session()->put('forgot', true);
                flash()->addSuccess('The verification code has been sent successfully.');
                return redirect()->route('use.otp', encrypt($user->id));
            } else {
                flash()->addError($result);
                return redirect()->back();
            }
        }
        flash()->addError('Invalid phone number.');
        return redirect()->back();
    }

    public function resetPassword($user_id)
    {
        session()->forget('forgot');
        return view('auth.reset', compact('user_id'));
    }

    public function resetPasswordStore(ResetPaswordRequest $req, $user_id)
    {
        $user = User::findOrFail(decrypt($user_id));
        $user->password = $req->password;
        $user->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->route('login');
    }
}
