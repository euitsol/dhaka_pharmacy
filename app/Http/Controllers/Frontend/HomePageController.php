<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HomePageController extends BaseController
{
    public function home(){
        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at',NULL)->orderBy('name')->get();
        $data['menuItems'] = $data['categories']->where('is_menu',1);
        $data['featuredItems'] = $data['categories']->where('is_featured',1);
        return view('frontend.home',$data);
    }
}
