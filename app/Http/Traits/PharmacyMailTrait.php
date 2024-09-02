<?php

namespace App\Http\Traits;

use App\Mail\OtpVerifyMail;
use App\Mail\PharmacyMail;
use Illuminate\Support\Facades\Mail;

trait PharmacyMailTrait
{

    public function sendOtpMail($to, $subject, $message)
    {
        Mail::to($to)->send(new OtpVerifyMail([
            'subject' => $subject,
            'message' => $message,
        ]));
    }
}
