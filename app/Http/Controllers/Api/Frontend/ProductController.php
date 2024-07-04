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

    public function product($slug): JsonResponse
    {
        $sp = Medicine::with([
            'pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'reviews.customer', 'units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            }
        ])->activated()->where('slug', $slug)->first();

        if (!$sp) {
            $message = "Invalid slug. Product not found";
            return sendResponse(false, $message, null);
        }
        $sp = $this->transformProduct($sp, 100);

        $simps = Medicine::with([
            'pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'reviews.customer', 'units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            }
        ])->activated()->where('generic_id', $sp->generic_id)
            ->where('id', '!=', $sp->id)
            ->latest()
            ->get()
            ->shuffle()
            ->each(function (&$product) {
                $product = $this->transformProduct($product, 26);
            });

        $data['single_product'] = $sp;
        $data['similar_products'] = $simps;

        $message = "Product details retrieved successfully";
        return sendResponse(true, $message, $data);
    }
    public function products(Request $request): JsonResponse
    {
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts', 'units']);

        //By Category
        if ($request->has('category') && !empty($request->category)) {
            $category = ProductCategory::where('slug', $request->category)->first();
            if (!empty($category)) {
                $query = $query->byCategory($category->id);
            } else {
                return sendResponse(false, 'Category not found');
            }
        }

        //By Sub Category
        if ($request->has('sub-category') && !empty($request->{'sub-category'})) {
            $scategory = ProductSubCategory::where('slug', $request->{'sub-category'})->first();
            if (!empty($scategory)) {
                $query = $query->bySubCategory($scategory->id);
            } else {
                return sendResponse(false, 'Sub category not found');
            }
        }

        //By Best Selling
        if ($request->has('best-selling') && !empty($request->{'best-selling'})) {
            if ($request->{'best-selling'} == true) {
                $query = $query->bestSelling();
            }
        }

        //By Featured
        if ($request->has('featured') && !empty($request->{'featured'})) {
            if ($request->{'featured'} == true) {
                $query = $query->featured();
            }
        }

        // By Name
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', "%$request->name%");
        }

        $data = $query->get()->shuffle()->each(function ($product) {
            $product = $this->transformProduct($product, 30);
            return $product;
        });

        return sendResponse(true, null, $data);
    }
}
