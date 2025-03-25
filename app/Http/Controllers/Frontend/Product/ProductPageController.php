<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\URL;
use App\Http\Traits\TransformProductTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductPageController extends Controller
{
    use TransformProductTrait;
    // public function products()
    // {
    //     $category_slug = request('category');
    //     $sub_category_slug = request('sub-category');
    //     $featured = request('featured');
    //     $offset = request('offset');

    //     $currentUrl = URL::current();
    //     $data['url'] = $currentUrl . "?category=$category_slug&sub-category=$sub_category_slug";

    //     $data['sub_category'] =  ProductSubCategory::where('slug', $sub_category_slug)->activated()->first();


    //     $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts', 'units' => function ($q) {
    //         $q->orderBy('quantity', 'asc');
    //     }])->activated();

    //     $sub_cat_query = ProductSubCategory::with(['pro_cat'])->activated();

    //     $query->when(($category_slug !== 'all' && !empty($category_slug)), fn($q) => $q->whereHas('pro_cat', fn($qs) => $qs->where('slug', $category_slug)));

    //     $query->when(($sub_category_slug !== null), fn($q) => $q->whereHas('pro_sub_cat', fn($qs) => $qs->where('slug', $sub_category_slug)));

    //     $query->when(($featured == 1), fn($q) => $q->featured());

    //     $query->when(($offset !== null), fn($q) => $q->latest()->offset($offset));

    //     $sub_cat_query->when(($category_slug !== 'all' && !empty($category_slug)), fn($q) => $q->whereHas('pro_cat', fn($qs) => $qs->where('slug', $category_slug)));

    //     $data['products'] = $query->limit(12)->get()->each(function ($product) {
    //         $product = $this->transformProduct($product, 25);
    //         return $product;
    //     });
    //     if ($category_slug !== 'all') {
    //         $data['category'] = ProductCategory::with(['pro_sub_cats', 'medicines'])->activated()->where('slug', $category_slug)->first();
    //     }

    //     $data['sub_categories'] = $sub_cat_query->orderBy('name')->get()->groupBy('pro_cat.name');

    //     dd($data['products']);

    //     if (request()->ajax()) {
    //         return response()->json($data);
    //     } else {
    //         return view('frontend.product.product', $data);
    //     }
    // }



    public function products(Request $request)
    {
        $category_slug = $request->category ?? null;
        $sub_category_slug = $request->sub_category ?? null;
        $featured = $request->featured ?? null;

        // Base query for products
        $query = Medicine::with([
            'company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts',
            'units' => fn($q) => $q->orderBy('id', 'asc')
        ])->activated();

        // Filters
        if ($category_slug !== 'all') {
            $query->whereHas('pro_cat', fn($q) => $q->where('slug', $category_slug));
        }

        if ($sub_category_slug) {

            $data['sub_category'] = ProductSubCategory::where('slug', $sub_category_slug)
            ->activated()
            ->first();

            $query->whereHas('pro_sub_cat', fn($q) => $q->where('slug', $sub_category_slug));
        }

        if ($featured) {
            $query->featured();
        }

        // Paginate results (12 per page)
        $data['products'] = $query->paginate(24)->withQueryString()->through(fn($product) => $this->transformProduct($product, 25));

        // Fetch category details
        if ($category_slug !== 'all') {
            $data['category'] = ProductCategory::with(['pro_sub_cats'])
                ->activated()
                ->where('slug', $category_slug)
                ->first();
        }

        // Group subcategories by category name
        $sub_cat_query = ProductSubCategory::with(['pro_cat'])->activated();
        if ($category_slug !== 'all') {
            $sub_cat_query->whereHas('pro_cat', fn($q) => $q->where('slug', $category_slug));
        }
        $data['sub_categories'] = $sub_cat_query->orderBy('name')->get()->groupBy('pro_cat.name');

        // Return JSON for AJAX or view for full request
        if (request()->ajax()) {
            return response()->json([
                'products' => $data['products']->items(),
                'next_page_url' => $data['products']->nextPageUrl(),
                'per_page' => $data['products']->perPage(),
                'total' => $data['products']->total(),
            ]);
        }

        return view('frontend.product.product', $data);
    }

}
