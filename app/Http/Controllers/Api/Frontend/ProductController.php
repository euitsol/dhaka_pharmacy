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
            $sp = Medicine::select(['medicines.id', 'medicines.name', 'medicines.slug', 'medicines.pro_cat_id', 'medicines.pro_sub_cat_id', 'medicines.company_id', 'medicines.generic_id', 'medicines.strength_id', 'medicines.dose_id', 'medicines.price', 'medicines.description', 'medicines.image', 'medicines.prescription_required', 'medicines.kyc_required', 'medicines.max_quantity', 'medicines.created_at', 'medicines.status', 'medicines.is_best_selling'])
            ->with([
                'pro_cat:id,name,slug,status',
                'pro_sub_cat:id,name,slug,status',
                'generic:id,name,slug,status',
                'company:id,name,slug,status',
                'strength:id,name,status',
                'dosage:id,name,slug,status',
                'discounts:id,pro_id,unit_id,discount_amount,discount_percentage,status',
                'reviews:id,product_id,customer_id,description,status',
                'reviews.customer:id,name,status',
                'wish' => function ($query) {
                    $query->select('wishlists.id', 'wishlists.product_id', 'wishlists.user_id', 'wishlists.status');
                    if (auth()->guard('api-user')->check()) {
                        $query->where('user_id', auth()->guard('api-user')->user()->id)->where('status', 1);
                    }
                },
                'units' => function ($q) {
                    $q->select('medicine_units.id', 'medicine_units.name', 'medicine_units.quantity', 'medicine_units.image', 'medicine_units.status');
                    $q->orderBy('quantity', 'asc');
                }
            ])->activated()->where('slug', $request->slug)->first();

            if (!$sp) {
                $message = "Invalid slug. Product not found";
                return sendResponse(false, $message, null);
            }
            $sp = $this->transformProduct($sp, 100);

            $simps = Medicine::select(['medicines.id', 'medicines.name', 'medicines.slug', 'medicines.pro_cat_id', 'medicines.pro_sub_cat_id', 'medicines.company_id', 'medicines.generic_id', 'medicines.strength_id', 'medicines.dose_id', 'medicines.price', 'medicines.description', 'medicines.image', 'medicines.prescription_required', 'medicines.kyc_required', 'medicines.max_quantity', 'medicines.created_at', 'medicines.status', 'medicines.is_best_selling'])
            ->with([
                'pro_cat:id,name,slug,status',
                'pro_sub_cat:id,name,slug,status',
                'generic:id,name,slug,status',
                'company:id,name,slug,status',
                'strength:id,name,status',
                'dosage:id,name,slug,status',
                'discounts:id,pro_id,unit_id,discount_amount,discount_percentage,status',
            ])->activated()->where('generic_id', $sp->generic_id)
                ->where('id', '!=', $sp->id)
                ->orderBy('price', 'asc')
                ->get()
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
        $query = Medicine::select(['medicines.id', 'medicines.name', 'medicines.slug', 'medicines.pro_cat_id', 'medicines.pro_sub_cat_id', 'medicines.company_id', 'medicines.generic_id', 'medicines.strength_id', 'medicines.dose_id', 'medicines.price', 'medicines.description', 'medicines.image', 'medicines.prescription_required', 'medicines.kyc_required', 'medicines.max_quantity', 'medicines.created_at', 'medicines.status', 'medicines.is_best_selling'])
        ->with(['company:id,name,slug,status', 'generic:id,name,slug,status', 'pro_cat:id,name,slug,status', 'pro_sub_cat:id,name,slug,status', 'discounts:id,pro_id,unit_id,discount_amount,discount_percentage,status', 'units:id,name,quantity,image,status','strength:id,name,status', 'dosage:id,name,slug,status'])->activated();

        //By Category
        if ($request->has('category') && $request->category !== 'all') {
            $category = ProductCategory::with('pro_sub_cats')->where('slug', $request->category)->first();
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

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage)->withQueryString();

        $data = $query->get()->each(function ($product) {
            $product = $this->transformProduct($product, 30);
            return $product;
        });

        $additional = [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
            'next_page_url' => $products->nextPageUrl(),
            'prev_page_url' => $products->previousPageUrl()
        ];
        return sendResponse(true, null, $data, 200, $additional);
    }

    public function search(Request $request): JsonResponse
    {
        $search_value = $request->name;
        $query = Medicine::search($search_value);

        $data['products'] = $query->get()
            ->load(['pro_cat:id,name,slug,status', 'generic:id,name,slug,status', 'company:id,name,slug,status', 'strength:id,name,status'])
            ->take(10)
            ->each(function ($product) {
                return $this->transformProduct($product, 30);
            });
        return sendResponse(true, null, $data);
    }
}
