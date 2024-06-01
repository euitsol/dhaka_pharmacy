<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{

    public function pass_login(LoginRequest $request):JsonResponse
    {

        $phone = $request->phone;
        $password = $request->password;
        $user = User::wherephone($phone)->get()->first();
        if (!empty($user)) {
            if (Hash::check($password, $user->password)) {
                if ($user->status !== 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is disabled. Please contact support',
                        'token' => null,
                        'data' => null,
                    ], 403); // Forbidden
                }

                $token = $user->createToken('appToken')->accessToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully logged in',
                    'token' => $token,
                    'data' => $user->only('id', 'name','phone',), // Return only necessary user data
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password',
                    'token' => null,
                    'data' => null,
                ], 401); // Unauthorized
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number',
                'token' => null,
                'data' => null,
            ], 401); // Unauthorized
        }
    }
}
