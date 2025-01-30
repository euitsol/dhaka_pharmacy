<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ContactPageController extends Controller
{
    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function contact_submit(Request $request): RedirectResponse{
        return redirect()->route('contact_us');
    }
}
