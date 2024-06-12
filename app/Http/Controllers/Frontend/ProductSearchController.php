<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\TransformProductTrait;


class ProductSearchController extends Controller
{
    use TransformProductTrait;
    public function productSearch($search_value, $category): JsonResponse
    {
        $filter = Medicine::with(['pro_sub_cat', 'generic', 'company', 'strength', 'discounts']);
        if ($category !== 'all') {
            $filter = $filter->where('pro_cat_id', $category);
        }
        $data['products'] = $filter->where(function ($query) use ($search_value) {
            $query->whereHas('generic', function ($query) use ($search_value) {
                $query->where('name', 'like', '%' . $search_value . '%')
                    ->activated();
            })
                ->orWhereHas('company', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->activated();
                })
                ->orWhereHas('pro_sub_cat', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->activated();
                })
                ->orWhere('name', 'like', '%' . $search_value . '%');
        })->get()->each(function ($product) {
            return $this->transformProduct($product, 30);
        });
        return response()->json($data);
    }
}
