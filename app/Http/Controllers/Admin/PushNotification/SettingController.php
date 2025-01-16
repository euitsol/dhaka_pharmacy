<?php

namespace App\Http\Controllers\Admin\PushNotification;

use App\Http\Controllers\Controller;
use App\Http\Requests\PushNotificationTemplateRequest;
use App\Models\Documentation;
use App\Models\NotificationSetting;
use App\Models\NotificationTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;


class SettingController extends Controller
{

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['notification_templates'] = NotificationTemplate::latest()->get();
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
            Log::error($e);
            flash()->addError('Something is wrong.');
            return redirect()->route('push.ns');
        }
    }
    public function edit_nt($id){
        $data['notification_template'] =  NotificationTemplate::findOrFail($id);
        return response()->json($data);
    }

    public function update_nt(PushNotificationTemplateRequest $req, $id) {
        try {
            $data = NotificationTemplate::findOrFail($id);
            $data->message = $req->message;
            $data->update();
            flash()->addSuccess('Notification template updated successfully.');
            return response()->json(['message' => 'Notification template updated successfully.']);
        } catch (\Exception $e) {
            flash()->addError('Somethings is wrong.');
            return response()->json(['message' => 'Somethings is wrong.'], 500);
        }
    }
    public function status_nt($id){
        $nt = NotificationTemplate::findOrFail($id);
        $this->statusChange($nt);
        $data['message'] = "$nt->name status updated successfully.";
        return response()->json($data);
    }

    private function set($key, $value, $env)
    {
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            if ($entry[0] == $key) {
                $env[$env_key] = $key . "=" . $value . "\n";
            } else {
                $env[$env_key] = $env_value;
            }
        }
        return $env;
    }
}
