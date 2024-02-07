<?php

namespace App\Http\Controllers\LAM;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LamProfileController extends Controller
{

    public function __construct()
    {
        return $this->middleware('lam');
    }

    public function profile(): View
    {
        $data['document'] = Documentation::where('module_key', 'lam_profile_documentation')->first();
        return view('local_area_manager.profile.profile', $data);
    }

    public function update(Request $request)
    {

        $lam = LocalAreaManager::findOrFail(lam()->id);
        $validator = $request->validate([
            'name' => 'required|min:4',
            'phone' => 'required|numeric|digits:11|unique:local_area_managers,phone,' . lam()->id,
            'age' => 'nullable|numeric|digits:2',
            'area' => 'nullable',
            'identification_type' => 'nullable|in:NID,DOB,Passport',
            'identification_no' => 'nullable|numeric',
            'present_address' => 'nullable',
            'cv' => 'nullable|file|mimes:pdf',

            'gender' => 'nullable|in:Male,Female,Others',
            'dob' => 'nullable|date|before:today',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
            'permanent_address' => 'nullable',
            'parent_phone' => 'nullable|numeric|digits:11',
        ]);
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = lam()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'local_area_manager/' . lam()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($lam->cv)) {
                $this->fileDelete($lam->cv);
            }
            $lam->cv = $path;
        }


        $lam->name = $request->name;
        $lam->phone = $request->phone;
        $lam->age = $request->age;
        $lam->area = $request->area;
        $lam->identification_type = $request->identification_type;
        $lam->identification_no = $request->identification_no;
        $lam->present_address = $request->present_address;
        $lam->update();

        if ($validator) {
            flash()->addSuccess('Profile updated successfully.');
        }
        return redirect()->back();
    }
    public function updatePassword(Request $request)
    {

        $lam = LocalAreaManager::findOrFail(lam()->id);
        $validator = $request->validate([
            'old_password' => [
                'required',
                'min:4',
                function ($attribute, $value, $fail) {
                    // Check if the old_password matches the current password
                    if (!\Hash::check($value, lam()->password)) {
                        $fail("The $attribute doesn't match the current password.");
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
        ]);
        $lam->password = $request->password;
        $lam->update();

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
        $lam = LocalAreaManager::findOrFail(lam()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = lam()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'local_area_manager/' . lam()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $lam->image = $path;
            $lam->save();
            return response()->json(['message' => 'Image uploaded successfully'], 200);
        }

        return response()->json(['message' => 'Image not uploaded'], 400);
    }
}
