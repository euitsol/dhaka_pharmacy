<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class WebHookController extends Controller
{
    public function handler(Request $request)
    {
        Log::info('Response from Steadfast WebHook: ' . json_encode($request->all(), JSON_PRETTY_PRINT));
        return response()->json(null, 200);
    }
}
