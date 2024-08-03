<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Api\BaseController;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CategoryController extends BaseController
{
    public function categories(Request $request): JsonResponse
    {
        $query = ProductCategory::with(['pro_sub_cats']);

        //Featured Category
        if ($request->has('featured') && !empty($request->featured)) {
            if($request->featured == true){
                $query = $query->featured();
            }
        }

        //Transform
        $cats = $query->activated()->orderBy('name', 'asc')->get()->each(function (&$cat) {
            $cat->image = storage_url($cat->image);
            $cat->pro_sub_cats->each(function (&$scat) {
                $scat->image = storage_url($scat->image);
            });
        });

        return sendResponse(true, null, $cats);
    }
}
