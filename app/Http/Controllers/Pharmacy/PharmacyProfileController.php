<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\AddressRequest;
use App\Models\Address;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use App\Http\Requests\Pharmacy\ProfileUpdateRequest;
use App\Http\Requests\Pharmacy\PasswordUpdateRequest;
use App\Http\Requests\Pharmacy\ImageUpdateRequest;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


class PharmacyProfileController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('pharmacy');
    }

    public function profile(): View
    {
        $data['document'] = Documentation::where('module_key', 'pharmacy_profile_documentation')->first();
        $data['pharmacy'] = Pharmacy::with(['address', 'operation_area', 'operation_sub_area'])->findOrFail(pharmacy()->id);
        $data['operation_areas'] = OperationArea::activated()->latest()->get();
        $data['operation_sub_areas'] = OperationSubArea::activated()->latest()->get();

        return view('pharmacy.profile.profile', $data);
    }

    public function address(AddressRequest $request): RedirectResponse
    {
        $address = Address::where('creater_id', pharmacy()->id)->where('creater_type', get_class(pharmacy()))->get();
        if ($address->count() > 0) {
            $save = $address->first();
        } else {
            $save = new Address;
        }

        $save->longitude = $request->long;
        $save->latitude = $request->lat;
        $save->address = $request->address;
        $save->city = $request->city;
        $save->street_address = $request->street;
        $save->apartment = $request->apartment;
        $save->floor = $request->floor;
        $save->delivery_instruction = $request->instruction;
        $save->creater()->associate(pharmacy());
        $save->save();

        flash()->addSuccess('Address modified successfully');
        return redirect()->back();
    }

    public function update(ProfileUpdateRequest $request)
    {

        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);

        if ($request->hasFile('identification_file')) {
            $file = $request->file('identification_file');
            $fileName = pharmacy()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'pharmacy/identification-file/' . pharmacy()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($pharmacy->identification_file)) {
                $this->fileDelete($pharmacy->identification_file);
            }
            $pharmacy->identification_file = $path;
        }

        $pharmacy->name = $request->name;
        $pharmacy->phone = $request->phone;
        $pharmacy->email = $request->email;
        if (empty($pharmacy->oa_id)) {
            $pharmacy->oa_id = $request->oa_id;
        }
        if (empty($pharmacy->osa_id)) {
            $pharmacy->osa_id = $request->osa_id;
        }
        if (!empty($request->identification_type)) {
            $pharmacy->identification_type = $request->identification_type;
        }
        if (!empty($request->emergency_phone)) {
            $pharmacy->emergency_phone = $request->emergency_phone;
        }
        $pharmacy->update();
        flash()->addSuccess('Profile updated successfully.');
        return redirect()->back();
    }
    public function updatePassword(PasswordUpdateRequest $request)
    {

        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        $pharmacy->password = $request->password;
        $pharmacy->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->back();
    }
    public function updateImage(ImageUpdateRequest $request)
    {
        $pharmacy = Pharmacy::findOrFail(pharmacy()->id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = pharmacy()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'pharmacy/' . pharmacy()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $pharmacy->image = $path;
            $pharmacy->save();
            return response()->json(['message' => 'Image uploaded successfully', 'image' => storage_url($pharmacy->image)], 200);
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
