<?php
namespace App\Http\Controllers;

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
        $s['SiteSettings'] = SiteSetting::pluck('value', 'key')->all();
        $s['availableTimezones'] = availableTimezones();
        return view('site_settings.index', $s);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->except('_token');

        try {
            $envPath = base_path('.env');
            $env = file($envPath);
            dd($data);

            foreach ($data as $key => $value) {
                if($key == 'site_logo' || $key == 'site_favicon'){
                    if ($request->hasFile('site_logo')) {
                        $image = $request->file('site_logo');
                        $path = $image->store('site-settings', 'public');
                        $key = 'site_logo';
                        $value = $path;
                        $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
                    }
                    if($request->hasFile('site_favicon')){
                        $image = $request->file('site_favicon');
                        $path = $image->store('site-settings', 'public');
                        $key = 'site_favicon';
                        $value = $path;
                        $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
                    }
                }
                    $siteSetting = SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
               

                if (!empty($siteSetting->env_key)) {
                    $env = $this->set($siteSetting->env_key, '"'.$value.'"', $env);
                }
            }

            $fp = fopen($envPath, 'w');
            fwrite($fp, implode($env));
            fclose($fp);

            return redirect()->back()->withStatus(__('Settings added successfully.'));
        } catch (\Exception $e) {
            return redirect()->back()->withStatus($e->getMessage());
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
        $keys = ['email_verification','sms_verification','user_registration','user_kyc'];
        
        foreach($keys as $key){
            if(isset($request->$key)){
                SiteSetting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
            }else{
                SiteSetting::updateOrCreate(['key' => $key], ['value' => 0]);
            }
        }

        return redirect()->back()->withStatus(__('Settings added successfully.'));
    }
}
