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
            $query = ProductCategory::activated()->orderBy('name')->get();
            $data['categories'] = $query;
            $data['menuItems'] = $query->where('is_menu', 1);
            $data['atcs'] = [];
            if (Auth::guard('web')->check()) {
                $query = AddToCart::activated()->where('customer_id', user()->id);
                $data['atcs'] = $query->with(['product.pro_cat', 'product.generic', 'product.pro_sub_cat', 'product.company', 'product.discounts', 'customer'])->orderBy('created_at', 'asc')->get()
                    ->each(function ($atc) {
                        if ($atc->product) {
                            $atc->product = $this->transformProduct($atc->product, 45);
                            $atc->product->units = $this->getSortedUnits($atc->product->unit);
                        }
                        return $atc;
                    });
                $data['total_cart_item'] = $query->count();
            }

            $view->with($data);
        });
    }
}
