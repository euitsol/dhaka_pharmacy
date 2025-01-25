<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Traits\MailSentTrait;
use Carbon\Carbon;

class LoginContorller extends Controller
{
    private $otpResentTime = 1;
    use MailSentTrait;

    private function check_throttle($admin)
    {
        if ($admin->email_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($admin->email_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }
    public function adminLogin()
    {
        if (Auth::guard('admin')->check() && admin()->status == 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function adminLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $check = Admin::where('email', $request->email)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('admin')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('admin.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Admin Not Found');
        }
        return redirect()->route('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }


    // Forgot Password
    public function forgot()
    {
        if (Auth::guard('admin')->check() && admin()->status == 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.forgot');
    }

    public function send_otp(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if ($request->ajax()) {
            $admin = Admin::where('id', decrypt($request->id))->first();
        }

        if ($admin) {
            if ($this->check_throttle($admin)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => $this->check_throttle($admin)]);
                } else {
                    flash()->addError($this->check_throttle($admin));
                    return redirect()->back()->withInput();
                }
            }
            $admin->otp = otp();
            $admin->email_verified_at = Carbon::now();
            $admin->save();
            $mail = $this->sendOtpMail($admin);
            if ($mail) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => 'The verification code has been successfully sent to your email']);
                }
                flash()->addSuccess('The verification code has been successfully sent to your email');
                return redirect()->route('admin.otp.verify', encrypt($admin->id));
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

    public function otp($admin_id)
    {
        if (Auth::guard('admin')->check() && admin()->status == 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.verify', compact('admin_id'));
    }

    public function verify(Request $request, $admin_id): RedirectResponse
    {
        $admin = Admin::where('id', decrypt($admin_id))->first();
        $otp = implode('', $request->otp);
        if ($admin) {
            if ($admin->otp == $otp) {
                $admin->update();
                flash()->addSuccess('OTP verified successfully');
                return redirect()->route('admin.reset.password', encrypt($admin->id));
            } else {
                flash()->addWarning('OTP didn\'t match. Please try again');
                return redirect()->back()->withInput();
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('admin.login');
    }

    public function resetPassword($admin_id): View
    {
        return view('admin.auth.reset', compact('admin_id'));
    }

    public function resetPasswordStore(Request $request, $admin_id): RedirectResponse
    {
        $admin = Admin::where('id', decrypt($admin_id))->first();
        $admin->password = $request->password;
        $admin->update();
        flash()->addSuccess('Password updated successfully');
        return redirect()->route('admin.login');
    }
}
