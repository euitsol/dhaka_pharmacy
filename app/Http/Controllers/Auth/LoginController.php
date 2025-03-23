<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\URL;
use App\Http\Traits\SmsTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, SmsTrait;
    protected $redirectTo = RouteServiceProvider::HOME;
    private $otpResentTime = 1;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    // Google Login
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }
        $existing = User::where('email', $user->email)->first();
        if ($existing) {
            Auth::guard('web')->login($existing);
        } else {
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->token           = $user->token;
            $newUser->refresh_token   = $user->refreshToken;
            $newUser->is_verify   = 1;
            $newUser->save();
            Auth::guard('web')->login($newUser);
        }
        ticketClosed();
        return redirect()->route('user.dashboard');
    }


    // Facebook Login
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        Log::info(Socialite::driver('facebook')->user());
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }
        $existing = User::where('email', $facebookUser->email)->first();
        if ($existing) {
            Auth::guard('web')->login($existing);
        } else {
            $newUser                  = new User;
            $newUser->name            = $facebookUser->name;
            $newUser->email           = $facebookUser->email;
            $newUser->facebook_id       = $facebookUser->id;
            $newUser->avatar          = $facebookUser->avatar;
            $newUser->token           = $facebookUser->token;
            $newUser->refresh_token   = $facebookUser->refreshToken;
            $newUser->is_verify   = 1;
            $newUser->save();
            Auth::guard('web')->login($newUser);
        }
        ticketClosed();
        return redirect()->route('user.dashboard');
    }

    public function fb_delete(Request $request)
    {

        $accessToken = $request->input('access_token');

        // Validate access token with Facebook API
        $response = Http::get("https://graph.facebook.com/debug_token", [
            'input_token' => $accessToken,
            'access_token' => config('services.facebook.app_access_token'),
        ]);

        if ($response->failed() || !$response->json('data.is_valid')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userIdFromFacebook = $response->json('data.user_id');

        // Validate that the user exists
        $user = User::where('facebook_id', $userIdFromFacebook)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Perform the deletion
        $user->delete();

        // Log the request
        Log::info('User deleted', ['facebook_id' => $userIdFromFacebook]);

        // Return the confirmation response
        return response()->json([
            'url' => route('login'),
        ]);
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


    public function showLoginForm()
    {
        $previous_url = url()->previous();
        session()->put('previous_url', $previous_url);
        if (Str::contains($previous_url, 'reset/password')) {
            session()->forget('previous_url');
        }
        if (Auth::guard('web')->check()) {
            $url = session()->get('previous_url', route('user.dashboard'));
            session()->forget('previous_url');
            return redirect($url);
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');
        $check = User::where('phone', $request->phone)->first();
        if ($check && !empty($check->password)) {
            if ($check->status == 1) {
                if (Auth::guard('web')->attempt($credentials, true)) {
                    $url = session()->get('previous_url', route('user.dashboard'));
                    session()->forget('previous_url');
                    ticketClosed();
                    return redirect($url);
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addWarning('Your account has been disabled. Please contact support.');
            }
        } elseif ($check && empty($check->password)) {
            flash()->addWarning('Your password has not been set. Please log in with OTP first, then set your password in your profile.');
        } else {
            flash()->addError('Invalid phone number.');
        }
        return redirect()->route('login')->withInput();
    }

    public function send_otp(SendOtpRequest $req)
    {
        try {
            $user = User::where('phone', $req->phone)->first();

            if (!$user) {
                $user = new User();
                $user->name = "Unkhnown User";
                $user->phone = $req->phone;
                $user->save();
            }
            if ($user) {
                if ($this->check_throttle($user)) {
                    flash()->addError($this->check_throttle($user));
                    return redirect()->back()->withInput();
                }

                // Save OTP in DB
                $user->otp = otp();
                $user->phone_verified_at = Carbon::now();
                $user->save();

                // SMS SEND
                $verification_sms = "Your verification code is $user->otp. Please enter this code to verify your phone.";
                $result = $this->sms_send($user->phone, $verification_sms);

                if ($result === true) {
                    flash()->addSuccess('The verification code has been sent successfully.');
                    return redirect()->route('use.otp', encrypt($user->id));
                } else {
                    flash()->addError($result);
                    return redirect()->back()->withInput();
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

    public function otp($user_id)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.otp_verify', compact('user_id'));
    }
    public function send_otp_again($user_id)
    {
        $user = User::findOrFail(decrypt($user_id));
        if ($user) {
            if ($this->check_throttle($user)) {
                $data['success'] = false;
                $data['message'] = $this->check_throttle($user);
            } else {
                $user->otp = otp();
                $user->phone_verified_at = Carbon::now();
                $user->save();

                // SMS SEND
                $verification_sms = "Your verification code is $user->otp. Please enter this code to verify your phone.";
                $result = $this->sms_send($user->phone, $verification_sms);


                if ($result === true) {
                    $data['success'] = true;
                    $data['message'] = 'The verification code has been sent successfully.';
                } else {
                    $data['success'] = false;
                    $data['message'] = $result;
                }
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'Something went wrong. Please try again.';
        }
        return response()->json($data);
    }
    public function otp_verify(Request $req)
    {
        $user = User::where('id', decrypt($req->user_id))->first();
        $otp = implode('', $req->otp);
        if ($user) {
            if ($user->otp == $otp) {
                $user->is_verify = 1;
                $user->update();

                if (session()->get('forgot')) {
                    return redirect()->route('user.reset.password', encrypt($user->id));
                } else {
                    Auth::guard('web')->login($user, true);
                    $url = session()->get('previous_url', route('user.dashboard'));
                    session()->forget('previous_url');
                    ticketClosed();
                    return redirect($url);
                }
            } else {
                flash()->addSuccess('OTP didn\'t match. Please try again');
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        ticketClosed();
        return redirect()->route('login');
    }
}
