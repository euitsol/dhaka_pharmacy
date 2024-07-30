<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;


class TermsAndConditionsPageController extends Controller
{
    public function terms_and_conditions(): View
    {
        return view('frontend.terms_and_conditions');
    }
}
