<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\KycSetting;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserKycSettingsController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }


    public function kycSettings():View
    {
        $data['kyc_setting'] = KycSetting::where('type','user')->first();
        $data['document'] = Documentation::where('module_key','user_kyc_settings')->first();
        return view('admin.user_management.kyc_settings.create',$data);
    }

    public function kycSettingsUpdate(Request $request): RedirectResponse
    {
        $data = $this->prepareKycData($request);

        $status = $request->status ?? 1;
        KycSetting::updateOrCreate(
            ['type' => 'user'],
            [
                'status' => $status,
                'form_data' => json_encode($data),
            ]
        );
    
        return redirect()->route('um.user_kyc.user_kyc_settings')->withStatus(__('KYC settings updated successfully.'));
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
