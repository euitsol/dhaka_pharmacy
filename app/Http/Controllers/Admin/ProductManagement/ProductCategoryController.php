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
        $data['menuItemsCount'] = ProductCategory::where('is_menu',1)->activated()->count();
        return view('admin.product_management.product_category.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = ProductCategory::findOrFail($id);
        $data->image = storage_url($data->image);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
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

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'product_category/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            $product_category->image = $path;
        }

        $product_category->name = $req->name;
        $product_category->slug = $req->slug;
        $product_category->created_by = admin()->id;
        $product_category->save();
        flash()->addSuccess('Product category ' . $product_category->name . ' created successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function edit($slug): View
    {
        $data['product_category'] = ProductCategory::where('slug',$slug)->first();
        $data['document'] = Documentation::where('module_key', 'product_category')->first();
        return view('admin.product_management.product_category.edit', $data);
    }
    public function update(ProductCategoryRequest $req, $id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'product_category/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            if(!empty($product_category->image)){
                $this->fileDelete($product_category->image);
            }
            $product_category->image = $path;
        }
        $product_category->name = $req->name;
        $product_category->slug = $req->slug;
        $product_category->updated_by = admin()->id;
        $product_category->update();
        flash()->addSuccess('Product category ' . $product_category->name . ' updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }

    public function status($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $this->statusChange($product_category);
        flash()->addSuccess('Product category ' . $product_category->name . ' status updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function featured($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $this->featuredChange($product_category);
        flash()->addSuccess('Product category ' . $product_category->name . ' featured updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function menu($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $activeCount = ProductCategory::where('is_menu',1)->activated()->count();
        if($product_category->is_menu == 1){
            $product_category->is_menu = 0;
        }else{
            if($activeCount >= 10){
                flash()->addWarning('You have already added 10 categories to the menu.');
                return redirect()->route('product.product_category.product_category_list');
            }else{
                $product_category->is_menu = 1;
            }
        }
        $product_category->save();
        flash()->addSuccess('Product category ' . $product_category->name . ' menu updated successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
    public function delete($id): RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $product_category->delete();
        flash()->addSuccess('Product category ' . $product_category->name . ' deleted successfully.');
        return redirect()->route('product.product_category.product_category_list');
    }
}
