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

    public function product(Request $request): JsonResponse
    {
        if ($request->has('slug') && !empty($request->slug)) {
            $sp = Medicine::with([
                'pro_cat',
                'pro_sub_cat',
                'generic',
                'company',
                'strength',
                'discounts',
                'reviews.customer',
                'wish' => function ($query) {
                    if (auth()->guard('api-user')->check()) {
                        $query->where('user_id', auth()->guard('api-user')->user()->id)->where('status', 1);
                    }
                },
                'units' => function ($q) {
                    $q->orderBy('quantity', 'asc');
                }
            ])->activated()->where('slug', $request->slug)->first();

            if (!$sp) {
                $message = "Invalid slug. Product not found";
                return sendResponse(false, $message, null);
            }
            $sp = $this->transformProduct($sp, 100);

            $simps = Medicine::with([
                'pro_cat',
                'pro_sub_cat',
                'generic',
                'company',
                'strength',
                'discounts',
                'reviews.customer',
                'units' => function ($q) {
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

            $data['product_details'] = $sp;
            $data['similar_products'] = $simps;

            $message = "Product details retrieved successfully";
            return sendResponse(true, $message, $data);
        } else {
            $message = "Please send the product slug.";
            return sendResponse(false, $message, null);
        }
    }
    public function products(Request $request): JsonResponse
    {
        $query = Medicine::with(['company', 'generic', 'pro_cat', 'pro_sub_cat', 'discounts', 'units', 'reviews.customer']);

        //By Category
        if ($request->has('category') && $request->category !== 'all') {
            $category = ProductCategory::with('pro_sub_cat')->where('slug', $request->category)->first();
            if (!empty($category)) {
                $query = $query->byCategory($category->id);
            } else {
                return sendResponse(false, 'Category not found');
            }
        }

        //By Sub Category
        if ($request->has('sub-category') && $request->{'sub-category'} !== 'all') {
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
