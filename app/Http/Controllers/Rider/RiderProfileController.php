<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rider\ImageUpdateRequest;
use App\Http\Requests\Rider\PasswordUpdateRequest;
use App\Http\Requests\Rider\ProfileUpdateRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use App\Models\Rider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function update(ProfileUpdateRequest $request)
    {

        $rider = Rider::findOrFail(rider()->id);
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = titleToSlug(rider()->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'rider/' . rider()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($rider->cv)) {
                $this->fileDelete($rider->cv);
            }
            $rider->cv = $path;
        }


        if (empty($rider->oa_id)) {
            $rider->oa_id = $request->oa_id;
        }
        if (empty($rider->osa_id)) {
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
        flash()->addSuccess('Profile updated successfully.');
        return redirect()->back();
    }
    public function updatePassword(PasswordUpdateRequest $request)
    {

        $rider = Rider::findOrFail(rider()->id);
        $rider->password = $request->password;
        $rider->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->back();
    }
    public function updateImage(ImageUpdateRequest $request)
    {
        $rider = Rider::findOrFail(rider()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = titleToSlug(rider()->name) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'rider/' . rider()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $rider->image = $path;
            $rider->save();
            return response()->json(['message' => 'Image uploaded successfully', 'image' => storage_url($rider->image)], 200);
        }
        return response()->json(['message' => 'Image not uploaded'], 400);
    }

    public function get_osa($oa_id)
    {
        $operation_area = OperationArea::with('operation_sub_areas')->findOrFail($oa_id);

        $data['operation_sub_areas'] = $operation_area->operation_sub_areas->filter(function ($sub_area) {
            return $sub_area->status == 1;
        });
        return response()->json($data);
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
