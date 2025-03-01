<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController;
use App\Models\MapboxSetting;
use App\Models\PaymentGateway;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ApiInfoShareController extends BaseController
{
    public function secureApiInfo(Request $request): JsonResponse
    {
        $type = $request->type;
        $infos = [];
        switch ($type) {
            case 'ssl':
                $infos = PaymentGateway::whereIn('key', ['store_id', 'store_password', 'mode'])->pluck('value', 'key')->toArray();
                $infos['api_domain'] = config('sslcommerz.apiDomain');
                $infos['ipn_url'] = url(config('sslcommerz.ipn_url'));
                break;
            case 'mapbox':
                $infos = MapboxSetting::whereIn('key', ['mapbox_token', 'mapbox_style_id', 'per_km_delivery_charge', 'min_delivery_charge', 'miscellaneous_charge', 'pharmacy_radious', 'center_location_lng', 'center_location_lat'])->pluck('value', 'key')->toArray();
                break;
        }

        return sendResponse(true, 'Third party api Info retrived successfully', $infos);
    }

    public function socialApiInfo(Request $request): JsonResponse
    {
        $type = $request->type;
        $infos = [];
        switch ($type) {
            case 'facebook':
                $infos = SiteSetting::whereIn('key', ['fb_client_id', 'fb_client_secret', 'fb_redirect_url'])->pluck('value', 'key')->toArray();
                break;
            case 'google':
                $infos = SiteSetting::whereIn('key', ['google_client_id', 'google_client_secret', 'google_redirect_url'])->pluck('value', 'key')->toArray();
                break;
        }

        return sendResponse(true, 'Social login api Info retrived successfully', $infos);
    }

    public function generalApiInfo(): JsonResponse
    {

        $data = [
            'mobile_app_environment' => SiteSetting::getValue('mobile_app_environment'),
            'maintenance_mode' => SiteSetting::getValue('maintenance_mode'),
            'maintenance_message' => SiteSetting::getValue('maintenance_message'),
            'play_store_url' => SiteSetting::getValue('mobile_app_play_store_url'),
            'ios_store_url' => SiteSetting::getValue('mobile_app_ios_store_url'),
            'latest_android_version' => SiteSetting::getValue('android_app_version'),
            'latest_ios_version' => SiteSetting::getValue('ios_app_version'),
            'force_update' => SiteSetting::getValue('mobile_app_force_update')
        ];
        return sendResponse(true, 'General API Info retrived successfully', $data);
    }
}
