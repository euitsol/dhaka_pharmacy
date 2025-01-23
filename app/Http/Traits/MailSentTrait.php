<?php

namespace App\Http\Traits;

use App\Mail\OtpVerifyMail;
use App\Mail\PharmacyMail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;

trait MailSentTrait
{

    public function sendOtpMail($model)
    {
        $templateObj = EmailTemplate::where('key', 'verify_email')->first();
        $otp =  $model->otp;
        //replacing the variables
        $subject = $templateObj->subject;
        $placeholders = [
            '{username}' => $model->name,
            '{code}' => $otp,
            '{sent_from}' => config('app.name'),
        ];

        // Replace placeholders with actual values
        $message = str_replace(array_keys($placeholders), array_values($placeholders), $templateObj->template);
        $mailData = [
            'subject' => $subject,
            'message' => $message,
        ];
        if (!empty($model)) {
            Mail::to($model->email)->send(new OtpVerifyMail($mailData));
            return true;
        } else {
            return false;
        }
    }
}
