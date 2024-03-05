<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineCategoryRequest;
use App\Models\Documentation;
use App\Models\MedicineCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MedicineCategoryController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicine_categorys'] = MedicineCategory::with(['created_user','updated_user'])->orderBy('name')->get();
        return view('admin.product_management.medicine_category.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = MedicineCategory::findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key','medicine_category')->first();
        return view('admin.product_management.medicine_category.create',$data);
    }
    public function store(MedicineCategoryRequest $req): RedirectResponse
    {
        $medicine_category = new MedicineCategory();
        $medicine_category->name = $req->name;
        $medicine_category->slug = $req->slug;
        $medicine_category->created_by = admin()->id;
        $medicine_category->save();
        flash()->addSuccess('Medicine Dosage '.$medicine_category->name.' created successfully.');
        return redirect()->route('product.medicine_category.medicine_category_list');
    }
    public function edit($slug): View
    {
        $data['medicine_category'] = MedicineCategory::where('slug',$slug)->first();
        $data['document'] = Documentation::where('module_key','medicine_category')->first();
        return view('admin.product_management.medicine_category.edit',$data);
    }
    public function update(MedicineCategoryRequest $req, $id): RedirectResponse
    {
        $medicine_category = MedicineCategory::findOrFail($id);
        $medicine_category->name = $req->name;
        $medicine_category->slug = $req->slug;
        $medicine_category->updated_by = admin()->id;
        $medicine_category->update();
        flash()->addSuccess('Medicine Dosage '.$medicine_category->name.' updated successfully.');
        return redirect()->route('product.medicine_category.medicine_category_list');
    }

    public function status($id): RedirectResponse
    {
        $medicine_category = MedicineCategory::findOrFail($id);
        $this->statusChange($medicine_category);
        flash()->addSuccess('Medicine Dosage ' . $medicine_category->name . ' status updated successfully.');
        return redirect()->route('product.medicine_category.medicine_category_list');
    }
    public function featured($id): RedirectResponse
    {
        $medicine_category = MedicineCategory::findOrFail($id);
        $this->featuredChange($medicine_category);
        flash()->addSuccess('Medicine Dosage ' . $medicine_category->name . ' featured updated successfully.');
        return redirect()->route('product.medicine_category.medicine_category_list');
    }
    public function delete($id): RedirectResponse
    {
        $medicine_category = MedicineCategory::findOrFail($id);
        $medicine_category->delete();
        flash()->addSuccess('Medicine Dosage '.$medicine_category->name.' deleted successfully.');
        return redirect()->route('product.medicine_category.medicine_category_list');

    }
}