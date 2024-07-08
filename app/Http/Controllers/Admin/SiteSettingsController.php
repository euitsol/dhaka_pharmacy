<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplateRequest;
use App\Http\Requests\PointSettingRequest;
use App\Http\Requests\SmsSettingUpdateRequest;
use App\Models\Documentation;
use App\Models\EmailTemplate;
use App\Models\PointHistory;
use App\Models\PointSetting;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $data['email_templates'] = EmailTemplate::where('deleted_at', null)->latest()->get();
        $data['SiteSettings'] = SiteSetting::pluck('value', 'key')->all();
        $data['point_settings'] = PointSetting::pluck('value', 'key')->all();
        $data['point_histories'] = PointHistory::latest()->get();
        $data['documents'] = Documentation::where('module_key', 'general_settings')
            ->orWhere('module_key', 'email_settings')
            ->orWhere('module_key', 'database_settings')
            ->orWhere('module_key', 'sms_settings')
            ->orWhere('module_key', 'notification_settings')
            ->orWhere('module_key', 'email_templates')
            ->orWhere('module_key', 'point_settings')
            ->get();
        $data['availableTimezones'] = availableTimezones();
        return view('admin.site_settings.index', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->except('_token');

        try {
            $envPath = base_path('.env');
            $env = file($envPath);

            foreach ($data as $key => $value) {
                if ($key == 'site_logo' || $key == 'site_favicon') {
                    if ($request->hasFile('site_logo')) {
                        $image = $request->file('site_logo');
                        $path = $image->store('site-settings', 'public');
                        $key = 'site_logo';
                        $value = $path;
                        $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
                    }
                    if ($request->hasFile('site_favicon')) {
                        $image = $request->file('site_favicon');
                        $path = $image->store('site-settings', 'public');
                        $key = 'site_favicon';
                        $value = $path;
                        $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
                    }
                }
                $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);


                if (!empty($siteSetting->env_key)) {
                    $env = $this->set($siteSetting->env_key, '"' . $value . '"', $env);
                }
            }

            $fp = fopen($envPath, 'w');
            fwrite($fp, implode($env));
            fclose($fp);
            flash()->addSuccess('Settings added successfully.');
            return redirect()->route('settings.site_settings');
        } catch (\Exception $e) {
            flash()->addError('Something is wrong.');
            return redirect()->route('settings.site_settings');
        }
    }
    public function sms_store(SmsSettingUpdateRequest $request): RedirectResponse
    {
        $data = $request->except('_token');

        try {
            $envPath = base_path('.env');
            $env = file($envPath);
            foreach ($data as $key => $value) {
                $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
                if (!empty($siteSetting->env_key)) {
                    $env = $this->set($siteSetting->env_key, '"' . $value . '"', $env);
                }
            }

            $fp = fopen($envPath, 'w');
            fwrite($fp, implode($env));
            fclose($fp);
            flash()->addSuccess('SMS Settings updated successfully.');
            return redirect()->route('settings.site_settings');
        } catch (\Exception $e) {
            flash()->addError('Something is wrong.');
            return redirect()->route('settings.site_settings');
        }
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

    public function notification(Request $request): RedirectResponse
    {
        $keys = ['email_verification', 'sms_verification', 'user_registration', 'user_kyc'];

        foreach ($keys as $key) {
            if (isset($request->$key)) {
                SiteSetting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
            } else {
                SiteSetting::updateOrCreate(['key' => $key], ['value' => 0]);
            }
        }
        flash()->addSuccess('Settings added successfully.');
        return redirect()->route('settings.site_settings');
    }

    public function et_edit($id)
    {
        $data['email_template'] =  EmailTemplate::findOrFail($id);
        return response()->json($data);
    }

    public function et_update(EmailTemplateRequest $req, $id)
    {
        try {
            $data = EmailTemplate::findOrFail($id);
            $data->subject = $req->subject;
            $data->template = $req->template;
            $data->update();
            flash()->addSuccess('Settings added successfully.');
            return response()->json(['message' => 'Email template updated successfully']);
        } catch (\Exception $e) {
            flash()->addError('Somethings is wrong.');
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
    public function ps_update(PointSettingRequest $request)
    {
        $data = $request->except('_token');
        try {
            foreach ($data as $key => $value) {
                PointSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            $ph = PointHistory::activated()->where('eq_amount', $request->equivalent_amount)->first();
            if (!$ph) {
                PointHistory::activated()->update(['status' => 0, 'updated_by' => admin()->id]);
                PointHistory::create(['eq_amount' => $request->equivalent_amount, 'created_by' => admin()->id]);
            }
            flash()->addSuccess('Point settings added successfully.');
            return redirect()->route('settings.site_settings');
        } catch (\Exception $e) {
            flash()->addError('Something is wrong.');
            return redirect()->route('settings.site_settings');
        }
    }
}