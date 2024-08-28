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
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'rider_kyc_settings')->first();
        $data['kycs'] = KycSetting::where('type', 'rider')->latest()->get();
        $data['kyc_setting'] = $data['kycs']->where('status', 1)->first();
        return view('admin.rider_management.kyc_settings.create', $data);
    }
    public function store(Request $request): RedirectResponse
    {
        if (is_null($request->formdata)) {
            flash()->addWarning('Please add KYC requirements.');
            return redirect()->back();
        }
        $data = $this->prepareKycData($request);
        KycSetting::activated()->where('type', 'rider')->update(['status' => 0, 'updated_by' => admin()->id]);
        KycSetting::create(
            [
                'type' => 'rider',
                'status' => 1,
                'form_data' => json_encode($data, JSON_FORCE_OBJECT),
                'created_by' => admin()->id,
            ]
        );
        flash()->addSuccess('New KYC created successfully.');
        return redirect()->route('rm.rider_kyc.settings.r_kyc_create');
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
}