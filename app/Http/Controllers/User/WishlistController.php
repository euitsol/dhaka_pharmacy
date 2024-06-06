<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Traits\TransformProductTrait;
use Carbon\Carbon;

class WishlistController extends Controller
{
    use TransformProductTrait;

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function update($pid)
    {
        $pid = decrypt($pid);
        $wishlist = WishList::where('user_id', user()->id)->where('product_id', $pid)->first();

        if ($wishlist) {
            $status = ($wishlist->status == 1) ? 0 : 1;
            $wishlist->status = $status;
            $wishlist->updated_at = Carbon::now();
            $wishlist->update();
        } else {
            $wishlist = new WishList();
            $wishlist->user_id = user()->id;
            $wishlist->product_id = $pid;
            $wishlist->status = 1;
            $wishlist->created_at = Carbon::now();
            $wishlist->save();
        }
        $data['status'] = $wishlist->status;
        if ($wishlist->status == 1) {
            $data['message'] = 'The item has been successfully added to your wishlist.';
        } else {
            $data['message'] = 'The item has been successfully removed from your wishlist.';
        }
        return response()->json($data);
    }
    public function list()
    {
        $wishes = WishList::activated()->where('user_id', user()->id)->with([
            'product.pro_cat',
            'product.pro_sub_cat',
            'product.generic',
            'product.company',
            'product.strength',
            'product.discounts'
        ])->orderBy('updated_at', 'asc')->paginate(10);
        $wishes->getCollection()->each(function ($wish) {
            $wish->product = $this->transformProduct($wish->product, 30);
            $wish->product->units = $this->getSortedUnits($wish->product->unit);
            return $wish;
        });
        $data['wishes'] = $wishes;
        return view('user.wishlist.list', $data);
    }
    private function prepareOrderData($wishes)
    {
    }
}
