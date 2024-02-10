<?php

namespace App\Http\Controllers\Admin\LAM_Management;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\KycSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class LamKycSettingsController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }


    public function kycSettings():View
    {
        $data['kyc_setting'] = KycSetting::where('type','lam')->first();
        $data['document'] = Documentation::where('module_key','lam_kyc_settings')->first();
        return view('admin.lam_management.kyc_settings.create',$data);
    }

    public function kycSettingsUpdate(Request $request): RedirectResponse
    {
        $data = $this->prepareKycData($request);

        $status = $request->status ?? 0;
        KycSetting::updateOrCreate(
            ['type' => 'lam'],
            [
                'status' => $status,
                'form_data' => json_encode($data),
            ]
        );
        flash()->addSuccess('KYC settings updated successfully.');
        return redirect()->route('lam_management.lam_kyc.local_area_manager_kyc_settings');
    }
    
    private function prepareKycData(Request $request): array
    {
        $data = [];
        if(!is_null($request->formdata)){
            foreach($request->formdata as $key => $formdata) {
                if(isset($formdata['field_name'])) {
                    $data[$key]['field_key'] = Str::slug($formdata['field_name']);
                    $data[$key]['field_name'] = $formdata['field_name'];
                    $data[$key]['type'] = $formdata['type'];
                    $data[$key]['required'] = $formdata['required'];
        
                    if($formdata['type'] == 'option') {
                        $data[$key]['option_data']  = $this->convertOptionDataToArray($formdata['option_data']) ?? [];
                    }
                }
            }
        }
        
    
        return $data;
    } 


    private function convertOptionDataToArray($optionData): array
    {
        $optionsArray = [];
        $options = explode(';', $optionData);

        foreach ($options as $option) {
            $parts = explode('=', $option);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                $optionsArray[$key] = $value;
            }
        }

        return $optionsArray;
    }
}
