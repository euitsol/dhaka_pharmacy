<?php

namespace App\Http\Controllers\Admin\PharmacyManagement;

use App\Http\Controllers\Controller;
use App\Models\KycSetting;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PharmacyKycSettingsController extends Controller
{
     //

     public function __construct() {
        return $this->middleware('admin');
    }


    public function kycSettings():View
    {
        $s['kyc_setting'] = KycSetting::where('type','pharmacy')->first();
        return view('admin.pharmacy_management.kyc_settings.create',$s);
    }

    public function kycSettingsUpdate(Request $request):RedirectResponse
    {
        $data = $this->prepareKycData($request);

        // Find an existing record or create a new one based on the status field
        KycSetting::updateOrCreate(
            ['type' => 'pharmacy'],
            [
                'status' => $request->status,
                'form_data' => json_encode($data),
            ]
        );
    
        return redirect()->route('pm.pharmacy_kyc.pharmacy_kyc_settings')->withStatus(__('KYC settings updated successfully.'));
    }
    
    private function prepareKycData(Request $request):array
    {
        $data = [];
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
    
        return $data;
    } 


    private function convertOptionDataToArray($optionData):array
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
