<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineRequest;
use App\Models\CompanyName;
use App\Models\Discount;
use App\Models\Documentation;
use App\Models\GenericName;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineStrength;
use App\Models\MedicineUnit;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MedicineController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicines'] = Medicine::with(['pro_cat', 'created_user', 'discounts'])->orderBy('name')->get();
        return view('admin.product_management.medicine.index', $data);
    }
    public function details($slug): View
    {
        $data['medicine'] = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'created_user', 'updated_user', 'discounts'])->where('slug', $slug)->first();

        $data['medicine']->units = collect(json_decode($data['medicine']->unit, true))->each(function ($unit) {
            $medicineUnit = MedicineUnit::findOrFail($unit);
            return $medicineUnit->name . " ($medicineUnit->quantity)";
        })->implode(' | ');
        return view('admin.product_management.medicine.details', $data);
    }


    public function create(): View
    {
        $data['pro_cats'] = ProductCategory::activated()->orderBy('name')->get();
        $data['generics'] = GenericName::activated()->orderBy('name')->get();
        $data['companies'] = CompanyName::activated()->orderBy('name')->get();
        $data['medicine_cats'] = MedicineCategory::activated()->orderBy('name')->get();
        $data['strengths'] = MedicineStrength::activated()->orderBy('quantity')->get();
        $data['units'] = MedicineUnit::activated()->orderBy('name')->get();
        $data['document'] = Documentation::where('module_key', 'medicine')->first();
        return view('admin.product_management.medicine.create', $data);
    }
    public function store(MedicineRequest $req): RedirectResponse
    {
        $medicine = new Medicine();

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'products/' . $req->name;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $medicine->image = $path;
        }
        $medicine->name = $req->name;
        $medicine->slug = $req->slug;
        $medicine->pro_cat_id = $req->pro_cat_id;
        $medicine->pro_sub_cat_id = $req->pro_sub_cat_id;
        $medicine->generic_id = $req->generic_id;
        $medicine->company_id = $req->company_id;
        // $medicine->medicine_cat_id = $req->medicine_cat_id;
        $medicine->strength_id = $req->strength_id;
        $medicine->unit = json_encode($req->unit);
        $medicine->price = $req->price;
        $medicine->description = $req->description;
        $medicine->prescription_required = $req->prescription_required;
        $medicine->kyc_required = $req->kyc_required;
        $medicine->max_quantity = $req->max_quantity;
        $medicine->created_by = admin()->id;
        $medicine->save();

        $discount = new Discount();
        $discount->pro_id = $medicine->id;
        $discount->discount_amount = $req->discount_amount;
        $discount->discount_percentage = $req->discount_percentage;
        $discount->created_by = admin()->id;
        $discount->save();

        flash()->addSuccess('Medicine ' . $medicine->name . ' created successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function edit($slug): View
    {
        $data['medicine'] = Medicine::with('discounts')->where('slug', $slug)->first();
        if ($data['medicine']->discounts) {
            $data['discount'] = $data['medicine']->discounts->where('status', 1)->first();
        }
        $data['pro_cats'] = ProductCategory::activated()->orderBy('name')->get();
        $data['pro_sub_cats'] = ProductSubCategory::activated()->orderBy('name')->get();
        $data['generics'] = GenericName::activated()->orderBy('name')->get();
        $data['companies'] = CompanyName::activated()->orderBy('name')->get();
        $data['medicine_cats'] = MedicineCategory::activated()->orderBy('name')->get();
        $data['strengths'] = MedicineStrength::activated()->orderBy('quantity')->get();
        $data['units'] = MedicineUnit::activated()->orderBy('name')->get();
        $data['document'] = Documentation::where('module_key', 'medicine')->first();
        $data['discounts'] = $data['medicine']->discounts->where('status', 0) ?? [];
        return view('admin.product_management.medicine.edit', $data);
    }
    public function update(MedicineRequest $req, $id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'products/' . $req->name;
            $path = $image->storeAs($folderName, $imageName, 'public');
            if (!empty($medicine->image)) {
                $this->fileDelete($medicine->image);
            }
            $medicine->image = $path;
        }
        $medicine->name = $req->name;
        $medicine->slug = $req->slug;
        $medicine->pro_cat_id = $req->pro_cat_id;
        $medicine->pro_sub_cat_id = $req->pro_sub_cat_id;
        $medicine->generic_id = $req->generic_id;
        $medicine->company_id = $req->company_id;
        // $medicine->medicine_cat_id = $req->medicine_cat_id;
        $medicine->strength_id = $req->strength_id;
        $medicine->unit = json_encode($req->unit);
        $medicine->price = $req->price;
        $medicine->description = $req->description;
        $medicine->prescription_required = $req->prescription_required;
        $medicine->kyc_required = $req->kyc_required;
        $medicine->max_quantity = $req->max_quantity;
        $medicine->updated_by = admin()->id;
        $medicine->save();
        $check = Discount::activated()
            ->where('pro_id', $id)
            ->where('discount_amount', $req->discount_amount)
            ->Where('discount_percentage', $req->discount_percentage)
            ->first();

        if (!$check) {
            Discount::where('pro_id', $id)->where('status', 1)->update(['status' => 0]);
            $discount = new Discount();
            $discount->pro_id = $id;
            $discount->discount_amount = $req->discount_amount;
            $discount->discount_percentage = $req->discount_percentage;
            $discount->updated_by = admin()->id;
            $discount->save();
        }





        flash()->addSuccess('Medicine ' . $medicine->name . ' updated successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function status($id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);
        $this->statusChange($medicine);

        flash()->addSuccess('Medicine ' . $medicine->name . ' status updated successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function best_selling($id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);
        $this->bestSellingChange($medicine);

        flash()->addSuccess('Medicine ' . $medicine->name . ' best selling updated successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function featured($id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);
        $this->featuredChange($medicine);

        flash()->addSuccess('Medicine ' . $medicine->name . ' featured updated successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }

    public function delete($id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        flash()->addSuccess('Medicine ' . $medicine->name . ' deleted successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function get_sub_cat($id): JsonResponse
    {
        $data['pro_sub_cats'] = ProductSubCategory::where('pro_cat_id', $id)->activated()->orderBy('name')->get();
        return response()->json($data);
    }
}
