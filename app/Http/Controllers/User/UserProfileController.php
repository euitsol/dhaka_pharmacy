<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserProfileController extends BaseController
{
    public function __construct() {
        parent::__construct();
        return $this->middleware('auth');
    }

    public function profile():View
    {
        flash()->addSuccess('Welcome to Dhaka Pharmacy');
        return view('user.profile');
    }
}
