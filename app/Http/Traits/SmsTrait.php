<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait SmsTrait
{
    function sms_send($mobile, $message)
    {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "ocd8ExRE1Nzet2xhsxXz";
        $senderid = "8809617612436";
        $number = $mobile;

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        // return $response;

        $get = (json_decode($response, true));

        Log::info($get);

        $result = $get['response_code'];

        if ($result == 202) {
            return true;
        } else {
            return false;
        }

        // elseif ($result == '1002') {
        //     return "Sender Id/Masking Not Found";
        // } elseif ($result == '1003') {
        //     return "API Not Found";
        // } elseif ($result == '1004') {
        //     return "SPAM Detected";
        // } elseif ($result == '1005' || $result == '1006') {
        //     return "Internal Error";
        // } elseif ($result == '1006') {
        //     return "Balance Validity Not Available";
        // } elseif ($result == '1007') {
        //     return "Balance Insufficient";
        // } elseif ($result == '1008') {
        //     return "Message is empty";
        // } elseif ($result == '1009') {
        //     return "Message Type Not Set (text/unicode)";
        // } elseif ($result == '1010') {
        //     return "Invalid User & Password";
        // } elseif ($result == '1011') {
        //     return "Invalid User Id";
        // } elseif ($result == '1012') {
        //     return "Masking SMS must be sent in Bengali";
        // } elseif ($result == '1013') {
        //     return "Sender Id has not found Gateway by api key";
        // } elseif ($result == '1014') {
        //     return "Sender Type Name not found using this sender by api key";
        // } elseif ($result == '1015') {
        //     return "Sender Id has not found Any Valid Gateway by api key";
        // } elseif ($result == '1016') {
        //     return "Sender Type Name Active Price Info not found by this sender id";
        // } elseif ($result == '1017') {
        //     return "Sender Type Name Price Info not found by this sender id";
        // } elseif ($result == '1018') {
        //     return "The Owner of this (username) Account is disabled";
        // } elseif ($result == '1019') {
        //     return "The (sender type name) Price of this (username) Account is disabled";
        // } elseif ($result == '1020') {
        //     return "The parent of this account is not found.";
        // } elseif ($result == '1021') {
        //     return "The parent active (sender type name) price of this account is not found.";
        // }

        // return "Something went wrong :(";
    }
}
