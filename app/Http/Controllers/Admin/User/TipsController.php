<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTipsRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
use App\Models\Medicine;
use App\Models\ProductTips;
use App\Models\UserTips;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class TipsController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): View
    {
        $data['user_tips'] = UserTips::with('created_user')->latest()->get();
        return view('admin.user_tips.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = UserTips::with(['created_user', 'updated_user'])->findOrFail($id);
        $data->image = storage_url($data->image);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['products'] = Medicine::orderBy('name', 'asc')->get();
        $data['document'] = Documentation::where('module_key', 'user_tips')->first();
        return view('admin.user_tips.create', $data);
    }
    public function store(UserTipsRequest $req): RedirectResponse
    {
        $tips = new UserTips();
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->title . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'user_tips/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            $tips->image = $path;
        }
        $tips->description = $req->description;
        $tips->created_by = admin()->id;
        $tips->save();

        foreach ($req->products as $product_id) {
            $pro_tips = new ProductTips();
            $pro_tips->tips_id = $tips->id;
            $pro_tips->product_id = $product_id;
            $pro_tips->created_by = admin()->id;
            $pro_tips->save();
        }
        flash()->addSuccess("User tips created successfully");
        return redirect()->route('user_tips.tips_list');
    }
    public function edit($id): View
    {
        $data['user_tips'] = UserTips::findOrFail($id);
        $data['products'] = Medicine::orderBy('name', 'asc')->get();
        $data['tip_product_ids'] = ProductTips::where('tips_id', $id)->pluck('product_id')->toArray();
        $data['document'] = Documentation::where('module_key', 'user_tips')->first();
        return view('admin.user_tips.edit', $data);
    }

    public function update(UserTipsRequest $req, $id): RedirectResponse
    {
        $tips = UserTips::findOrFail($id);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->title . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'user_tips/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            if (!empty($tips->image)) {
                $this->fileDelete($tips->image);
            }
            $tips->image = $path;
        }
        $tips->description = $req->description;
        $tips->updated_by = admin()->id;
        $tips->save();

        $tip_products = ProductTips::where('tips_id', $tips->id)->pluck('product_id')->toArray();
        $product_ids = $req->products;

        // Find product_ids that are in the database but not in the request
        $product_ids_to_remove = array_diff($tip_products, $product_ids);

        // Find product_ids that are in the request but not in the database
        $product_ids_to_add = array_diff($product_ids, $tip_products);

        // Remove the ProductTips records
        if (!empty($product_ids_to_remove)) {
            ProductTips::where('tips_id', $tips->id)
                ->whereIn('product_id', $product_ids_to_remove)
                ->forceDelete();
        }

        // Add the new ProductTips records
        if (!empty($product_ids_to_add)) {
            collect($product_ids_to_add)->each(function ($product_id) use ($tips) {
                ProductTips::create([
                    'tips_id' => $tips->id,
                    'product_id' => $product_id,
                    'created_by' => admin()->id,
                ]);
            });
        }
        flash()->addSuccess("User tips updated successfully");
        return redirect()->route('user_tips.tips_list');
    }
    public function status($id): RedirectResponse
    {
        $tips = UserTips::findOrFail($id);
        $this->statusChange($tips);
        flash()->addSuccess('User tips status updated successfully.');
        return redirect()->route('user_tips.tips_list');
    }

    public function delete($id): RedirectResponse
    {
        $tips = UserTips::findOrFail($id);
        $tips->delete();
        flash()->addSuccess('User tips deleted successfully.');
        return redirect()->route('user_tips.tips_list');
    }
}
