<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AddToCart;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FrontendDataShareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
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
            $data['atcs'] = AddToCart::with(['product', 'customer'])->where('customer_id', user()->id)->where('status', 1)->latest()->get();
            $data['atcs'] = $data['atcs']->map(function ($atc) {
                $activatedProduct = $atc->product;
                if ($activatedProduct) {
                    $strength = $activatedProduct->strength ? ' (' . $activatedProduct->strength->quantity . ' ' . $activatedProduct->strength->unit . ')' : '';
                    $activatedProduct->attr_title = Str::ucfirst(Str::lower($activatedProduct->name . $strength));
                    $activatedProduct->name = Str::limit(Str::ucfirst(Str::lower($activatedProduct->name . $strength)), 45, '..');
                    $activatedProduct->generic->name = Str::limit($activatedProduct->generic->name, 55, '..');
                    $activatedProduct->company->name = Str::limit($activatedProduct->company->name, 55, '..');
                    $activatedProduct->discountPrice = $activatedProduct->discountPrice();
                    $activatedProduct->units = array_map(function ($u_id) {
                        return MedicineUnit::findOrFail($u_id);
                    }, (array) json_decode($activatedProduct->unit, true));
                    $activatedProduct->units = collect($activatedProduct->units)->sortBy('quantity')->values()->all();
                }
                return $atc;
            });

            $data['total_cart_item'] = $data['atcs']->sum(function ($atc) {
                return $atc->product ? 1 : 0;
            });
            $view->with($data);
        });
    }
}
