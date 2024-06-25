<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\PasswordUpdateRequest;
use App\Http\Requests\API\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserController extends BaseController
{
    public function info(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            return sendResponse(true, 'User information retrived successfully', $user);
        } else {
            return sendResponse(false, 'User is invalid', null);
        }
    }
    public function update(UserRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $user->name . '_' . time() . '.' . $image->getClientOriginalExtension();
                $folderName = 'user/' . $user->id;
                $path = $image->storeAs($folderName, $imageName, 'public');
                $user->image = $path;
            }
            $user->name = $request->name;
            $user->bio = $request->bio;
            $user->designation = $request->designation;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->age = $request->age;
            $user->identification_type = $request->identification_type;
            $user->identification_no = $request->identification_no;
            $user->present_address = $request->present_address;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->father_name = $request->father_name;
            $user->mother_name = $request->mother_name;
            $user->permanent_address = $request->permanent_address;
            $user->updater()->associate($user);
            $user->update();
            return sendResponse(true, 'User profile updated successfully.');
        } else {
            return sendResponse(false, 'Invalid User', null);
        }
    }
    public function pass_update(PasswordUpdateRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $user->password = $request->new_password;
            $user->update();
            return sendResponse(true, 'Password updated successfully');
        } else {
            return sendResponse(false, 'User is invalid', null);
        }
    }
}
