<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\OtpVerifyRequest;
use App\Http\Requests\API\RegistrationRequest;
use App\Http\Requests\API\SendOtpRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends BaseController
{
    private $otpResentTime = 1;

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
    public function otp_login(SendOtpRequest $request): JsonResponse
    {

        $phone = $request->phone;
        $user = User::wherephone($phone)->get()->first();
        if (!empty($user)) {
            if ($this->check_throttle($user)) {
                return sendResponse(false, $this->check_throttle($user), null, 403);
            } else {
                $user->otp = otp();
                $user->phone_verified_at = Carbon::now();
                $user->save();
                $token = $user->createToken('appToken')->accessToken;
                return sendResponse(true, 'The verification code has been sent successfully.', $user->only('id',), 200, ['token' => $token]);
            }
        } else {
            return sendResponse(false, 'Phone number didn\'t match.', null, 401);
        }
    }

    public function otp_verify(OtpVerifyRequest $request)
    {
        $otp = $request->otp;
        $id = $request->id;
        $user = User::whereid($id)->get()->first();
        if (!empty($user)) {
            if ($user->otp == $otp) {
                $user->is_verify = 1;
                $user->update();
                $token = $user->createToken('appToken')->accessToken;
                return sendResponse(true, 'Successfully logged in', $user->only('id', 'name', 'phone',), 200, ['token' => $token]);
            } else {
                return sendResponse(false, 'OTP didn\'t match. Please try again', null, 401);
            }
        } else {
            return sendResponse(false, 'Something is wrong! please try again.', null, 401);
        }
    }


    public function registration(RegistrationRequest $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $password = $request->password;
        // param > password_confirmation 

        $user =  new User();
        $user->name = $name;
        $user->phone = $phone;
        $user->password = $password;
        $user->otp = otp();
        $user->save();
        $token = $user->createToken('appToken')->accessToken;
        return sendResponse(true, 'Your registration was successful, and a verification code has been sent to your phone.', $user->only('id'), 200, ['token' => $token]);
    }
































    private function check_throttle($user)
    {
        if ($user->phone_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($user->phone_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }
}
