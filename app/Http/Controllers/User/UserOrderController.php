<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\OrderDistribution;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class UserOrderController extends Controller
{
    //

    
    public function __construct() {
        return $this->middleware('auth');
    }

    public function order_list():View
    {
        $data['orders'] = Order::with(['address','customer','payments'])->where('status','!=',0)->where('customer_id',user()->id)->where('customer_type',get_class(user()))->latest()->get()->map(function($order){
            $order->order_items = AddToCart::with(['product.pro_cat', 'product.pro_sub_cat', 'product.generic', 'product.company', 'product.strength', 'customer', 'unit'])
            ->whereIn('id', json_decode($order->carts))
            ->get();
            $order->od = OrderDistribution::where('order_id',$order->id)->first();

            $order->order_items->transform(function($item) {
                $item->price = (($item->product->price*($item->unit->quantity ?? 1))*$item->quantity);
                $item->discount_price = (($item->product->discountPrice()*($item->unit->quantity ?? 1))*$item->quantity);
                $item->discount = (productDiscountAmount($item->product->id)*($item->unit->quantity ?? 1))*$item->quantity;
                $strength = $item->product->strength ? ' ('.$item->product->strength->quantity.' '.$item->product->strength->unit.')' : '' ;
                $item->product->attr_title = Str::ucfirst(Str::lower($item->product->name . $strength ));
                $item->product->name = str_limit(Str::ucfirst(Str::lower($item->product->name . $strength )), 30, '..');
                $item->product->generic->name = str_limit($item->product->generic->name, 30, '..');
                $item->product->company->name = str_limit($item->product->company->name, 30, '..');
                $item->product->discount_amount = productDiscountAmount($item->product->id);
                $item->product->discount_percentage = productDiscountPercentage($item->product->id);
                return $item;
            });
            $order->totalPrice = number_format(ceil($order->order_items->sum('discount_price')+$order->delivery_fee));
            $order->totalRegularPrice = number_format(ceil($order->order_items->sum('price')+$order->delivery_fee));
            $order->totalDiscount = $order->order_items->sum('discount');
            
            

            return $order;
        });
        
        return view('user.order.order_list',$data);
    }
}
