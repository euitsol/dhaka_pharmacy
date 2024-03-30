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

                
                $data['checkItems'][0]['product'] = $product;
                $data['checkItems'][0]['name'] = $unit->name;
                $data['checkItems'][0]['quantity'] = $unit->quantity;
                $data['checkItems'][0]['status'] = true;
            }else{
                flash()->addError('Invalid Product');
                return redirect()->back();
            }
        }
        else{
            $atcs = AddToCart::where('is_check',1)->latest()->get();
            foreach($atcs as $key=>$atc){
                $unit = MedicineUnit::findOrFail($atc->unit_id);

                $strength = $atc->product->strength ? ' (' . $atc->product->strength->quantity . ' ' . $atc->product->strength->unit . ')' : '';
                $atc->product->attr_title = Str::ucfirst(Str::lower($atc->product->name . $strength));
                $atc->product->name = Str::limit(Str::ucfirst(Str::lower($atc->product->name . $strength)), 45, '..');
                $atc->product->generic->name = Str::limit($atc->product->generic->name, 55, '..');
                $atc->product->company->name = Str::limit($atc->product->company->name, 55, '..');
                $atc->product->discount = 20;
                $atc->product->delivery_fee = 60;

                $data['checkItems'][$key]['product'] = $atc->product;
                $data['checkItems'][$key]['quantity'] = $atc->quantity;
                $data['checkItems'][$key]['name'] = $unit->name;
            }
            
        }
        return view('frontend.product_order.checkout',$data);
    }
}
