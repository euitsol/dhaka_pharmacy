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
use App\Models\WishList;

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
            $data['default_delivery_fee'] = 60;
            $query = ProductCategory::activated()->orderBy('name')->get();
            $data['categories'] = $query;
            $data['menuItems'] = $query->where('is_menu', 1);
            $data['wishes'] = [];
            if (Auth::guard('web')->check()) {
                $wishes = WishList::activated()->where('user_id', user()->id)->with([
                    'product.pro_cat',
                    'product.pro_sub_cat',
                    'product.generic',
                    'product.company',
                    'product.strength',
                    'product.discounts'
                ])->orderBy('updated_at', 'asc')->get()->each(function ($wish) {
                    $wish->product = $this->transformProduct($wish->product, 30);
                    return $wish;
                });
                $data['wishes'] = $wishes;
            }

            $view->with($data);
        });
    }
}
