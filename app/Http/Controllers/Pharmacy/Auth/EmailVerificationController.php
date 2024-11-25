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

    private $otpResentTime = 1;
    public function __construct()
    {
        return $this->middleware('pharmacy');
    }

    private function check_throttle($pharmacy)
    {
        if ($pharmacy->email_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($pharmacy->email_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }

    public function send_otp()
    {
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        if ($this->check_throttle($pharmacy)) {
            $data['success'] = false;
            $data['message'] = $this->check_throttle($pharmacy);
        } else {
            $pharmacy->otp = otp();
            $pharmacy->email_verified_at = Carbon::now();
            $pharmacy->save();
            $mail = $this->sendOtpMail($pharmacy);
            $data['success'] = true;
            $data['message'] = 'The verification code has been successfully sent to your email';
            if (!$mail) {
                $data['success'] = false;
                $data['message'] = 'Something went wrong. Please try again.';
            }
        }
        return response()->json($data);
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