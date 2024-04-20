<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\SendOtpRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends BaseController
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
        return redirect()->route('user.profile');
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
        return redirect()->route('user.profile');
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

        dd($facebookUser);
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
        return redirect()->route('user.profile');
    }






    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            flash()->addSuccess('Welcome to Dhaka Pharmacy');
            return redirect()->route('user.profile');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');


        $check = User::where('phone', $request->phone)->first();
        if(isset($check)){
            if($check->status == 1){
                if (Auth::guard('web')->attempt($credentials)) {
                    flash()->addSuccess('Welcome to Dhaka Pharmacy');
                    return redirect()->route('user.profile');
                }
                flash()->addError('Invalid credentials');
            }else{
                flash()->addError('Your account has been disabled. Please contact support.');
            }
        }else{
            flash()->addError('User Not Found');
        }
        return redirect()->route('login');
    }








    public function logout()
    {
        if (Auth::guard('pharmacy')->check()) {
            Auth::guard('pharmacy')->logout();
            return redirect()->route('pharmacy.login');
        }elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('login');
        }
    }

    public function send_otp(SendOtpRequest $req) {
        try {
            $user = User::where('phone',$req->phone)->first();
            $otp =  mt_rand(100000, 999999);
            // $otp =  000000;
            if($user){
                $user->otp = $otp;
                $user->save();
            }else{
                $new_user = new User();
                $new_user->name = 'User';
                $new_user->phone = $req->phone;
                $new_user->otp = $otp;
                $new_user->save();
            }
            return response()->json(['message' => 'Verification code send successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
