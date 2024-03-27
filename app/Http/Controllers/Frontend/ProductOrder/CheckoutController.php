<?php

namespace App\Http\Controllers\Frontend\ProductOrder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\AddToCart;
use App\Models\MedicineUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class CheckoutController extends BaseController
{
    function checkout(){
        $data['checkItems'] = AddToCart::where('is_check',1)->latest()->get();

        $data['checkItems'] = $data['checkItems']->map(function ($atc) {
            $activatedProduct = $atc->product;
            if ($activatedProduct) {
                $strength = $activatedProduct->strength ? ' (' . $activatedProduct->strength->quantity . ' ' . $activatedProduct->strength->unit . ')' : '';
                $activatedProduct->attr_title = Str::ucfirst(Str::lower($activatedProduct->name . $strength));
                $activatedProduct->name = Str::limit(Str::ucfirst(Str::lower($activatedProduct->name . $strength)), 45, '..');
                $activatedProduct->generic->name = Str::limit($activatedProduct->generic->name, 55, '..');
                $activatedProduct->company->name = Str::limit($activatedProduct->company->name, 55, '..');


                $activatedProduct->discount = 20;
                $activatedProduct->delivery_fee = 60;

                $activatedProduct->units = array_map(function ($u_id) {
                    return MedicineUnit::findOrFail($u_id);
                }, (array) json_decode($activatedProduct->unit, true));

                $activatedProduct->units = collect($activatedProduct->units)->sortBy('quantity')->values()->all();
            }

            return $atc;
        });
        return view('frontend.product_order.checkout',$data);
    }
}
