<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URL')
    ],
    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'app_access_token' => env('FACEBOOK_CLIENT_ID') . '|' . env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT_URL')
    ],
    'sms_api' => [
        'url'     => env('SMS_API_URL', 'https://portal.adnsms.com/api/v1/secure/send-sms'),
        'key' => env('SMS_API_KEY', 'KEY-mrvshgmw3ungyoqxadguq5hil601g4j4'),
        'secret'      => env('SMS_API_SECRET', 'XYhKX@yQ0@jmy9Wg'),
        'sender_id'      => env('SMS_API_SENDER_ID'),
        'status'      => env('SMS_API_STATUS', '200'),
    ],
    'steadfast' => [
        'webhook_secret' => env('STEADFAST_WEBHOOK_SECRET'),
    ]

];
