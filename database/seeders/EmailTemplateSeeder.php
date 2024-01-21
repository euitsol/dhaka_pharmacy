<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::create([
            'key' => 'password_reset',
            'name' => 'Password Reset',
            'variables'=>json_encode([['key'=>'username','meaning'=>'This is User Name'],['key'=>'code','meaning'=>'This is verification code'],['key'=>'sent_from','meaning'=>'This is sender name']]),
        ]);
        EmailTemplate::create([
            'key' => 'payment_success',
            'name' => 'Payment Successfull',
            'variables'=>json_encode([['key'=>'username','meaning'=>'This is User Name'],['key'=>'code','meaning'=>'This is verification code'],['key'=>'sent_from','meaning'=>'This is sender name']]),
        ]);
        EmailTemplate::create([
            'key' => 'payment_received',
            'name' => 'Payment Received',
            'variables'=>json_encode([['key'=>'username','meaning'=>'This is User Name'],['key'=>'code','meaning'=>'This is verification code'],['key'=>'sent_from','meaning'=>'This is sender name']]),
        ]);
        EmailTemplate::create([
            'key' => 'verify_email',
            'name' => 'Verify Email',
            'variables'=>json_encode([['key'=>'username','meaning'=>'This is User Name'],['key'=>'code','meaning'=>'This is verification code'],['key'=>'sent_from','meaning'=>'This is sender name']]),
        ]);
        EmailTemplate::create([
            'key' => 'payment_confirmed',
            'name' => 'Payment Confirmed',
            'variables'=>json_encode([['key'=>'username','meaning'=>'This is User Name'],['key'=>'code','meaning'=>'This is verification code'],['key'=>'sent_from','meaning'=>'This is sender name']]),
        ]);
        EmailTemplate::create([
            'key' => 'payment_rejected',
            'name' => 'Payment Rejected',
            'variables'=>json_encode([['key'=>'username','meaning'=>'This is User Name'],['key'=>'code','meaning'=>'This is verification code'],['key'=>'sent_from','meaning'=>'This is sender name']]),
        ]);
    }
}
