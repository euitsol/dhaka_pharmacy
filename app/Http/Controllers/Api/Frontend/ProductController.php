<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Api\BaseController;
use App\Http\Traits\TransformProductTrait;
use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;


class ProductController extends BaseController
{

    use TransformProductTrait;

    // public function singleProduct($slug): JsonResponse
    // {
    //     $defaultImagePath = 'frontend\default\cat_img.png'; // Set your default image path here
    //     $query = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'units' => function ($q) {
    //         $q->orderBy('quantity', 'asc');
    //     }])->activated();


    //     $sp = clone $query->where('slug', $slug)->first();
    //     $sp->discount_amount = calculateProductDiscount($sp, false);
    //     $sp->discount_percentage = calculateProductDiscount($sp, true);
    //     $sp->image = $sp->image ? storage_url($sp->image) : asset($defaultImagePath);

    //     $simps = $query->latest()->where('generic_id', ($sp->generic_id))->get()
    //         ->reject(function ($p) use ($sp) {
    //             return $p->id == $sp->id;
    //         })->shuffle()->each(function (&$product) {
    //             $product = $this->transformProduct($product, 26);
    //         });
    //     $data['single_product'] = $sp;
    //     $data['similar_products'] = $simps;
    //     $message =  "Product details retrived successfully";
    //     return sendResponse(true, $message, $data);
    // }

    // public function products($category_slug, $offset, $sub_category_slug = null)
    // {
    //     // $category_slug = request('category');
    //     // $sub_category_slug = request('sub-category');
    //     // $offset = request('offset');

    //     // $currentUrl = URL::current();
    //     // $data['url'] = $currentUrl . "?category=$category_slug&sub-category=$sub_category_slug";

    //     $data['sub_category'] =  ProductSubCategory::where('slug', $sub_category_slug)->activated()->first();

    //     $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts', 'units' => function ($q) {
    //         $q->orderBy('quantity', 'asc');
    //     }])->activated();

    //     $sub_cat_query = ProductSubCategory::with(['pro_cat'])->activated();

    //     $query->when(($category_slug !== 'all' && !empty($category_slug)), fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));

    //     $query->when(($sub_category_slug !== null), fn ($q) => $q->whereHas('pro_sub_cat', fn ($qs) => $qs->where('slug', $sub_category_slug)));

    //     $query->when(($offset !== null), fn ($q) => $q->offset($offset)->limit(1));

    //     $sub_cat_query->when(($category_slug !== 'all' && !empty($category_slug)), fn ($q) => $q->whereHas('pro_cat', fn ($qs) => $qs->where('slug', $category_slug)));

    //     $data['products'] = $query->limit(1)->get()->shuffle()->each(function ($product) {
    //         $product = $this->transformProduct($product, 25);
    //         // $product->units = $this->getSortedUnits($product->unit);
    //         return $product;
    //     });
    //     if ($category_slug !== 'all') {
    //         $data['category'] = ProductCategory::with(['pro_sub_cats', 'medicines'])->activated()->where('slug', $category_slug)->first();
    //     }

    //     $data['sub_categories'] = $sub_cat_query->orderBy('name')->get()->groupBy('pro_cat.name');

    //     $message = 'Products details retrived successfully';

    //     return sendResponse(true, $message, $data);
    // }

    public function products(Request $request):JsonResponse
    {
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts', 'units']);

        //By Category
        if ($request->has('category') && !empty($request->category)) {
            $category = ProductCategory::where('slug', $request->category)->first();
            if(!empty($category)){
                $query = $query->byCategory($category->id);
            }else{
                return sendResponse(false, 'Category not found');
            }
        }

        //By Sub Category
        if ($request->has('sub-category') && !empty($request->{'sub-category'})) {
            $scategory = ProductSubCategory::where('slug', $request->{'sub-category'})->first();
            if(!empty($scategory)){
                $query = $query->bySubCategory($scategory->id);
            }else{
                return sendResponse(false, 'Sub category not found');
            }
        }

        //By Best Selling
        if ($request->has('best-selling') && !empty($request->{'best-selling'})) {
            if($request->{'best-selling'} == true){
                $query = $query->bestSelling();
            }
        }

        //By Featured
        if ($request->has('featured') && !empty($request->{'featured'})) {
            if($request->{'featured'} == true){
                $query = $query->featured();
            }
        }

        // By Name
        if ($request->has('name') && !empty($request->name)) {
            $query->whereLike('name', "%{$request->name}%");
        }

        $data = $query->get()->shuffle()->each(function ($product) {
            $product = $this->transformProduct($product, 30);
            return $product;
        });

        return sendResponse(true, null, $data);
    }
}
