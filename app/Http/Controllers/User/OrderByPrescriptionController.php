<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PrescriptionRequest;
use App\Http\Requests\User\PrescriptionImageRequest;
use App\Services\PrescriptionService;
use App\Models\User;
use App\Http\Traits\SmsTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderByPrescriptionController extends Controller
{
    use SmsTrait;

    protected PrescriptionService $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }

    public function create(PrescriptionRequest $request)
    {
        try{
            $prescription = $this->prescriptionService->processPrescription($request->all(), true);
            // flash()->addSuccess('Prescription submitted successfully. Our team will contact you soon.');
            sweetalert()->success('Prescription submitted successfully. Our team will contact you soon.');
            return redirect()->route('home');
        }catch(Exception $e){
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }

    public function image_upload(PrescriptionImageRequest $request)
    {
        try {
            $file = $request->file('file');

            $data = $this->prescriptionService->uploadPrescriptionImage($file);

            return response()->json([
                'message' => 'Prescription image uploaded successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while uploading the prescription image.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|digits:10'
            ]);

            $phone = $this->purifyPhoneNumber($request->phone);

            // Find or create user
            $user = User::where('phone', $phone)->first();
            if (!$user) {
                $user = User::create([
                    'phone' => $phone,
                    'name' => 'New User',
                    'password' => bcrypt(uniqid()),
                ]);
            }

            // Generate OTP
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();

            // Send OTP via SMS
            $verification_sms = "Your verification code is $otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($user->phone, $verification_sms);

            if ($result === true) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP: ' . $result
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|digits:10'
            ]);

            $phone = $this->purifyPhoneNumber($request->phone);

            // Find user
            $user = User::where('phone', $phone)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Generate new OTP
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();

            // Send OTP via SMS
            $verification_sms = "Your verification code is $otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($user->phone, $verification_sms);

            if ($result === true) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP resent successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to resend OTP: ' . $result
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|digits:10',
                'otp' => 'required|digits:6'
            ]);

            $phone = $this->purifyPhoneNumber($request->phone);
            $otp = $request->otp;

            // Find user
            $user = User::where('phone', $phone)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Verify OTP
            if ($user->otp == $otp) {
                $user->phone_verified_at = now();
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    protected function purifyPhoneNumber($phone)
    {
        return '0' . $phone;
    }

}
