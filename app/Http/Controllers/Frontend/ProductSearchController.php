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
        // $filter = Medicine::with(['pro_cat', 'generic', 'company', 'strength', 'discounts'])->limit(10);
        // if ($category !== 'all') {
        //     $filter = $filter->where('pro_cat_id', $category);
        // }
        // $data['products'] = $filter->where(function ($query) use ($search_value) {
        //     $query->whereHas('generic', function ($query) use ($search_value) {
        //         $query->where('name', 'like', '%' . $search_value . '%')
        //             ->activated();
        //     })
        //         ->orWhereHas('company', function ($query) use ($search_value) {
        //             $query->where('name', 'like', '%' . $search_value . '%')
        //                 ->activated();
        //         })
        //         ->orWhereHas('pro_cat', function ($query) use ($search_value) {
        //             $query->where('name', 'like', '%' . $search_value . '%')
        //                 ->activated();
        //         })
        //         ->orWhere('name', 'like', '%' . $search_value . '%');
        // })->get()->each(function ($product) {
        //     return $this->transformProduct($product, 30);
        // });

        $query = Medicine::search($search_value);

        if ($category !== 'all') {
            $query = $query->where('category_id', $category);
        }

        // $query = $query->orderBy('price', 'asc');

        $data['products'] = $query->get()
            ->load(['pro_cat', 'generic', 'company', 'strength', 'discounts'])
            ->take(10)
            ->each(function ($product) {
                return $this->transformProduct($product, 30);
            });

        return response()->json($data);
    }
}
