<?php

namespace App\Http\Controllers\Admin\RiderManagement;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\KycSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class RiderKycSettingsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function list(): View
    {
        $data['kycs'] = KycSetting::where('type', 'rider')->orderBy('status', 'desc')->latest()->get()->groupBy('status');
        return view('admin.rider_management.kyc_settings.list', $data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'rider_kyc_settings')->first();
        return view('admin.rider_management.kyc_settings.create', $data);
    }
    public function store(Request $request): RedirectResponse
    {
        if (is_null($request->formdata)) {
            flash()->addWarning('Please add KYC requirements.');
            return redirect()->back();
        }
        $data = $this->prepareKycData($request);
        if (isset($request->status) &&  $request->status == 1) {
            KycSetting::activated()->where('type', 'rider')->update(['status' => 0, 'updated_by' => admin()->id]);
        }
        KycSetting::create(
            [
                'type' => 'rider',
                'status' => $request->status ?? 0,
                'form_data' => json_encode($data, JSON_FORCE_OBJECT),
                'created_by' => admin()->id,
            ]
        );
        flash()->addSuccess('New KYC created successfully.');
        return redirect()->route('rm.rider_kyc.settings.r_kyc_list');
    }
    public function status($id): RedirectResponse
    {
        $kyc = KycSetting::findOrFail(decrypt($id));
        KycSetting::activated()->where('type', 'rider')->where('status', 1)->update(['status' => 0, 'updated_by' => admin()->id]);
        $kyc->update(['status' => 1, 'updated_by' => admin()->id]);

        flash()->addSuccess('KYC activated successfully.');
        return redirect()->route('rm.rider_kyc.settings.r_kyc_list');
    }
    public function details($id): View
    {
        $data['kyc'] = KycSetting::findOrFail(decrypt($id));
        return view('admin.rider_management.kyc_settings.details', $data);
    }

    private function prepareKycData(Request $request): array
    {
        $data = [];
        if (!is_null($request->formdata)) {
            foreach ($request->formdata as $key => $formdata) {
                if (isset($formdata['field_name'])) {
                    $data[$key]['field_key'] = Str::slug($formdata['field_name']);
                    $data[$key]['field_name'] = $formdata['field_name'];
                    $data[$key]['type'] = $formdata['type'];
                    $data[$key]['required'] = $formdata['required'];

                    if ($formdata['type'] == 'option') {
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
                $optionsArray[strval($key)] = $value;
            }
        }
        return $optionsArray;
    }



















    // public function kycSettings(): View
    // {
    //     $data['kyc_setting'] = KycSetting::where('type', 'rider')->first();
    //     $data['document'] = Documentation::where('module_key', 'rider_kyc_settings')->first();
    //     return view('admin.rider_management.kyc_settings.create', $data);
    // }

    // public function kycSettingsUpdate(Request $request): RedirectResponse
    // {
    //     $data = $this->prepareKycData($request);

    //     $status = $request->status ?? 0;
    //     KycSetting::updateOrCreate(
    //         ['type' => 'rider'],
    //         [
    //             'status' => $status,
    //             'form_data' => json_encode($data),
    //         ]
    //     );
    //     flash()->addSuccess('KYC settings updated successfully.');
    //     return redirect()->route('rm.rider_kyc.rider_kyc_settings');
    // }

    // private function prepareKycData(Request $request): array
    // {
    //     $data = [];
    //     if (!is_null($request->formdata)) {
    //         foreach ($request->formdata as $key => $formdata) {
    //             if (isset($formdata['field_name'])) {
    //                 $data[$key]['field_key'] = Str::slug($formdata['field_name']);
    //                 $data[$key]['field_name'] = $formdata['field_name'];
    //                 $data[$key]['type'] = $formdata['type'];
    //                 $data[$key]['required'] = $formdata['required'];

    //                 if ($formdata['type'] == 'option') {
    //                     $data[$key]['option_data']  = $this->convertOptionDataToArray($formdata['option_data']) ?? [];
    //                 }
    //             }
    //         }
    //     }


    //     return $data;
    // }


    // private function convertOptionDataToArray($optionData): array
    // {
    //     $optionsArray = [];
    //     $options = explode(';', $optionData);

    //     foreach ($options as $option) {
    //         $parts = explode('=', $option);
    //         if (count($parts) === 2) {
    //             $key = trim($parts[0]);
    //             $value = trim($parts[1]);
    //             $optionsArray[$key] = $value;
    //         }
    //     }

    //     return $optionsArray;
    // }
}
