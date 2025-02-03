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
        $query = ProductCategory::select(['id', 'name', 'slug', 'image', 'status', 'is_featured', 'is_menu'])
        ->with(['pro_sub_cats:id,name,slug,image,status,is_menu,pro_cat_id']);

        //Featured Category
        if ($request->has('featured') && !empty($request->featured)) {
            if($request->featured == true){
                $query = $query->featured();
            }
        }

        //Menu Category
        if ($request->has('menu') && !empty($request->menu)) {
            if($request->menu == true){
                $query = $query->menu();
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
