<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends BaseController
{

    public function pass_login(LoginRequest $request): JsonResponse
    {

        $phone = $request->phone;
        $password = $request->password;
        $user = User::wherephone($phone)->get()->first();
        if (!empty($user)) {
            if (Hash::check($password, $user->password)) {
                if ($user->status !== 1) {
                    return sendResponse(false, 'Your account is disabled. Please contact support', null, 403);
                }

                $token = $user->createToken('appToken')->accessToken;
                return sendResponse(true, 'Successfully logged in', $user->only('id', 'name', 'phone',), 200, ['token' => $token]);
            } else {
                return sendResponse(false, 'Invalid password', null, 401);
            }
        } else {
            return sendResponse(false, 'Invalid phone number', null, 401);
        }
    }
}
