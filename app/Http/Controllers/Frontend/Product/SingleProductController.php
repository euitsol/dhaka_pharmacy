<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\View\View;
// use App\Http\Traits\TransformProductTrait;
use App\Services\ProductService;
use Exception;

class SingleProductController extends Controller
{
    // use TransformProductTrait;

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function singleProduct($slug): View
    {
        try {
            $this->productService->setProduct($slug);
            $data['single_product'] = $this->productService->details();
            $data['similar_products'] = $this->productService->relatedProducts();
            $data['bsProducts'] = $this->productService->bestSellingProducts();
        } catch (Exception $e) {
            abort(404);
        }

        // $single_product = Medicine::with(['pro_cat', 'wish' => function ($query) {
        //     if (auth()->guard('web')->check()) {
        //         $query->where('user_id', auth()->guard('web')->user()->id)->where('status', 1);
        //     }
        // }, 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'reviews.customer', 'units' => function ($q) {
        //     $q->orderBy('quantity', 'asc');
        // }])->activated()->where('slug', $slug)->first();
        // if (!$single_product) {
        //     abort(404);
        // }
        // $data['single_product'] = $this->transformProduct($single_product, 100);

        // $data['similar_products'] = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'reviews.customer', 'units' => function ($q) {
        //     $q->orderBy('quantity', 'asc');
        // }])->activated()->latest()->where('generic_id', ($single_product->generic_id))->get()
        //     ->reject(function ($p) use ($data) {
        //         return $p->id == $data['single_product']->id;
        //     })->shuffle()->each(function ($product) {
        //         $product = $this->transformProduct($product, 26);
        //         return $product;
        //     });

        return view('frontend.product.single_product', $data);
    }
}
