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
        return $this->middleware('auth');
    }

    public function list(Request $request)
    {
        $filter_val = $request->get('filter') ?? request('filter');
        $filter_val = $filter_val ?? 'all';
        $uniqueProductIds = Order::self()
            ->with('products:id') // Load only product IDs to reduce data load
            ->get()
            ->pluck('products.*.id') // Pluck the product IDs
            ->flatten() // Flatten the array to a single level
            ->unique() // Get unique product IDs
            ->values() // Reindex the array
            ->toArray(); // Convert to array
        $query = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts', 'self_review'])->whereIn('id', $uniqueProductIds);
        if ($filter_val == 1) {
            $query->whereHas('self_review');
        } elseif ($filter_val == 0) {
            $query->whereDoesntHave('self_review');
        }
        $query->orderByRaw(
            '(SELECT COUNT(*) FROM reviews WHERE reviews.product_id = medicines.id AND reviews.customer_id = ?) ASC',
            [user()->id]
        );
        $products = $query->paginate(10)->withQueryString();
        $products->getCollection()->each(function (&$product) {
            $this->transformProduct($product, 40);
        });
        $data = [
            'filterValue' => $filter_val,
            'products' => $products,
            'pagination' => $products->links('vendor.pagination.bootstrap-5')->render(),
        ];
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('user.review.list', $data);
        }
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
