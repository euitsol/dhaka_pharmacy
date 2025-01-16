<?php

namespace App\Providers;

use App\Http\Traits\DeliveryTrait;
use Illuminate\Support\ServiceProvider;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\TransformProductTrait;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Support\Facades\Cache;

class FrontendDataShareServiceProvider extends ServiceProvider
{
    use TransformProductTrait, DeliveryTrait;
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

            $categories = Cache::remember('categories', 360, function () {
                return ProductCategory::where('status', 1)->orderBy('name')->get();
            });
            // $categories = ProductCategory::where('status', 1)->orderBy('name')->get();

            $data['categories'] = $categories;
            $data['menuItems'] = $categories->where('is_menu', 1);
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
                $data['customer'] = User::with(['address'])->findOrFail(user()->id);
                $data['customer']->address->each(function (&$address) {
                    $address->delivery_charge = $this->getDeliveryCharge($address->latitude, $address->longitude);
                });
            }

            $view->with($data);
        });
    }
}