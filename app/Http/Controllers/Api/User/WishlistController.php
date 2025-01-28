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
        $query = WishList::select('id','user_id', 'product_id', 'status')
        ->activated()->where('user_id', $user->id)->with([
            'product:id,name,image,slug,status,pro_cat_id,pro_sub_cat_id,company_id,generic_id,strength_id,dose_id,price,description,image,prescription_required,kyc_required,max_quantity,created_at,status,is_best_selling',
            'product.pro_cat:id,name,slug,status',
            'product.pro_sub_cat:id,name,slug,status',
            'product.generic:id,name,slug,status',
            'product.company:id,name,slug,status',
            'product.strength:id,name,status',
            'product.discounts:id,pro_id,unit_id,discount_amount,discount_percentage,status',
            'product.dosage:id,name,slug,status',
            'product.units' => function ($q) {
                $q->select('medicine_units.id', 'medicine_units.name', 'medicine_units.quantity', 'medicine_units.image', 'medicine_units.status');
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
