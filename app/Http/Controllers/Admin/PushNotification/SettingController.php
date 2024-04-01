<?php

namespace App\Http\Controllers\Admin\PushNotification;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\NotificationSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class SettingController extends Controller
{

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['notification_settings'] = NotificationSetting::pluck('value', 'key')->all();
        $data['document'] = Documentation::where('module_key','push_notification')->first();
        return view('admin.pusher_notification.index', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->except('_token');

        try {
            $envPath = base_path('.env');
            $env = file($envPath);
            foreach ($data as $key => $value) {
                $notification_setting = NotificationSetting::updateOrCreate(['key' => $key], ['value' => $value]);
                if (!empty($notification_setting->env_key)) {
                    $env = $this->set($notification_setting->env_key, '"'.$value.'"', $env);
                }
            }

            $fp = fopen($envPath, 'w');
            fwrite($fp, implode($env));
            fclose($fp);
            flash()->addSuccess('Notification setting updated successfully.');
            return redirect()->route('push.ns');
        } catch (\Exception $e) {
            flash()->addError('Something is wrong.');
            return redirect()->route('push.ns');
        }
    }
}
