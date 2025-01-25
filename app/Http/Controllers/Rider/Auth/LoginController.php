<?php

namespace App\Http\Controllers\Rider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rider;
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
    private function check_throttle($rider)
    {
        if ($rider->phone_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($rider->phone_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }
    public function riderLogin()
    {

        if (Auth::guard('rider')->check() && rider()->status == 1) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('rider.dashboard');
        }
        return view('rider.auth.login');
    }

    public function riderLoginCheck(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');
        $check = Rider::where('phone', $request->phone)->first();
        if ($check) {
            if ($check->status == 1) {
                if (Auth::guard('rider')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('rider.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('Local Area Manager Not Found');
        }
        return redirect()->route('rider.login');
    }

    public function logout()
    {
        Auth::guard('rider')->logout();
        return redirect()->route('rider.login');
    }


    // Forgot Password
    public function forgot()
    {
        if (Auth::guard('rider')->check() && rider()->status == 1) {
            return redirect()->route('rider.dashboard');
        }
        return view('rider.auth.forgot');
    }

    public function send_otp(Request $request)
    {
        $rider = Rider::where('phone', $request->phone)->first();
        if ($request->ajax()) {
            $rider = Rider::where('id', decrypt($request->id))->first();
        }
        if ($rider) {
            if ($this->check_throttle($rider)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => $this->check_throttle($rider)]);
                } else {
                    flash()->addError($this->check_throttle($rider));
                    return redirect()->back()->withInput();
                }
            }
            $rider->otp = otp();
            $rider->phone_verified_at = Carbon::now();
            $rider->save();
            $verification_sms = "Your verification code is $rider->otp. Please enter this code to verify your phone.";
            $result = $this->sms_send($rider->phone, $verification_sms);
            if ($result === true) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'success', 'message' => 'The verification code has been sent successfully.']);
                }
                flash()->addSuccess('The verification code has been sent successfully.');
                return redirect()->route('rider.otp.verify', encrypt($rider->id));
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

    public function otp($rider_id)
    {
        if (Auth::guard('rider')->check() && rider()->status == 1) {
            return redirect()->route('rider.dashboard');
        }
        return view('rider.auth.verify', compact('rider_id'));
    }

    public function verify(Request $request, $rider_id): RedirectResponse
    {
        $rider = Rider::where('id', decrypt($rider_id))->first();
        $otp = implode('', $request->otp);
        if ($rider) {
            if ($rider->otp == $otp) {
                $rider->is_verify = 1;
                $rider->update();
                flash()->addSuccess('OTP verified successfully');
                return redirect()->route('rider.reset.password', encrypt($rider->id));
            } else {
                flash()->addWarning('OTP didn\'t match. Please try again');
                return redirect()->back()->withInput();
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('rider.login');
    }

    public function resetPassword($rider_id): View
    {
        return view('rider.auth.reset', compact('rider_id'));
    }

    public function resetPasswordStore(Request $request, $rider_id): RedirectResponse
    {
        $rider = Rider::where('id', decrypt($rider_id))->first();
        $rider->password = $request->password;
        $rider->update();
        flash()->addSuccess('Password updated successfully');
        return redirect()->route('rider.login');
    }
}
