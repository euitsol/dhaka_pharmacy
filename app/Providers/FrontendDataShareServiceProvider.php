<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AddToCart;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Http\Traits\TransformProductTrait;

class FrontendDataShareServiceProvider extends ServiceProvider
{
    use TransformProductTrait;
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share data with specific views
        view()->composer(['frontend.*'], function ($view) {

            $data = [];
            $data['categories'] = ProductCategory::activated()->orderBy('name')->get();
            $data['menuItems'] = $data['categories']->where('is_menu', 1);
            $data['atcs'] = [];
            if(Auth::guard('web')->check()){
                $data['atcs'] = AddToCart::with(['product', 'customer'])->where('customer_id', user()->id)->where('status', 1)->latest()->get();
                $data['atcs'] = $data['atcs']->map(function ($atc) {
                    $activatedProduct = $atc->product;
                    if ($activatedProduct) {
                        $activatedProduct = $this->transformProduct($activatedProduct,45);
                        $activatedProduct->units = $this->getSortedUnits($activatedProduct->unit);
                    }
                    return $atc;
                });
    
                $data['total_cart_item'] = $data['atcs']->sum(function ($atc) {
                    return $atc->product ? 1 : 0;
                });
            }
           
            $view->with($data);
        });
    }
}
