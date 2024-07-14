<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MapboxSettingRequest;
use App\Models\MapboxSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MapboxSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function store(MapboxSettingRequest $request): RedirectResponse
    {
        $data = $request->except('_token');

        // try {
            $envPath = base_path('.env');
            $env = file($envPath);

            foreach ($data as $key => $value) {
                $mbx_settings = MapboxSetting::updateOrCreate(['key' => $key], ['value' => $value]);


                if (!empty($mbx_settings->env_key)) {
                    $env = $this->set($mbx_settings->env_key, '"' . $value . '"', $env);
                }
            }

            $fp = fopen($envPath, 'w');
            fwrite($fp, implode($env));
            fclose($fp);
            flash()->addSuccess('Mapbox settings updated successfully.');
            return redirect()->route('settings.site_settings');
        // } catch (\Exception $e) {
        //     flash()->addError('Something is wrong.');
        //     return redirect()->route('settings.site_settings');
        // }
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
