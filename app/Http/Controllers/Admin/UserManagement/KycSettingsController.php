<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\KycSetting;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class KycSettingsController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }


    public function kycSettings(){
        $s['kyc_setting'] = KycSetting::where('type','user')->first();
        return view('admin.user_management.kyc_settings.create',$s);
    }

    public function kycSettingsUpdate(Request $request){
        $data = $this->prepareKycData($request);
    
        // Find an existing record or create a new one based on the status field
        KycSetting::updateOrCreate(
            ['type' => 'user'],
            [
                'status' => $request->status,
                'form_data' => json_encode($data),
            ]
        );
    
        return redirect()->route('um.user_kyc.kyc_settings_view')->withStatus(__('KYC settings updated successfully.'));
    }
    
    private function prepareKycData(Request $request) {
        $kyc_setting = KycSetting::where('type','user')->first();
        $old_data = [];
        if($kyc_setting){
            $old_data = $kyc_setting->form_data;
        }
        

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

}
