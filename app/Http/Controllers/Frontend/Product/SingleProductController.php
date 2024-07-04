<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\View\View;
use App\Http\Traits\TransformProductTrait;


class SingleProductController extends Controller
{
    use TransformProductTrait;

    public function singleProduct($slug): View
    {

        $query =  Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'reviews.customer', 'units' => function ($q) {
            $q->orderBy('quantity', 'asc');
        }])->activated();

        $data['single_product'] = clone $query->where('slug', $slug)->first();
        $data['single_product'] = $this->transformProduct($data['single_product'], 100);

        $data['similar_products'] = $query->latest()->where('generic_id', ($data['single_product']->generic_id))->get()
            ->reject(function ($p) use ($data) {
                return $p->id == $data['single_product']->id;
            })->shuffle()->each(function ($product) {
                $product = $this->transformProduct($product, 26);
                return $product;
            });
        return view('frontend.product.single_product', $data);
    }
}
