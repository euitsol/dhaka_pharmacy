<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendOtpRequest;
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

    use AuthenticatesUsers;
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
            return redirect('/login');
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
            $newUser->save();
            Auth::guard('web')->login($newUser);
        }
        return redirect()->route('user.dashboard');
    }


    // Github Login
    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect('/login');
        }
        $existing = User::where('email', $githubUser->email)->first();
        if ($existing) {
            Auth::guard('web')->login($existing);
        } else {
            $newUser                  = new User;
            $newUser->name            = $githubUser->name;
            $newUser->email           = $githubUser->email;
            $newUser->github_id       = $githubUser->id;
            $newUser->avatar          = $githubUser->avatar;
            $newUser->token           = $githubUser->token;
            $newUser->refresh_token   = $githubUser->refreshToken;
            $newUser->save();
            Auth::guard('web')->login($newUser);
        }
        return redirect()->route('user.dashboard');
    }


    // Facebook Login
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('/login');
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
            $newUser->save();
            Auth::guard('web')->login($newUser);
        }
        return redirect()->route('user.dashboard');
    }






    public function showLoginForm()
    {
        Session::forget('data');

        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');
        $check = User::where('phone', $request->phone)->first();
        if (isset($check)) {
            if ($check->status == 1) {
                if (Auth::guard('web')->attempt($credentials)) {
                    Session::forget('data');
                    return redirect()->route('user.dashboard');
                }
                flash()->addError('Invalid credentials');
            } else {
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        } else {
            flash()->addError('User Not Found');
        }
        return redirect()->route('login');
    }








    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function send_otp(SendOtpRequest $req)
    {
        try {
            $user = User::where('phone', $req->phone)->first();
            $data['user'] = $user;
            if ($user) {
                if ($this->check_throttle($user)) {
                    $data['success'] = false;
                    $data['error'] = '';
                    $data['message'] = $this->check_throttle($user);
                } else {
                    $user->otp = otp();
                    $user->phone_verified_at = Carbon::now();
                    $user->save();
                    $data['success'] = true;
                    $data['message'] = 'The verification code has been sent successfully.';
                    $data['url'] = route('use.send_otp');

                    $s['uid'] = encrypt($data['user']->id);
                    $s['otp'] = true;
                    Session::put('data', $s);
                }
            } else {
                $data['success'] = false;
                $data['error'] = 'Phone number didn\'t match.';
                $data['message'] = 'User Not Found';
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function check_throttle($user)
    {
        if ($user->phone_verified_at !== null) {
            $timeSinceLastOtp = now()->diffInMinutes($user->phone_verified_at);
            if ($timeSinceLastOtp < $this->otpResentTime) {
                return 'Please wait before requesting another verification otp as one has already been sent recently';
            }
        }
        return false;
    }

    public function verify()
    {
        $data = [];
        if (isset(Session::get('data')['uid'])) {
            $data['uid'] = decrypt(Session::get('data')['uid']);
        }
        if (isset(Session::get('data')['message'])) {
            flash()->addSuccess(Session::get('data')['message']);
        }
        $session = Session::get('data');
        unset($session['message']);
        Session::put('data', $session);

        if (isset(Session::get('data')['otp'])) {
            $data['otp'] = Session::get('data')['otp'];
            return view('auth.login', $data);
        }
        return redirect()->route('login');
    }
    public function send_otp_again()
    {
        $uid = Session::get('data')['uid'];
        $user = User::findOrFail(decrypt($uid));
        if ($this->check_throttle($user)) {
            $data['success'] = false;
            $data['message'] = $this->check_throttle($user);
        } else {
            $user->otp = otp();
            $user->phone_verified_at = Carbon::now();
            $user->save();
            $data['success'] = true;
            $data['message'] = 'The verification code has been sent successfully.';
        }

        return response()->json($data);
    }
    public function otp_verify(Request $req)
    {
        $uid = Session::get('data')['uid'];
        $user = User::where('id', decrypt($uid))->first();
        $otp = implode('', $req->otp);
        if ($user) {
            if ($user->otp == $otp) {
                $user->is_verify = 1;
                $user->update();
                if (isset(Session::get('data')['forgot'])) {
                    return redirect()->route('user.reset.password');
                }
                Session::forget('data');
                Auth::guard('web')->login($user);
            } else {
                flash()->addSuccess('OTP didn\'t match. Please try again');
            }
        } else {
            flash()->addSuccess('Something is wrong! please try again.');
        }
        return redirect()->back();
    }
}
