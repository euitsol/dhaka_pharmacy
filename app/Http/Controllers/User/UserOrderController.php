<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\OrderDistribution;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


class UserOrderController extends Controller
{
    //

    
    public function __construct() {
        return $this->middleware('auth');
    }

    public function order_list()
    {
        $filter_val = request('filter');
        $query = Order::with(['address','customer','payments'])->where('status','!=',0)->where('customer_id',user()->id)->where('customer_type',get_class(user()))->latest();

        $currentUrl = URL::current();
        $data['url'] = $currentUrl . "?all";
        if($filter_val != null && $filter_val !='all'){
            if($filter_val == 5){
                $query->take($filter_val);
                $data['url'] = $currentUrl."?last-$filter_val-orders";
            }else{
                $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
                $data['url'] = $currentUrl."?last-$filter_val-days-orders";
            }
        }
        
        $data['orders'] = $query->get()->map(function($order){
            $order->order_items = AddToCart::with(['product.pro_cat', 'product.pro_sub_cat', 'product.generic', 'product.company', 'product.strength', 'customer', 'unit'])
            ->whereIn('id', json_decode($order->carts))
            ->get();
            $order->od = OrderDistribution::where('order_id',$order->id)->first();
            $order->place_date = date('d M Y h:m:s',strtotime($order->created_at));

            $order->order_items->transform(function($item) {
                $item->product->image = storage_url($item->product->image);
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

        if (request()->ajax()) {
            return response()->json($data);
        }else{
            return view('user.order.order_list',$data);
        } 
    }
}
