<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewRequest;
use App\Http\Traits\TransformProductTrait;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use TransformProductTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request)
    {
        $uniqueProductIds = Order::where('customer_id', (user()->id))
            ->where('status', Order::DELIVERED)
            ->with('products:id')
            ->get()
            ->pluck('products.*.id')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'self_review'])
            ->whereIn('id', $uniqueProductIds)
            ->orderByRaw(
                '(SELECT COUNT(*) FROM reviews WHERE reviews.product_id = medicines.id AND reviews.customer_id = ?) ASC',
                [user()->id]
            )
            ->paginate(10);

        return view('user.review.list', [
            'products' => $products,
        ]);
    }

    public function store(ReviewRequest $request)
    {
        Review::create([
            'product_id' => $request->product_id,
            'customer_id' => user()->id,
            'description' => $request->description,
            'creater_id' => user()->id,
            'creater_type' => get_class(user()),
        ]);
        flash()->addSuccess('Your review has been received. Thank you for sharing your thoughts!');
        return redirect()->route('u.review.list');
    }
}
