<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ReviewController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function products(): View
    {
        $data['products'] = Review::with('product.reviews')->distinct('product_id')->get()->pluck('product');
        return view('admin.review.products', $data);
    }

    public function list($slug): View
    {
        $data['reviews'] = Review::with(['product' => function ($query) use ($slug) {
            $query->where('slug', $slug);
        }])->orderBy('status', 'desc')->get();
        return view('admin.review.list', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Review::with(['product', 'customer'])->findOrFail($id);
        $data->description = html_entity_decode($data->description);
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function edit($id): View
    {
        $data['review'] = Review::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'review')->first();
        return view('admin.review.edit', $data);
    }
    public function update(ReviewRequest $req, $id): RedirectResponse
    {
        $review = Review::with('customer')->findOrFail($id);
        $review->update([
            'product_id' => $req->product_id,
            'description' => $req->description,
            'updater_id' => admin()->id,
            'updater_type' => get_class(admin()),
        ]);
        flash()->addSuccess($review->customer->name . ' review updated successfully.');
        return redirect()->route('review.review_list', $review->product_id);
    }
    public function status($id): RedirectResponse
    {
        $review = Review::with('customer')->findOrFail($id);
        $this->statusChange($review);
        flash()->addSuccess($review->customer->name . ' review status updated successfully.');
        return redirect()->route('review.review_list', $review->product_id);
    }
    public function delete($id): RedirectResponse
    {
        $review = Review::with('customer')->findOrFail($id);
        $review->deleter()->associate(admin());
        $review->delete();
        flash()->addSuccess($review->customer->name . ' review deleted successfully.');
        return redirect()->route('review.review_list', $review->product_id);
    }
}
