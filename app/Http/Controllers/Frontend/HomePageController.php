<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderStatusChangeEvent;
use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use App\Http\Traits\TransformProductTrait;
use App\Models\Order;

class HomePageController extends Controller
{


    use TransformProductTrait;
    public function home(): View
    {
        // ticketClosed();
        $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'units' => function ($q) {
            $q->orderBy('quantity', 'asc');
        }])->activated();
        $data['products'] = (clone $products)->featured()->latest()->get()->shuffle()->take(8)->each(function (&$product) {
            $product = $this->transformProduct($product);
        });
        $data['bsItems'] = (clone $products)->bestSelling()->latest()->get()->shuffle()->take(8)->each(function (&$product) {
            $product = $this->transformProduct($product);
        });
        $data['featuredCategories'] = ProductCategory::activated()->featured()->orderBy('name')->get();

        return view('frontend.home', $data);
    }

    public function updateFeaturedProducts(): JsonResponse
    {
        $products = null;
        $data = null;
        $category_slug = request('category');

        if ($category_slug == 'all') {
            $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts'])->activated()->latest()->get();
        } else {
            $data['product_cat'] = ProductCategory::activated()->where('slug', $category_slug)->first();

            if (!empty($data['product_cat'])) {
                $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'units' => function ($q) {
                    $q->orderBy('quantity', 'asc');
                }])->activated()->featured()->where('pro_cat_id', $data['product_cat']->id)->latest()->get();
            }
        }
        $data['products'] = $products->shuffle()->take(8)->each(function ($product) {
            $product = $this->transformProduct($product);
            return $product;
        });
        return response()->json($data);
    }
}
