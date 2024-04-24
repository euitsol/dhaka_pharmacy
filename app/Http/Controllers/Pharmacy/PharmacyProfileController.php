<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


class PharmacyProfileController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('pharmacy');
    }

    public function profile(): View
    {
        $data['document'] = Documentation::where('module_key', 'pharmacy_profile_documentation')->first();
        $data['pharmacy'] = Pharmacy::findOrFail(pharmacy()->id);
        $data['operation_areas'] = OperationArea::activated()->latest()->get();
        $data['operation_sub_areas'] = OperationSubArea::activated()->latest()->get();
        return view('pharmacy.profile.profile', $data);
    }

    public function update(Request $request)
    {

        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $validator = $request->validate([
            'name' => 'required|min:4',
            'phone' => 'required|numeric|digits:11|unique:pharmacies,phone,' . pharmacy()->id,
            'email' => 'required|email|unique:pharmacies,email,' . pharmacy()->id,
            'age' => 'nullable|numeric|digits:2',
            'identification_type' => 'nullable|in:NID,DOB,Passport',
            'identification_no' => 'nullable|numeric',
            'present_address' => 'nullable',
            'cv' => 'nullable|file|mimes:pdf',

            'gender' => 'nullable|in:Male,Female,Others',
            'dob' => 'nullable|date|before:today',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
            'permanent_address' => 'nullable',
            'emergency_phone' => 'nullable|numeric|digits:11',
            'oa_id' => 'nullable|exists:operation_areas,id',
            'osa_id' => 'nullable|exists:operation_sub_areas,id',
        ]);
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = pharmacy()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'pharmacy/' . pharmacy()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($pharmacy->cv)) {
                $this->fileDelete($pharmacy->cv);
            }
            $pharmacy->cv = $path;
        }

        
        if(empty($pharmacy->oa_id)){
            $pharmacy->oa_id = $request->oa_id;
        }
        if(empty($pharmacy->osa_id)){
            $pharmacy->osa_id = $request->osa_id;
        }
        $pharmacy->name = $request->name;
        $pharmacy->phone = $request->phone;
        $pharmacy->email = $request->email;
        $pharmacy->age = $request->age;
        $pharmacy->identification_type = $request->identification_type;
        $pharmacy->identification_no = $request->identification_no;
        $pharmacy->present_address = $request->present_address;
        $pharmacy->gender = $request->gender;
        $pharmacy->dob = $request->dob;
        $pharmacy->father_name = $request->father_name;
        $pharmacy->mother_name = $request->mother_name;
        $pharmacy->permanent_address = $request->permanent_address;
        $pharmacy->emergency_phone = $request->emergency_phone;
        $pharmacy->update();

        if ($validator) {
            flash()->addSuccess('Profile updated successfully.');
        }
        return redirect()->back();
    }
    public function updatePassword(Request $request)
    {

        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $validator = $request->validate([
            'old_password' => [
                'required',
                'min:4',
                function ($attribute, $value, $fail) {
                    // Check if the old_password matches the current password
                    if (!\Hash::check($value, pharmacy()->password)) {
                        $fail("The $attribute doesn't match the current password.");
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
        ]);
        $pharmacy->password = $request->password;
        $pharmacy->update();

        if ($validator) {
            flash()->addSuccess('Password updated successfully.');
        }
        return redirect()->back();
    }
    public function updateImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = pharmacy()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'pharmacy/' . pharmacy()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $pharmacy->image = $path;
            $pharmacy->save();
            return response()->json(['message' => 'Image uploaded successfully'], 200);
        }

        return response()->json(['message' => 'Image not uploaded'], 400);
    }

    public function get_osa($oa_id){
        $operation_area = OperationArea::with('operation_sub_areas')->findOrFail($oa_id);

        $data['operation_sub_areas'] = $operation_area->operation_sub_areas->filter(function ($sub_area) {
            return $sub_area->status == 1;
        });
        return response()->json($data);

    }

}
