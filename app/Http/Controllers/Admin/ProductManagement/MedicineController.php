<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineRequest;
use App\Models\CompanyName;
use App\Models\Documentation;
use App\Models\GenericName;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineStrength;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MedicineController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicines'] = Medicine::with(['pro_cat','generic','company','medicine_cat','strength','created_user'])->orderBy('name')->get();
        return view('admin.product_management.medicine.index',$data);
    }
    public function details($id): View
    {
        $data['medicine'] = Medicine::with(['pro_cat','generic','company','medicine_cat','strength','created_user','updated_user'])->where('id', $id)->first();

        $data['medicine']->units = collect(json_decode($data['medicine']->unit, true))->map(function ($unit) {
            $medicineUnit = MedicineUnit::findOrFail($unit);
            return $medicineUnit->name . " ($medicineUnit->quantity)";
        })->implode(' | ');
        return view('admin.product_management.medicine.details',$data);
    }


    public function create(): View
    {
        $data['pro_cats'] = ProductCategory::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['generics'] = GenericName::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['companies'] = CompanyName::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['medicine_cats'] = MedicineCategory::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['strengths'] = MedicineStrength::where('status',1)->where('deleted_at',null)->orderBy('quantity')->get();
        $data['units'] = MedicineUnit::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['document'] = Documentation::where('module_key','medicine')->first();
        return view('admin.product_management.medicine.create',$data);
    }
    public function store(MedicineRequest $req): RedirectResponse
    {
        $medicine = new Medicine();

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'district_manager/' . $req->name;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $medicine->image = $path;
        }
        $medicine->name = $req->name;
        $medicine->pro_cat_id = $req->pro_cat_id;
        $medicine->pro_cat_id = $req->pro_cat_id;
        $medicine->generic_id = $req->generic_id;
        $medicine->company_id = $req->company_id;
        $medicine->medicine_cat_id = $req->medicine_cat_id;
        $medicine->strength_id = $req->strength_id;
        $medicine->unit = json_encode($req->unit);
        $medicine->price = $req->price;
        $medicine->description = $req->description;
        $medicine->prescription_required = $req->prescription_required;
        $medicine->created_by = admin()->id;
        $medicine->save();
        flash()->addSuccess('Medicine '.$medicine->name.' created successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function edit($id): View
    {
        $data['medicine'] = Medicine::findOrFail($id);
        $data['pro_cats'] = ProductCategory::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['generics'] = GenericName::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['companies'] = CompanyName::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['medicine_cats'] = MedicineCategory::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['strengths'] = MedicineStrength::where('status',1)->where('deleted_at',null)->orderBy('quantity')->get();
        $data['units'] = MedicineUnit::where('status',1)->where('deleted_at',null)->orderBy('name')->get();
        $data['document'] = Documentation::where('module_key','medicine')->first();
        return view('admin.product_management.medicine.edit',$data);
    }
    public function update(MedicineRequest $req, $id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'district_manager/' . $req->name;
            $path = $image->storeAs($folderName, $imageName, 'public');
            if(!empty($medicine->image)){
                $this->fileDelete($medicine->image);
            }
            $medicine->image = $path;
        }
        $medicine->name = $req->name;
        $medicine->pro_cat_id = $req->pro_cat_id;
        $medicine->pro_cat_id = $req->pro_cat_id;
        $medicine->generic_id = $req->generic_id;
        $medicine->company_id = $req->company_id;
        $medicine->medicine_cat_id = $req->medicine_cat_id;
        $medicine->strength_id = $req->strength_id;
        $medicine->unit = json_encode($req->unit);
        $medicine->price = $req->price;
        $medicine->description = $req->description;
        $medicine->prescription_required = $req->prescription_required;
        $medicine->updated_by = admin()->id;
        $medicine->save();
        flash()->addSuccess('Medicine '.$medicine->name.' updated successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function status($id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);
        $this->statusChange($medicine);

        flash()->addSuccess('Medicine '.$medicine->name.' status updated successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function delete($id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        flash()->addSuccess('Medicine '.$medicine->name.' deleted successfully.');
        return redirect()->route('product.medicine.medicine_list');

    }
}
