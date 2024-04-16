<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use App\Models\Rider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RiderProfileController extends Controller
{
    public function __construct()
    {
        return $this->middleware('rider');
    }

    public function profile(): View
    {
        $data['document'] = Documentation::where('module_key', 'rider_profile_documentation')->first();
        $data['rider'] = Rider::findOrFail(rider()->id);
        $data['operation_areas'] = OperationArea::activated()->latest()->get();
        $data['operation_sub_areas'] = OperationSubArea::activated()->latest()->get();
        return view('rider.profile.profile', $data);
    }

    public function update(Request $request)
    {

        $rider = Rider::findOrFail(rider()->id);
        $validator = $request->validate([
            'name' => 'required|min:4',
            'phone' => 'required|numeric|digits:11|unique:riders,phone,' . rider()->id,
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
            $fileName = rider()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'rider/' . rider()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($rider->cv)) {
                $this->fileDelete($rider->cv);
            }
            $rider->cv = $path;
        }

        
        if(empty($rider->oa_id)){
            $rider->oa_id = $request->oa_id;
        }
        if(empty($rider->osa_id)){
            $rider->osa_id = $request->osa_id;
        }
        $rider->name = $request->name;
        $rider->phone = $request->phone;
        $rider->age = $request->age;
        $rider->identification_type = $request->identification_type;
        $rider->identification_no = $request->identification_no;
        $rider->present_address = $request->present_address;
        $rider->gender = $request->gender;
        $rider->dob = $request->dob;
        $rider->father_name = $request->father_name;
        $rider->mother_name = $request->mother_name;
        $rider->permanent_address = $request->permanent_address;
        $rider->emergency_phone = $request->emergency_phone;
        $rider->update();

        if ($validator) {
            flash()->addSuccess('Profile updated successfully.');
        }
        return redirect()->back();
    }
    public function updatePassword(Request $request)
    {

        $rider = Rider::findOrFail(rider()->id);
        $validator = $request->validate([
            'old_password' => [
                'required',
                'min:4',
                function ($attribute, $value, $fail) {
                    // Check if the old_password matches the current password
                    if (!\Hash::check($value, rider()->password)) {
                        $fail("The $attribute doesn't match the current password.");
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
        ]);
        $rider->password = $request->password;
        $rider->update();

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
        $rider = Rider::findOrFail(rider()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = rider()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'rider/' . rider()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $rider->image = $path;
            $rider->save();
            return response()->json(['message' => 'Image uploaded successfully'], 200);
        }

        return response()->json(['message' => 'Image not uploaded'], 400);
    }
}
