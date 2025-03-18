<?php

namespace App\Http\Controllers\DM\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManager\LoginRequest;
use App\Http\Requests\DistrictManager\PasswordUpdateRequest;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\DistrictManager;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Traits\SmsTrait;


class LoginController extends Controller
{
    use SmsTrait;
    private $otpResentTime = 1;

    private function check_throttle($dm)
    {
        if ($dm->phone_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($dm->phone_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }
    public function dmLogin()
    {
        if (Auth::guard('dm')->check() && dm()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('dm.dashboard');
        }
        return view('district_manager.auth.login');
    }

    public function dmLoginCheck(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');
        $check = DistrictManager::where('phone', $request->phone)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('dm')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('dm.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('District Manager Not Found');
        }
        return redirect()->route('district_manager.login');
    }

    public function logout()
    {
        Auth::guard('dm')->logout();
        return redirect()->route('district_manager.login');
    }


    // Forgot Password
    public function forgot()
    {
        if (Auth::guard('dm')->check() && dm()->status == 1) {
            return redirect()->route('dm.dashboard');
        }
        return view('district_manager.auth.forgot');
    }

    public function phoneVerifyNotice()
    {
        return view('district_manager.phone_verify_notice');
    }

    public function phoneVerify($id)
    {
        $dm = DistrictManager::findOrfail(decrypt($id));
        if ($dm) {
            if ($this->check_throttle($dm)) {
                flash()->addError($this->check_throttle($dm));
                return redirect()->back()->withInput();
            }

            $dm->otp = otp();
            $dm->phone_verified_at = Carbon::now();
            $dm->save();
            $verification_sms = "Your verification code is $dm->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($dm->phone, $verification_sms);
            if ($result === true) {
                flash()->addSuccess('The verification code has been sent successfully.');
                session_start();
                $_SESSION['phone_verify'] = true;
                return redirect()->route('district_manager.otp.verify', encrypt($dm->id));
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
        $dm = DistrictManager::where('phone', $request->phone)->first();
        if ($request->ajax()) {
            $dm = DistrictManager::where('id', decrypt($request->id))->first();
        }
        if ($dm) {
            if ($this->check_throttle($dm)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => $this->check_throttle($dm)]);
                } else {
                    flash()->addError($this->check_throttle($dm));
                    return redirect()->back()->withInput();
                }
            }
            $dm->otp = otp();
            $dm->phone_verified_at = Carbon::now();
            $dm->save();
            $verification_sms = "Your verification code is $dm->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($dm->phone, $verification_sms);
            if ($result === true) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => 'The verification code has been sent successfully.']);
                }
                flash()->addSuccess('The verification code has been sent successfully.');
                return redirect()->route('district_manager.otp.verify', encrypt($dm->id));
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

    public function otp($dm_id)
    {
        if (Auth::guard('dm')->check() && dm()->status == 1 && dm()->is_verify == 1) {
            return redirect()->route('dm.dashboard');
        }
        return view('district_manager.auth.verify', compact('dm_id'));
    }

    public function verify(Request $request, $dm_id): RedirectResponse
    {
        $dm = DistrictManager::where('id', decrypt($dm_id))->first();
        $otp = implode('', $request->otp);
        if ($dm) {
            if ($dm->otp == $otp) {
                $dm->is_verify = 1;
                $dm->update();
                session_start();
                if (isset($_SESSION['phone_verify']) && $_SESSION['phone_verify'] == true) {
                    unset($_SESSION['phone_verify']);
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('dm.dashboard');
                } else {
                    flash()->addSuccess('OTP verified successfully');
                    return redirect()->route('district_manager.reset.password', encrypt($dm->id));
                }
            } else {
                flash()->addWarning('OTP didn\'t match. Please try again');
                return redirect()->back()->withInput();
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('district_manager.login');
    }

    public function resetPassword($dm_id): View
    {
        return view('district_manager.auth.reset', compact('dm_id'));
    }

    public function resetPasswordStore(PasswordUpdateRequest $request, $dm_id): RedirectResponse
    {
        $dm = DistrictManager::where('id', decrypt($dm_id))->first();
        $dm->password = $request->password;
        $dm->update();
        flash()->addSuccess('Password updated successfully');
        return redirect()->route('district_manager.login');
    }
}
