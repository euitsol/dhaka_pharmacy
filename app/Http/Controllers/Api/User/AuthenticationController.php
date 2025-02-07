<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\ForgotPasswordRequest;
use App\Http\Requests\API\ForgotPasswordUpdateRequest;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\OtpVerifyRequest;
use App\Http\Requests\API\RegistrationRequest;
use App\Http\Requests\API\SendOtpRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\SmsTrait;


class AuthenticationController extends BaseController
{
    use SmsTrait;
    private $otpResentTime = 1;

    public function pass_login(LoginRequest $request): JsonResponse
    {

        $phone = $request->phone;
        $password = $request->password;

        $user = User::wherephone($phone)->get()->first();
        if (Hash::check($password, $user->password)) {
            if ($user->status !== 1) {
                return sendResponse(false, 'Your account is disabled. Please contact support', null, 403);
            }
            $token = $user->createToken('appToken')->accessToken;
            return sendResponse(true, 'Successfully logged in', $user->only('id', 'name', 'phone',), 200, ['token' => $token]);
        } else {
            return sendResponse(false, 'Invalid password', null, 401);
        }
    }
    public function send_otp(SendOtpRequest $request): JsonResponse
    {
        try {
            $user = User::wherephone($request->phone)->get()->first();

            if (!$user) {
                $user = new User();
                $user->name = "Unknown User";
                $user->phone = $request->phone;
                $user->save();
            }
            if ($user) {
                if ($this->check_throttle($user)) {
                    return sendResponse(false, $this->check_throttle($user), null, 403);
                } else {
                    $result = $this->sendVerificationSms($user);
                    if ($result == true) {
                        return sendResponse(true, 'The verification code has been sent successfully.', $user->only('id'));
                    } else {
                        return sendResponse(false, 'Oops! Something went wrong. Please try again.', null);
                    }
                }
            } else {
                flash()->addError('Something went wrong! please try again.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            flash()->addError($e->getMessage());
            return redirect()->back()->withInput();
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
                return sendResponse(true, 'OTP verified successfully.', $user->only('id', 'name', 'phone',), 200, ['token' => $token]);
            } else {
                return sendResponse(false, 'OTP didn\'t match. Please try again', null, 401);
            }
        } else {
            return sendResponse(false, 'Something is wrong! please try again.', null, 401);
        }
    }


    public function registration(RegistrationRequest $request)
    {
        // param > password_confirmation
        $user =  new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->save();

        // $this->sendVerificationSms($user);

        return sendResponse(true, 'Your registration is successful', $user->only('id'), 200);
    }
    public function fp_phone_check(ForgotPasswordRequest $request)
    {
        $phone = $request->phone;

        $user = User::wherephone($phone)->get()->first();
        if ($user) {
            if ($this->check_throttle($user)) {
                return sendResponse(false, $this->check_throttle($user), null, 403);
            } else {
                $result = $this->sendVerificationSms($user);
                if ($result == true) {
                    return sendResponse(true, 'The verification code has been sent to your phone.', $user->only('id'), 200);
                } else {
                    return sendResponse(false, 'Oops! Something went wrong. Please try again.', null);
                }
            }
        } else {
            return sendResponse(false, 'User not found.', null, 401);
        }
    }
    public function fp_verify_otp(OtpVerifyRequest $request)
    {
        $otp = $request->otp;
        $id = $request->id;

        $user = User::whereid($id)->get()->first();
        if ($user) {
            if ($user->otp == $otp) {
                $user->is_verify = 1;
                $user->update();
                return sendResponse(true, 'OTP verified successfully', $user->only('id'), 200);
            } else {
                return sendResponse(false, 'OTP didn\'t match. Please try again', null, 401);
            }
        } else {
            return sendResponse(false, 'Something is wrong! please try again.', null, 401);
        }
    }
    public function fp_update(ForgotPasswordUpdateRequest $request)
    {
        $id = $request->id;
        $password = $request->password;

        $user = User::whereid($id)->get()->first();
        if ($user) {
            $user->password = $password;
            $user->save();
            return sendResponse(true, 'Your password has been successfully reset', null, 200);
        } else {
            return sendResponse(false, 'Something is wrong! please try again.', null, 401);
        }
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

    private function sendVerificationSms($user)
    {
        // $user->otp = '123456';
        $user->otp = otp();
        $user->phone_verified_at = Carbon::now();
        $user->save();

        $verification_sms = "Your verification code for " . config('app.name') . " is $user->otp. Please enter this code to verify your phone.";
        $result = $this->sms_send($user->phone, $verification_sms);

        return $result;
    }
}
