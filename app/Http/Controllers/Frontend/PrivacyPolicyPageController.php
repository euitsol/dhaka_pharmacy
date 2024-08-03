<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;


class PrivacyPolicyPageController extends Controller
{
    public function privacy_policy(): View
    {
        return view('frontend.privacy_policy');
    }
}
