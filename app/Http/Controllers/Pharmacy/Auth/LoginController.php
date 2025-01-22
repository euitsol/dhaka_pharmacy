<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Traits\MailSentTrait;

class LoginController extends Controller
{
    use MailSentTrait;
    public function pharmacyLogin()
    {
        if (Auth::guard('pharmacy')->check() && pharmacy()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('pharmacy.dashboard');
        }
        return view('pharmacy.auth.login');
    }

    public function pharmacyLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $check = Pharmacy::where('email', $request->email)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('pharmacy')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('pharmacy.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Pharmacy User Not Found');
        }
        return redirect()->route('pharmacy.login');
    }
    public function logout()
    {
        Auth::guard('pharmacy')->logout();
        return redirect()->route('pharmacy.login');
    }


    public function forgot()
    {
        if (Auth::guard('pharmacy')->check() && pharmacy()->status == 1) {
            return redirect()->route('pharmacy.dashboard');
        }
        return view('pharmacy.auth.forgot');
    }

    public function send_otp(Request $request): RedirectResponse
    {
        $pharmacy = Pharmacy::where('email', $request->email)->first();
        if ($pharmacy) {
            $pharmacy->otp = otp();
            $pharmacy->email_verified_at = Carbon::now();
            $pharmacy->save();
            $mail = $this->sendOtpMail($pharmacy);
            if ($mail) {
                flash()->addSuccess('The verification code has been successfully sent to your email');
                return redirect()->route('pharmacy.otp.verify', encrypt($pharmacy->id));
            } else {
                flash()->addError('Something went wrong. Please try again.');
                return redirect()->back()->withInput();
            }
        } else {
            flash()->addWarning('Email not found in our record');
            return redirect()->back()->withInput();
        }
    }

    public function otp($pharmacy_id)
    {
        if (Auth::guard('pharmacy')->check() && pharmacy()->status == 1) {
            return redirect()->route('pharmacy.dashboard');
        }
        return view('pharmacy.auth.verify', compact('pharmacy_id'));
    }

    public function verify(Request $request, $pharmacy_id): RedirectResponse
    {
        $pharmacy = Pharmacy::where('id', decrypt($pharmacy_id))->first();
        $otp = implode('', $request->otp);
        if ($pharmacy) {
            if ($pharmacy->otp == $otp) {
                $pharmacy->status = 1;
                $pharmacy->update();
                flash()->addSuccess('OTP verified successfully');
                return redirect()->route('pharmacy.reset.password', encrypt($pharmacy->id));
            } else {
                flash()->addSuccess('OTP didn\'t match. Please try again');
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('login');
    }

    public function resetPassword($pharmacy_id): View
    {
        return view('pharmacy.auth.reset', compact('pharmacy_id'));
    }

    public function resetPasswordStore(Request $request, $pharmacy_id): RedirectResponse
    {
        $pharmacy = pharmacy::where('id', decrypt($pharmacy_id))->first();
        $pharmacy->password = $request->password;
        $pharmacy->update();
        flash()->addSuccess('Password updated successfully');
        return redirect()->route('pharmacy.login');
    }
}
