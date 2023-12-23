<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ProfileController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function profile(){
        return view('user.profile');
    }
}
