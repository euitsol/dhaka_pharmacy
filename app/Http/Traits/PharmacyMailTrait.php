<?php

namespace App\Http\Traits;

use App\Mail\OtpVerifyMail;
use App\Mail\PharmacyMail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;

trait PharmacyMailTrait
{

    public function sendOtpMail($pharmacy)
    {
        $templateObj = EmailTemplate::where('key', 'verify_email')->first();
        $otp =  $pharmacy->otp;
        //replacing the variables
        $subject = $templateObj->subject;
        $placeholders = [
            '{username}' => $pharmacy->name,
            '{code}' => $otp,
            '{sent_from}' => config('app.name'),
        ];

        // Replace placeholders with actual values
        $message = str_replace(array_keys($placeholders), array_values($placeholders), $templateObj->template);
        $mailData = [
            'subject' => $subject,
            'message' => $message,
        ];
        if (!empty($pharmacy)) {
            Mail::to($pharmacy->email)->send(new OtpVerifyMail($mailData));
        } else {
            return false;
        }
    }
}