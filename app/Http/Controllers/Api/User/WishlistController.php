<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Traits\TransformProductTrait;
use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class WishlistController extends BaseController
{
    use TransformProductTrait;
    public function list(Request $request): JsonResponse
    {
        $user = $request->user();
        $filter_val = $request->filter ?? 7;
        $query = WishList::activated()->where('user_id', $user->id)->with([
            'product.pro_sub_cat',
            'product.generic',
            'product.company',
            'product.strength',
            'product.discounts',
            'product.units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            }
        ])->orderBy('updated_at', 'asc');
        if ($filter_val != 'all') {
            $query->where('updated_at', '>=', Carbon::now()->subDays($filter_val));
        }
        $wishes =  $query->get()->each(function (&$wish) {
            $wish->product = $this->transformProduct($wish->product, 60);
        });
        return sendResponse(true, 'Wishlist retrived successfully', ['wishes' => $wishes]);
    }
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();
        $product_id = $request->product_id;
        $wishlist = WishList::where('user_id', $user->id)->where('product_id', $product_id)->first();

        if ($wishlist) {
            $wishlist->status = ($wishlist->status == 1) ? 0 : 1;
            $wishlist->updated_at = Carbon::now();
            $wishlist->update();
        } else {
            $wishlist = new WishList();
            $wishlist->user_id = $user->id;
            $wishlist->product_id = $product_id;
            $wishlist->status = 1;
            $wishlist->created_at = Carbon::now();
            $wishlist->save();
        }
        $message = 'The item has been successfully added to your wishlist.';
        if ($wishlist->status == 0) {
            $message = 'The item has been successfully removed from your wishlist.';
        }
        return sendResponse(true, $message);
    }
}
