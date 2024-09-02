<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerifyRequest;
use App\Http\Traits\PharmacyMailTrait;
use App\Models\Pharmacy;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class EmailVerificationController extends Controller
{
    use PharmacyMailTrait;
    public function __construct()
    {
        return $this->middleware('pharmacy');
    }

    public function send_otp()
    {
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $pharmacy->otp = otp();
        $pharmacy->save();
        $subject = 'Email verification code';
        $message = 'Your email verification code is ' . $pharmacy->otp;
        $this->sendOtpMail($pharmacy->email, $subject, $message);
        flash()->addSuccess('The verification code has been successfully sent to your email');
        return redirect()->route('pharmacy.email.verify');
    }

    public function index(): View
    {
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        return view('pharmacy.auth.email_verify', compact('pharmacy'));
    }

    public function verify(EmailVerifyRequest $request): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        if ($pharmacy->otp == $request->otp) {
            $pharmacy->is_verify = 1;
            $pharmacy->email_verified_at = Carbon::now();
            $pharmacy->save();
            flash()->addSuccess('Email verified successfully');
            return redirect()->route('pharmacy.dashboard');
        } else {
            flash()->addError('Invalid OTP');
            return redirect()->route('pharmacy.email.verify');
        }
    }
}
