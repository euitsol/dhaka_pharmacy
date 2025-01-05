<?php

namespace App\Http\Controllers\LAM;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocalAreaManager\ImageUpdateRequest;
use App\Http\Requests\LocalAreaManager\PasswordUpdateRequest;
use App\Http\Requests\LocalAreaManager\ProfileUpdateRequest;
use App\Models\Documentation;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $data['lam'] = LocalAreaManager::findOrFail(lam()->id);
        return view('local_area_manager.profile.profile', $data);
    }

    public function update(ProfileUpdateRequest $request)
    {

        $lam = LocalAreaManager::findOrFail(lam()->id);
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = titleToSlug(lam()->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'local_area_manager/' . lam()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($lam->cv)) {
                $this->fileDelete($lam->cv);
            }
            $lam->cv = $path;
        }

        if (empty($lam->osa_id)) {
            $lam->osa_id = $request->osa_id;
        }
        $lam->name = $request->name;
        $lam->phone = $request->phone;
        $lam->age = $request->age;
        $lam->area = $request->area;
        $lam->identification_type = $request->identification_type;
        $lam->identification_no = $request->identification_no;
        $lam->present_address = $request->present_address;
        $lam->gender = $request->gender;
        $lam->dob = $request->dob;
        $lam->father_name = $request->father_name;
        $lam->mother_name = $request->mother_name;
        $lam->permanent_address = $request->permanent_address;
        $lam->parent_phone = $request->parent_phone;
        $lam->update();
        flash()->addSuccess('Profile updated successfully.');

        return redirect()->back();
    }
    public function updatePassword(PasswordUpdateRequest $request)
    {

        $lam = LocalAreaManager::findOrFail(lam()->id);
        $lam->password = $request->password;
        $lam->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->back();
    }
    public function updateImage(ImageUpdateRequest $request)
    {
        $lam = LocalAreaManager::findOrFail(lam()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = titleToSlug(lam()->name) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'local_area_manager/' . lam()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $lam->image = $path;
            $lam->save();
            return response()->json(['message' => 'Image uploaded successfully', 'image' => storage_url($lam->image)], 200);
        }
        return response()->json(['message' => 'Image not uploaded'], 400);
    }
    public function view_or_download($file_url)
    {
        $file_url = base64_decode($file_url);
        if (Storage::exists('public/' . $file_url)) {
            $fileExtension = pathinfo($file_url, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) === 'pdf') {
                return response()->file(storage_path('app/public/' . $file_url), [
                    'Content-Disposition' => 'inline; filename="' . basename($file_url) . '"'
                ]);
            } else {
                return response()->download(storage_path('app/public/' . $file_url), basename($file_url));
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
