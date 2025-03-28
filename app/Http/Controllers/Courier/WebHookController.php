<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


class WebHookController extends Controller
{
    public function handler(Request $request)
    {
        Log::info('Response from Steadfast WebHook: ' . json_encode($request->all(), JSON_PRETTY_PRINT));

        // Retrieve the notification type from the request payload
        $notificationType = $request->input('notification_type');

        // Ensure the notification type is provided
        if (!$notificationType) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing notification type.'
            ], 400);
        }

        // Define validation rules based on the notification type
        switch ($notificationType) {
            case 'delivery_status':
                $rules = [
                    'notification_type' => 'required|in:delivery_status',
                    'consignment_id' => 'required',
                    'invoice' => 'required|string',
                    'cod_amount' => 'nullable|numeric',
                    'status' => 'required|in:pending,delivered,partial_delivered,cancelled,unknown',
                    'delivery_charge' => 'nullable|numeric',
                    'tracking_message' => 'nullable|string',
                ];
                break;

            case 'tracking_update':
                $rules = [
                    'notification_type' => 'required|in:tracking_update',
                    'consignment_id' => 'required|integer',
                    'invoice' => 'required|string',
                    'tracking_message' => 'nullable|string',
                ];
                break;

            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unsupported notification type.'
                ], 400);
        }

        // Validate the incoming data against the defined rules
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }
}
