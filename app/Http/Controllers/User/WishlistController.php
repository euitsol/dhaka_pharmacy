<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Traits\TransformProductTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use TransformProductTrait;

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function update($pid): JsonResponse
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
        $data['wishlist'] = $wishlist->status;
        if ($wishlist->status == 1) {
            $data['message'] = 'The item has been successfully added to your wishlist.';
        } else {
            $data['message'] = 'The item has been successfully removed from your wishlist.';
        }
        return response()->json($data);
    }
    public function list(Request $request)
    {
        $filter_val = $request->get('filter') ?? request('filter');
        $filter_val = $filter_val ?? 7;
        $query = WishList::activated()->where('user_id', user()->id)->with([
            'product.pro_sub_cat',
            'product.generic',
            'product.company',
            'product.strength',
            'product.discounts',
            'product.units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            }
        ])->orderBy('updated_at', 'asc');
        $perPage = 10;
        if ($filter_val && $filter_val != 'all') {
            $query->where('updated_at', '>=', Carbon::now()->subDays($filter_val));
        }
        $wishes =  $query->paginate($perPage)->withQueryString();

        $wishes->getCollection()->each(function (&$wish) {
            $wish->product = $this->transformProduct($wish->product, 60);
            $wish->product->pid = encrypt($wish->product->id);
        });
        $data = [
            'wishes'=>$wishes,
            'filterValue' => $filter_val,
            'pagination'=>$wishes->links('vendor.pagination.bootstrap-5')->render(),
        ];
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('user.wishlist.list', $data);
        }
    }
    public function refresh(): JsonResponse
    {
        $data['wishes'] = WishList::activated()->where('user_id', user()->id)->with([
            'product.pro_cat',
            'product.pro_sub_cat',
            'product.generic',
            'product.company',
            'product.strength',
            'product.discounts',
            'product.units' => function ($q) {
                $q->orderBy('quantity', 'asc');
            }
        ])->orderBy('updated_at', 'asc')->get()->each(function (&$wish) {
            $wish->product = $this->transformProduct($wish->product, 60);
            $wish->product->pid = encrypt($wish->product->id);
        });
        return response()->json($data);
    }
}
