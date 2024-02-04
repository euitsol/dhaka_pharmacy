<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\Documentation;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ProductCategoryController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['product_categories'] = ProductCategory::with(['created_user', 'updated_user'])->orderBy('name')->get();
        return view('admin.product_management.product_category.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = ProductCategory::findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'product_category')->first();
        return view('admin.product_management.product_category.create', $data);
    }
    public function store(ProductCategoryRequest $req): RedirectResponse
    {
        $product_category = new ProductCategory();
        $product_category->name = $req->name;
        $product_category->created_by = admin()->id;
        $product_category->save();
        flash()->addSuccess('Medicine category ' . $product_category->name . ' created successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function edit($id): View
    {
        $data['product_category'] = ProductCategory::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'product_category')->first();
        return view('admin.product_management.product_category.edit', $data);
    }
    public function update(ProductCategoryRequest $req, $id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $product_category->name = $req->name;
        $product_category->updated_by = admin()->id;
        $product_category->update();
        flash()->addSuccess('Medicine category ' . $product_category->name . ' updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }

    public function status($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $this->statusChange($product_category);
        flash()->addSuccess('Medicine category ' . $product_category->name . ' status updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function featured($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $this->featuredChange($product_category);
        flash()->addSuccess('Medicine category ' . $product_category->name . ' featured updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function delete($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $product_category->delete();
        flash()->addSuccess('Medicine category ' . $product_category->name . ' deleted successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
}
