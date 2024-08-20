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
            if (isset($request->name)) {
                $user->name = $request->name;
            }
            if (isset($request->bio)) {
                $user->bio = $request->bio;
            }

            if (isset($request->designation)) {
                $user->designation = $request->designation;
            }
            if (isset($request->email)) {
                $user->email = $request->email;
            }
            if (isset($request->age)) {
                $user->age = $request->age;
            }
            if (isset($request->identification_type)) {
                $user->identification_type = $request->identification_type;
            }
            if (isset($request->identification_no)) {
                $user->identification_no = $request->identification_no;
            }
            if (isset($request->present_address)) {
                $user->present_address = $request->present_address;
            }
            if (isset($request->gender)) {
                $user->gender = $request->gender;
            }
            if (isset($request->dob)) {
                $user->dob = $request->dob;
            }
            if (isset($request->father_name)) {
                $user->father_name = $request->father_name;
            }
            if (isset($request->mother_name)) {
                $user->mother_name = $request->mother_name;
            }
            if (isset($request->permanent_address)) {
                $user->permanent_address = $request->permanent_address;
            }
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
