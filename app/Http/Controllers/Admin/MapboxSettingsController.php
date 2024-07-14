<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapboxSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MapboxSettingsController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->except('_token');

        try {
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
        } catch (\Exception $e) {
            flash()->addError('Something is wrong.');
            return redirect()->route('settings.site_settings');
        }
    }
}
