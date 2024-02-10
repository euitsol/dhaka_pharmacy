<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HomePageController extends BaseController
{
    public function home(){
        return view('frontend.home');
    }
}
