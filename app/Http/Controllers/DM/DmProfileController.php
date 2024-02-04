<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use App\Models\DistrictManager;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


class DmProfileController extends Controller
{

    public function __construct() {
        return $this->middleware('dm');
    }

    public function profile():View
    {
        $data['document'] = Documentation::where('module_key', 'dm_profile_documentation')->first();
        return view('district_manager.profile.profile',$data);
    }

    public function update(Request $request){

        $dm = DistrictManager::findOrFail(dm()->id);
        $validator = $request->validate([
            'name' => 'required|min:4',
            'phone' => 'required|numeric|digits:11|unique:district_managers,phone,' . dm()->id,
            'age'=>'nullable|numeric|digits:2',
            'area'=>'nullable',
            'identification_type' => 'nullable|in:NID,DOB,Passport',
            'identification_no'=>'nullable|numeric',
            'present_address'=>'nullable',
            'cv'=>'nullable|file|mimes:pdf',

            'gender'=>'nullable|in:Male,Female,Others',
            'dob'=>'nullable|date|before:today',
            'father_name'=>'nullable|min:6',
            'mother_name'=>'nullable|min:6',
            'permanent_address'=>'nullable',
            'parent_phone'=>'nullable|numeric|digits:11',
        ]);
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = dm()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'district_manager/' . dm()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if(!empty($dm->cv)){
                $this->fileDelete($dm->cv);
            }
            $dm->cv = $path;
        }


        $dm->name = $request->name;
        $dm->phone = $request->phone;
        $dm->age = $request->age;
        $dm->area = $request->area;
        $dm->identification_type = $request->identification_type;
        $dm->identification_no = $request->identification_no;
        $dm->present_address = $request->present_address;
        $dm->update();

        if ($validator) {
            flash()->addSuccess('Profile updated successfully.');
        }
        return redirect()->back();
    }
    public function updatePassword(Request $request){

        $dm = DistrictManager::findOrFail(dm()->id);
        $validator = $request->validate([
            'old_password' => [
                'required',
                'min:4',
                function ($attribute, $value, $fail) {
                    // Check if the old_password matches the current password
                    if (!\Hash::check($value, dm()->password)) {
                        $fail("The $attribute doesn't match the current password.");
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
        ]);
        $dm->password = $request->password;
        $dm->update();

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
        $dm = DistrictManager::findOrFail(dm()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = dm()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'district_manager/' . dm()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $dm->image = $path;
            $dm->save();
            return response()->json(['message' => 'Image uploaded successfully'], 200);
        }

        return response()->json(['message' => 'Image not uploaded'], 400);
    }
    
}
