<?php

namespace App\Http\Controllers\Frontend\ProductOrder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use stdClass;

class CheckoutController extends BaseController
{
    public function checkout(){

        if(request('product') !== null && request('unit') !== null){
            $product = Medicine::with(['strength','generic','company'])->where('slug',request('product'))->first();
            $unit = MedicineUnit::where('id',request('unit'))->first();
            if($product && $unit){
                $strength = $product->strength ? ' (' . $product->strength->quantity . ' ' . $product->strength->unit . ')' : '';
                $product->attr_title = Str::ucfirst(Str::lower($product->name . $strength));
                $product->name = Str::limit(Str::ucfirst(Str::lower($product->name . $strength)), 45, '..');
                $product->generic->name = Str::limit($product->generic->name, 55, '..');
                $product->company->name = Str::limit($product->company->name, 55, '..');


                $product->discount = 20;
                $product->delivery_fee = 60;

                $product->units = array_map(function ($u_id) {
                    return MedicineUnit::findOrFail($u_id);
                }, (array) json_decode($product->unit, true));

                $data['checkItems'][0]['product'] = $product;
                $data['checkItems'][0]['quantity'] = $unit->quantity;
            }else{
                flash()->addError('Invalid Product');
                return redirect()->back();
            }
        }
        else{
            $atcs = AddToCart::where('is_check',1)->latest()->get();
            $atcs->map(function ($atc) {
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
            foreach($atcs as $key=>$atc){
                $data['checkItems'][$key]['product'] = $atc->product;
                $data['checkItems'][$key]['quantity'] = $atc->quantity;
            }
            
        }
        return view('frontend.product_order.checkout',$data);
    }
}
