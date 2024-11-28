<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ImageUpdateRequest;
use App\Http\Requests\User\PasswordUpdateRequest;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class ProfileController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function profile(): View
    {
        $data['user'] = User::findOrFail(user()->id);
        return view('user.profile', $data);
    }

    public function update(ProfileUpdateRequest $request)
    {

        $user = User::findOrFail(user()->id);
        if ($request->hasFile('identification_file')) {
            $file = $request->file('identification_file');
            $fileName = user()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'user/' . user()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($user->identification_file)) {
                $this->fileDelete($user->identification_file);
            }
            $user->identification_file = $path;
        }
        $user->name = $request->name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->age = $request->age;
        $user->dob = $request->dob;
        $user->identification_type = $request->identification_type;
        $user->identification_no = $request->identification_no;
        $user->present_address = $request->present_address;
        $user->permanent_address = $request->permanent_address;
        $user->gender = $request->gender;
        $user->emergency_phone = $request->emergency_phone;
        $user->bio = $request->bio;
        $user->email = $request->email;
        $user->occupation = $request->occupation;
        $user->updater()->associate(user());
        $user->update();
        flash()->addSuccess('Profile updated successfully.');
        return redirect()->back();
    }
    public function updatePassword(PasswordUpdateRequest $request)
    {

        $user = User::findOrFail(user()->id);
        $user->password = $request->password;
        $user->updater()->associate(user());
        $user->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->back();
    }
    public function updateImage(ImageUpdateRequest $request)
    {
        $user = User::findOrFail(user()->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = user()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'user/' . user()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $user->image = $path;
            $user->updater()->associate(user());
            $user->save();
            return response()->json(['message' => 'Image uploaded successfully', 'image' => storage_url($user->image)], 200);
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
