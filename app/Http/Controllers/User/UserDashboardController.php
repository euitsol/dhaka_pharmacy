<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserDashboardController extends BaseController
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function dashboard():View
    {
        $data['user'] = User::with(['address' => function ($query) {
            $query->where('is_default', 1);
        }])->findOrFail(user()->id);
        return view('user.dashboard', $data);
    }
}
