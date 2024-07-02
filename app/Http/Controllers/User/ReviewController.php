<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewRequest;
use App\Models\Medicine;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function list(Request $request)
    {
        // $data['pageNumber'] = $request->query('page', 1);
        $filter_val = $request->get('filter') ?? request('filter');
        $data['filterValue'] = $filter_val;
        // $perPage = 10;
        $products = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'discounts'])->take(10)->get();
        // Retrieve reviews for the logged-in user
        // Convert reviews to a keyed array for easier lookup
        $review_products = Review::with('product')->where('customer_id', user()->id)->get()->keyBy('product_id');
        // Iterate over the products and add reviewed field and description
        $data['products'] = $products->each(function ($product) use ($review_products) {
            if ($review_products->has($product->id)) {
                $product->reviewed = true;
                $product->review = $review_products->get($product->id)->description;
            } else {
                $product->reviewed = false;
                $product->review = null;
            }
        })->sortBy('reviewed');

        // $query->with(['customer', 'order.od', 'order.ref_user']);
        // if ($filter_val && $filter_val != 'all') {
        //     if ($filter_val == 5) {
        //         $query->latest();
        //         $perPage = 5;
        //     } else {
        //         $query->where('created_at', '>=', Carbon::now()->subDays($filter_val));
        //     }
        // }
        // $payments =  $query->paginate($perPage)->withQueryString();
        // $payments->getCollection()->each(function ($payment) {
        //     $payment->date = date('d M Y h:m:s', strtotime($payment->created_at));
        //     return $payment;
        // });

        // $data['payments'] = $payments;
        // $data['pagination'] = $payments->links('vendor.pagination.bootstrap-5')->render();
        // if (request()->ajax()) {
        //     return response()->json($data);
        // } else {
        return view('user.review.list', $data);
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
