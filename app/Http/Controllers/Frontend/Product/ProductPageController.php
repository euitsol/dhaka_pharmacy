<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\URL;
use App\Http\Traits\TransformProductTrait;


class ProductPageController extends Controller
{
    use TransformProductTrait;
    public function products()
    {
        $category_slug = request('category');
        $sub_category_slug = request('sub-category');
        $offset = request('offset');

        $currentUrl = URL::current();
        $data['url'] = $currentUrl . "?category=$category_slug&sub-category=$sub_category_slug";

        $data['sub_category'] =  ProductSubCategory::where('slug', $sub_category_slug)->activated()->first();


        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts', 'units' => function ($q) {
            $q->orderBy('quantity', 'asc');
        }])->activated();

        $sub_cat_query = ProductSubCategory::with(['pro_cat'])->activated();

        $query->when(($category_slug !== 'all' && !empty($category_slug)), fn($q) => $q->whereHas('pro_cat', fn($qs) => $qs->where('slug', $category_slug)));

        $query->when(($sub_category_slug !== null), fn($q) => $q->whereHas('pro_sub_cat', fn($qs) => $qs->where('slug', $sub_category_slug)));

        $query->when(($offset !== null), fn($q) => $q->latest()->offset($offset));

        $sub_cat_query->when(($category_slug !== 'all' && !empty($category_slug)), fn($q) => $q->whereHas('pro_cat', fn($qs) => $qs->where('slug', $category_slug)));

        $data['products'] = $query->limit(6)->get()->shuffle()->each(function ($product) {
            $product = $this->transformProduct($product, 25);
            return $product;
        });
        if ($category_slug !== 'all') {
            $data['category'] = ProductCategory::with(['pro_sub_cats', 'medicines'])->activated()->where('slug', $category_slug)->first();
        }

        $data['sub_categories'] = $sub_cat_query->orderBy('name')->get()->groupBy('pro_cat.name');

        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('frontend.product.product', $data);
        }
    }
}
