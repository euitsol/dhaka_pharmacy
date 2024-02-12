<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSubCategoryRequest;
use App\Models\Documentation;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ProductSubCategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['product_categories'] = ProductSubCategory::with(['created_user', 'updated_user'])->orderBy('name')->get();
        $data['menuItemsCount'] = ProductSubCategory::where('is_menu',1)->where('status',1)->where('deleted_at',NULL)->count();
        return view('admin.product_management.product_sub_category.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = ProductSubCategory::with('pro_cat')->findOrFail($id);
        $data->image = storage_url($data->image);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $data['pro_cats'] = ProductCategory::where('status', 1)->latest()->get();
        $data['document'] = Documentation::where('module_key', 'product_sub_category')->first();
        return view('admin.product_management.product_sub_category.create', $data);
    }
    public function store(ProductSubCategoryRequest $req): RedirectResponse
    {
        $product_sub_category = new ProductSubCategory();
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'product_sub_category/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            $product_sub_category->image = $path;
        }
        $product_sub_category->name = $req->name;
        $product_sub_category->pro_cat_id = $req->pro_cat_id;
        $product_sub_category->created_by = admin()->id;
        $product_sub_category->save();
        flash()->addSuccess('Product Sub category ' . $product_sub_category->name . ' created successfully.');
        return redirect()->route('product.product_sub_category.product_sub_category_list');
    }
    public function edit($id): View
    {
        $data['product_sub_category'] = ProductSubCategory::findOrFail($id);
        $data['pro_cats'] = ProductCategory::where('status', 1)->latest()->get();
        $data['document'] = Documentation::where('module_key', 'product_sub_category')->first();
        return view('admin.product_management.product_sub_category.edit', $data);
    }
    public function update(ProductSubCategoryRequest $req, $id): RedirectResponse
    {
        $product_sub_category = ProductSubCategory::findOrFail($id);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'product_sub_category/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            if(!empty($product_sub_category->image)){
                $this->fileDelete($product_sub_category->image);
            }
            $product_sub_category->image = $path;
        }
        $product_sub_category->name = $req->name;
        $product_sub_category->pro_cat_id = $req->pro_cat_id;
        $product_sub_category->updated_by = admin()->id;
        $product_sub_category->update();
        flash()->addSuccess('Product Sub category ' . $product_sub_category->name . ' updated successfully.');
        return redirect()->route('product.product_sub_category.product_sub_category_list');
    }

    public function status($id): RedirectResponse
    {
        $product_sub_category = ProductSubCategory::findOrFail($id);
        $this->statusChange($product_sub_category);
        flash()->addSuccess('Product Sub category ' . $product_sub_category->name . ' status updated successfully.');
        return redirect()->route('product.product_sub_category.product_sub_category_list');
    }
    public function menu($id): RedirectResponse
    {
        $product_sub_category = ProductSubCategory::findOrFail($id);
        $activeCount = ProductSubCategory::where('is_menu',1)->where('status',1)->where('deleted_at',NULL)->count();
        if($product_sub_category->is_menu == 1){
            $product_sub_category->is_menu = 0;
        }else{
            if($activeCount >= 10){
                flash()->addWarning('You have already added 10 categories to the menu.');
                return redirect()->route('product.product_sub_category.product_sub_category_list');
            }else{
                $product_sub_category->is_menu = 1;
            }
        }
        $product_sub_category->save();
        flash()->addSuccess('Product sub category ' . $product_sub_category->name . ' menu updated successfully.');
        return redirect()->route('product.product_sub_category.product_sub_category_list');
    }
    public function delete($id): RedirectResponse
    {
        $product_sub_category = ProductSubCategory::findOrFail($id);
        $product_sub_category->delete();
        flash()->addSuccess('Product Sub category ' . $product_sub_category->name . ' deleted successfully.');
        return redirect()->route('product.product_sub_category.product_sub_category_list');
    }
}
