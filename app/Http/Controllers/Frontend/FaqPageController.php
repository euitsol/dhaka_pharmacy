<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;


class FaqPageController extends Controller
{
    public function faq(): View
    {
        return view('frontend.faq.index');
    }
}
