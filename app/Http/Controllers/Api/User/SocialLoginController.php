<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\SocialLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class SocialLoginController extends BaseController
{
    public function social_login(SocialLoginRequest $request): JsonResponse
    {
        $existing = User::where('email', $request->email)->first();
        if ($existing) {
            $token = $existing->createToken('appToken')->accessToken;
            return sendResponse(true, 'Successfully logged in', $existing->only('id', 'name', 'email',), 200, ['token' => $token]);
        } else {
            $newUser                  = new User;
            $newUser->name            = $request->name;
            $newUser->email           = $request->email;
            if ($request->type == 'facebook') {
                $newUser->facebook_id       = $request->social_id;
            } elseif ($request->type == 'google') {
                $newUser->google_id       = $request->social_id;
            }
            $newUser->avatar          = $request->avatar;
            $newUser->token           = $request->token;
            $newUser->refresh_token   = $request->refreshToken;
            $newUser->is_verify   = 1;
            $newUser->save();

            $token = $newUser->createToken('appToken')->accessToken;
            return sendResponse(true, 'Successfully logged in', $newUser->only('id', 'name', 'email',), 200, ['token' => $token]);
        }
    }
}