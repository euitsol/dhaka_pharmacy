<?php

namespace App\Http\Controllers\Hub\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\HubStaff\LoginRequest;
use App\Http\Requests\HubStaff\PasswordUpdateRequest;
use App\Http\Traits\MailSentTrait;
use App\Models\HubStaff;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoginController extends Controller
{
    private $otpResentTime = 1;
    use MailSentTrait;

    private function check_throttle($staff)
    {
        if ($staff->email_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($staff->email_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }
    public function staffLogin()
    {
        if (Auth::guard('staff')->check() && staff()->status == 1) {
            return redirect()->route('hub.dashboard');
        }
        return view('hub.auth.login');
    }

    public function staffLoginCheck(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $check = HubStaff::where('email', $request->email)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('staff')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('hub.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Hub Staff Not Found');
        }
        return redirect()->route('staff.login');
    }

    public function logout()
    {
        Auth::guard('staff')->logout();
        return redirect()->route('staff.login');
    }


    // Forgot Password
    public function forgot()
    {
        if (Auth::guard('staff')->check() && staff()->status == 1) {
            return redirect()->route('hub.dashboard');
        }
        return view('hub.auth.forgot');
    }

    public function send_otp(LoginRequest $request)
    {
        $staff = HubStaff::where('email', $request->email)->first();
        if ($request->ajax()) {
            $staff = HubStaff::where('id', decrypt($request->id))->first();
        }

        if ($staff) {
            if ($this->check_throttle($staff)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => $this->check_throttle($staff)]);
                } else {
                    flash()->addError($this->check_throttle($staff));
                    return redirect()->back()->withInput();
                }
            }
            $staff->otp = otp();
            $staff->email_verified_at = Carbon::now();
            $staff->save();
            $mail = $this->sendOtpMail($staff);
            if ($mail) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => 'The verification code has been successfully sent to your email']);
                }
                flash()->addSuccess('The verification code has been successfully sent to your email');
                return redirect()->route('staff.otp.verify', encrypt($staff->id));
            } else {
                flash()->addError('Something went wrong. Please try again.');
            }
        } else {
            flash()->addWarning('Email not found in our record');
        }
        if ($request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.']);
        }
        return redirect()->back()->withInput();
    }

    public function otp($staff_id)
    {
        if (Auth::guard('staff')->check() && staff()->status == 1) {
            return redirect()->route('hub.dashboard');
        }
        return view('hub.auth.verify', compact('staff_id'));
    }

    public function verify(Request $request, $staff_id): RedirectResponse
    {
        $staff = HubStaff::where('id', decrypt($staff_id))->first();
        $otp = implode('', $request->otp);
        if ($staff) {
            if ($staff->otp == $otp) {
                $staff->update();
                flash()->addSuccess('OTP verified successfully');
                return redirect()->route('staff.reset.password', encrypt($staff->id));
            } else {
                flash()->addWarning('OTP didn\'t match. Please try again');
                return redirect()->back()->withInput();
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('staff.login');
    }

    public function resetPassword($staff_id): View
    {
        return view('hub.auth.reset', compact('staff_id'));
    }

    public function resetPasswordStore(PasswordUpdateRequest $request, $staff_id): RedirectResponse
    {
        $staff = HubStaff::where('id', decrypt($staff_id))->first();
        $staff->password = $request->password;
        $staff->update();
        flash()->addSuccess('Password updated successfully');
        return redirect()->route('staff.login');
    }
}
