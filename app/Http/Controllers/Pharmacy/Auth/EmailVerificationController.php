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
        $mail = $this->sendOtpMail($pharmacy);
        $message = 'The verification code has been successfully sent to your email';
        if (!$mail) {
            $message = 'Something went wrong. Please try again.';
        } else {
        }
        return response()->json(['success' => true, 'message' => $message]);
    }
    public function verify(EmailVerifyRequest $request): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $reqOtp = implode('', $request->otp);
        if ($pharmacy->otp == $reqOtp) {
            $pharmacy->is_verify = 1;
            $pharmacy->email_verified_at = Carbon::now();
            $pharmacy->save();
            flash()->addSuccess('Email verified successfully');
            return redirect()->route('pharmacy.dashboard');
        } else {
            flash()->addError('Invalid OTP');
            return redirect()->back();
        }
    }
}
