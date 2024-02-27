<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class BaseController extends Controller
{
    public function __construct() {
        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at', null)->orderBy('name')->get();
        view()->share($data);
    }
}
