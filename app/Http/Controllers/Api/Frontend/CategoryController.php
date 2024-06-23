<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Api\BaseController;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;


class CategoryController extends BaseController
{
    public function categories($is_featured = false): JsonResponse
    {
        $defaultImagePath = 'frontend\default\cat_img.png'; // Set your default image path here
        $query = ProductCategory::selectRaw('id, name, slug, IFNULL(image, ?) as image', [$defaultImagePath]);
        $message = 'The category list was obtained successfully';
        if ($is_featured === 'featured') {
            $query->featured();
            $message = 'The featured category list was obtained successfully';
        }
        $cats = $query->orderBy('name', 'asc')->get();
        return sendResponse(true, $message, $cats);
    }
}