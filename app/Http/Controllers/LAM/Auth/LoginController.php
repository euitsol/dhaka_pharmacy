<?php

namespace App\Http\Controllers\LAM\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use App\Http\Requests\LocalAreaManager\LoginRequest;
use App\Http\Requests\LocalAreaManager\PasswordUpdateRequest;
use App\Models\DistrictManager;
use App\Models\LocalAreaManager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\SmsTrait;


class LoginController extends Controller
{
    use SmsTrait;
    private $otpResentTime = 1;
    private function check_throttle($lam)
    {
        if ($lam->phone_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($lam->phone_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }
    public function lamLogin()
    {

        if (Auth::guard('lam')->check() && lam()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('lam.dashboard');
        }
        return view('local_area_manager.auth.login');
    }

    public function lamLoginCheck(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');

        $check = LocalAreaManager::where('phone', $request->phone)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('lam')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('lam.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Local Area Manager Not Found');
        }
        return redirect()->route('local_area_manager.login');
    }


    function lamRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'phone' => 'required|numeric|digits:11|unique:local_area_managers,phone',
            'password' => 'required|min:6|confirmed',
            'dm_id' => 'required|exists:local_area_managers,id',
        ]);
        LocalAreaManager::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'dm_id' => $request->dm_id,
        ]);
        $credentials = $request->only('phone', 'password', 'dm_id');
        Auth::guard('lam')->attempt($credentials);

        return redirect()->route('local_area_manager.login');
    }

    function reference($id)
    {
        $data = DistrictManager::where('id', $id)->first();
        if (!$data) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }
    public function logout()
    {
        Auth::guard('lam')->logout();
        return redirect()->route('local_area_manager.login');
    }


    // Forgot Password
    public function forgot()
    {
        if (Auth::guard('lam')->check() && lam()->status == 1) {
            return redirect()->route('lam.dashboard');
        }
        return view('local_area_manager.auth.forgot');
    }

    public function phoneVerifyNotice()
    {
        return view('local_area_manager.phone_verify_notice');
    }

    public function phoneVerify($id)
    {
        $lam = LocalAreaManager::findOrfail(decrypt($id));
        if ($lam) {
            if ($this->check_throttle($lam)) {
                flash()->addError($this->check_throttle($lam));
                return redirect()->back()->withInput();
            }

            $lam->otp = otp();
            $lam->phone_verified_at = Carbon::now();
            $lam->save();
            $verification_sms = "Your verification code is $lam->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($lam->phone, $verification_sms);
            if ($result === true) {
                flash()->addSuccess('The verification code has been sent successfully.');
                session_start();
                $_SESSION['phone_verify'] = true;
                return redirect()->route('local_area_manager.otp.verify', encrypt($lam->id));
            } else {
                flash()->addError($result);
            }
        } else {
            flash()->addWarning('Phone number not found in our record');
        }
        return redirect()->back()->withInput();
    }
    public function send_otp(LoginRequest $request)
    {
        $lam = LocalAreaManager::where('phone', $request->phone)->first();
        if ($request->ajax()) {
            $lam = LocalAreaManager::where('id', decrypt($request->id))->first();
        }
        if ($lam) {
            if ($this->check_throttle($lam)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => $this->check_throttle($lam)]);
                } else {
                    flash()->addError($this->check_throttle($lam));
                    return redirect()->back()->withInput();
                }
            }
            $lam->otp = otp();
            $lam->phone_verified_at = Carbon::now();
            $lam->save();
            $verification_sms = "Your verification code is $lam->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($lam->phone, $verification_sms);
            if ($result === true) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => 'The verification code has been sent successfully.']);
                }
                flash()->addSuccess('The verification code has been sent successfully.');
                return redirect()->route('local_area_manager.otp.verify', encrypt($lam->id));
            } else {
                flash()->addError($result);
            }
        } else {
            flash()->addWarning('Phone number not found in our record');
        }
        if ($request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.']);
        }
        return redirect()->back()->withInput();
    }

    public function otp($lam_id)
    {
        if (Auth::guard('lam')->check() && lam()->status == 1 && lam()->is_verify == 1) {
            return redirect()->route('lam.dashboard');
        }
        return view('local_area_manager.auth.verify', compact('lam_id'));
    }

    public function verify(Request $request, $lam_id): RedirectResponse
    {
        $lam = LocalAreaManager::where('id', decrypt($lam_id))->first();
        $otp = implode('', $request->otp);
        if ($lam) {
            if ($lam->otp == $otp) {
                $lam->is_verify = 1;
                $lam->update();
                session_start();
                if (isset($_SESSION['phone_verify']) && $_SESSION['phone_verify'] == true) {
                    unset($_SESSION['phone_verify']);
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('lam.dashboard');
                } else {
                    flash()->addSuccess('OTP verified successfully');
                    return redirect()->route('local_area_manager.reset.password', encrypt($lam->id));
                }
            } else {
                flash()->addWarning('OTP didn\'t match. Please try again');
                return redirect()->back()->withInput();
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('local_area_manager.login');
    }

    public function resetPassword($lam_id): View
    {
        return view('local_area_manager.auth.reset', compact('lam_id'));
    }

    public function resetPasswordStore(PasswordUpdateRequest $request, $lam_id): RedirectResponse
    {
        $lam = LocalAreaManager::where('id', decrypt($lam_id))->first();
        $lam->password = $request->password;
        $lam->update();
        flash()->addSuccess('Password updated successfully');
        return redirect()->route('local_area_manager.login');
    }
}
