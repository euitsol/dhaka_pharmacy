<?php

namespace App\Http\Controllers\Admin\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\PaymentGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class SettingController extends Controller
{


    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function ssl_commerz(): View
    {
        $data['pg_settings'] = PaymentGateway::pluck('value', 'key')->all();
        $data['document'] = Documentation::where('module_key', 'pg_settings')->first();
        return view('admin.payment_gateway.settings.ssl_commerz', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->except('_token');


        try {
            $envPath = base_path('.env');
            $env = file($envPath);

            foreach ($data as $key => $value) {
                $setting = PaymentGateway::updateOrCreate(['key' => $key], ['value' => $value]);
                if (!empty($setting->env_key)) {
                    $env = $this->set($setting->env_key, '"' . $value . '"', $env);
                }
            }

            $fp = fopen($envPath, 'w');
            fwrite($fp, implode($env));
            fclose($fp);
            flash()->addSuccess('Payment gateway settings updated successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            flash()->addError('Something is wrong.');
            return redirect()->back();
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
}
