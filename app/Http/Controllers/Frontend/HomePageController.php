<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use App\Http\Traits\OrderNotificationTrait;
use App\Http\Traits\TransformProductTrait;

class HomePageController extends Controller
{

    use OrderNotificationTrait, TransformProductTrait;
    public function home():View
    {

        //test
        // $order = Order::findOrFail(1);
        // $this->order_notification($order, 'order_initialized');

        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength','discounts'])->activated();
        $data['products'] = $products->featured()->latest()->get()->shuffle()->take(8)->each(function($product){
            $product = $this->transformProduct($product,30);
            $product->units = $this->getSortedUnits($product->unit);
            return $product;
        });
        $data['bsItems'] = $products->bestSelling()->latest()->get()->shuffle()->take(8)->each(function($product){
            $product = $this->transformProduct($product,30);
            $product->units = $this->getSortedUnits($product->unit);
            return $product;
        });
        $data['featuredItems'] = ProductCategory::activated()->featured()->orderBy('name')->get();

        return view('frontend.home',$data);
    }

    public function updateFeaturedProducts():JsonResponse
    {
        $category_slug = request('category');
        $currentUrl = URL::current();
        $data['url'] = $currentUrl . "?category=all";

        $products = Medicine::with(['pro_cat','pro_sub_cat','generic','company','strength','discounts'])->activated()->featured();
        $datas = $products->latest()->get();
        if($category_slug !== 'all'){
            $data['product_cat'] = ProductCategory::activated()->where('slug',$category_slug)->first();
            $data['url'] = $currentUrl . "?category=".$data['product_cat']->slug;
            $datas = $products->where('pro_cat_id',$data['product_cat']->id)->latest()->get();
        }
        $data['products'] = $datas->shuffle()->take(8)->transform(function($product){
            $product = $this->transformProduct($product,30);
            $product->units = $this->getSortedUnits($product->unit);
            return $product;
        });
        return response()->json($data);
    }


}
