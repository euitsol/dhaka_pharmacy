<?php

namespace App\Http\Controllers\DM;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManager\ImageUpdateRequest;
use App\Http\Requests\DistrictManager\PasswordUpdateRequest;
use App\Http\Requests\DistrictManager\ProfileUpdateRequest;
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

    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function profile(): View
    {
        $data['document'] = Documentation::where('module_key', 'dm_profile_documentation')->first();
        $data['dm'] = DistrictManager::findOrFail(dm()->id);
        return view('district_manager.profile.profile', $data);
    }

    public function update(ProfileUpdateRequest $request)
    {

        $dm = DistrictManager::findOrFail(dm()->id);
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = dm()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'district_manager/' . dm()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($dm->cv)) {
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
        $dm->gender = $request->gender;
        $dm->dob = $request->dob;
        $dm->father_name = $request->father_name;
        $dm->mother_name = $request->mother_name;
        $dm->permanent_address = $request->permanent_address;
        $dm->parent_phone = $request->parent_phone;
        $dm->update();
        flash()->addSuccess('Profile updated successfully.');
        return redirect()->back();
    }
    public function updatePassword(PasswordUpdateRequest $request)
    {

        $dm = DistrictManager::findOrFail(dm()->id);
        $dm->password = $request->password;
        $dm->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->back();
    }
    public function updateImage(ImageUpdateRequest $request)
    {
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

        return response()->json(['message' => false], 400);
    }
}