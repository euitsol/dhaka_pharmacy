<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Traits\TransformProductTrait;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use TransformProductTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update($pid, Request $request ): JsonResponse|RedirectResponse
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

        if($request->ajax()) {
            return response()->json($data);
        }else{
            flash()->addSuccess($data['message']);
            return redirect()->back();
        }
    }
    public function list(Request $request)
    {
        try {
            $perPage = 10;
            $query = WishList::activated()->where('user_id', user()->id)->with([
                'product.pro_sub_cat',
                'product.generic',
                'product.company',
                'product.strength',
                'product.discounts',
                'product.units' => function ($q) {
                    $q->orderBy('quantity', 'asc');
                }
            ])->orderBy('updated_at', 'desc');

            $wishes = $query->paginate($perPage);

            return view('user.wishlist.list', compact('wishes'));
        } catch (\Exception $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
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
        ])->orderBy('updated_at', 'asc')->get()->each(function ($item) {
            $item->pid = encrypt($item->product->id);
        });

        return response()->json($data);
    }
}
