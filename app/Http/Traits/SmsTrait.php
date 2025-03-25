<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait SmsTrait
{
    public function send_otp_sms($mobile, $message)
    {
        $url = config('services.sms_api.url');
        $api_key = config('services.sms_api.key');
        $api_secret = config('services.sms_api.secret');
        $data = [
            'api_key' => $api_key,
            'api_secret' => $api_secret,
            'request_type' => 'OTP',
            'message_type' => 'TEXT', // or 'UNICODE' if needed
            'mobile' => $mobile,
            'message_body' => $message,
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Handle HTTP errors
        if ($http_code !== 200) {
            return 'API Request failed with HTTP code: ' . $http_code . ' | Response: ' . $response;
            // return 'Something went wrong, please try again.';
        }

        // Decode the API response
        $result = json_decode($response, true);

        // Check API response
        if ($result['api_response_code'] === 200) {
            return true;
        } else {
            $invalid_numbers = $result['invalid_numbers'] ?? [];
            $invalid_numbers_message = !empty($invalid_numbers) ? ' Invalid numbers: ' . implode(', ', $invalid_numbers) : '';

            return 'SMS sending failed with message: ' . ($result['api_response_message'] ?? 'Unknown error') . $invalid_numbers_message;
        }
    }

    public function send_single_sms($mobile, $message)
    {
        $url = config('services.sms_api.url');
        $api_key = config('services.sms_api.key');
        $api_secret = config('services.sms_api.secret');
        $data = [
            'api_key' => $api_key,
            'api_secret' => $api_secret,
            'request_type' => 'SINGLE_SMS',
            'message_type' => 'TEXT', // or 'UNICODE' if needed
            'mobile' => $mobile,
            'message_body' => $message,
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Handle HTTP errors
        if ($http_code !== 200) {
            return 'API Request failed with HTTP code: ' . $http_code . ' | Response: ' . $response;
            // return 'Something went wrong, please try again.';
        }

        // Decode the API response
        $result = json_decode($response, true);

        // Check API response
        if ($result['api_response_code'] === 200) {
            return true;
        } else {
            $invalid_numbers = $result['invalid_numbers'] ?? [];
            $invalid_numbers_message = !empty($invalid_numbers) ? ' Invalid numbers: ' . implode(', ', $invalid_numbers) : '';

            return 'SMS sending failed with message: ' . ($result['api_response_message'] ?? 'Unknown error') . $invalid_numbers_message;
        }
    }
}
