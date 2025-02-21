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
use App\Models\MedicineDose;
use App\Models\MedicineStrength;
use App\Models\MedicineUnit;
use App\Models\MedicineUnitBkdn;
use App\Models\ProductCategory;
use App\Models\ProductPrecaution;
use App\Models\ProductSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Services\MedicineEntryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MedicineController extends Controller
{
    protected MedicineEntryService$medicineEntryService;

    public function __construct(MedicineEntryService $medicineEntryService)
    {
        $this->middleware('admin');
        $this->medicineEntryService = $medicineEntryService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = Medicine::with(['pro_cat', 'created_user', 'discounts', 'company']);

            // Apply filters
            if ($request->has('company_id') && $request->company_id != '') {
                $data->where('company_id', $request->company_id);
            }
            if ($request->has('generic_id') && $request->generic_id != '') {
                $data->where('generic_id', $request->generic_id);
            }
            if ($request->has('status') && $request->status != '') {
                $data->where('status', $request->status);
            }
            if ($request->has('category_id') && $request->category_id != '') {
                $data->where('pro_cat_id', $request->category_id);
            }
            if ($request->has('created_at') && $request->created_at != '') {
                $data->whereDate('created_at', $request->created_at);
            }
            if ($request->has('is_featured') && $request->is_featured != '') {
                $data->where('is_featured', $request->is_featured);
            }
            if ($request->has('is_best_selling') && $request->is_best_selling != '') {
                $data->where('is_best_selling', $request->is_best_selling);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return date('d-m-Y', strtotime($data->created_at));
                })
                ->editColumn('name', function ($data) {
                    $companyName = optional($data->company)->name ?? 'No Company';
                    $strengthName = optional($data->strength)->name ?? 'No Strength';
                    $dosageFormName = optional($data->dosage)->name ?? 'No Dosage';
                    return $data->name . ' - ' . $strengthName . ' - ' . $dosageFormName . ' (' . $companyName . ')';
                })
                ->addColumn('created_user', function ($data) {
                    return $data->created_user->name ?? 'System';
                })
                ->addColumn('price', function ($data) {
                    return number_format($data->price, 2) . ' BDT';
                })
                ->addColumn('discount', function ($data) {
                    return $data->discount_percentage . ' %';
                })
                ->addColumn('discounted_price', function ($data) {
                    return number_format($data->discounted_price, 2) . ' BDT';
                })
                ->addColumn('best_selling', function ($data) {
                    return '<span class="' . $data->getBestSellingBadgeClass() . '">' . $data->getBestSelling() . '</span>';
                })
                ->addColumn('featured', function ($data) {
                    return '<span class="' . $data->getFeaturedBadgeClass() . '">' . $data->getFeatured() . '</span>';
                })
                ->addColumn('status', function ($data) {
                    return '<span class="' . $data->getStatusBadgeClass() . '">' . $data->getStatus() . '</span>';
                })
                ->addColumn('action', function ($data) {
                    return view('admin.partials.action_buttons', [
                        'menuItems' => [
                            [
                                'routeName' => 'product.medicine.details.medicine_list',
                                'params' => [$data->slug],
                                'label' => 'View Details',
                            ],
                            [
                                'routeName' => 'product.medicine.medicine_edit',
                                'params' => [$data->slug],
                                'label' => 'Update',
                            ],
                            [
                                'routeName' => 'product.medicine.best_selling.medicine_edit',
                                'params' => [$data->id],
                                'label' => $data->getBtnBestSelling(),
                            ],
                            [
                                'routeName' => 'product.medicine.featured.medicine_edit',
                                'params' => [$data->id],
                                'label' => $data->getBtnFeatured(),
                            ],
                            [
                                'routeName' => 'product.medicine.status.medicine_edit',
                                'params' => [$data->id],
                                'label' => $data->getBtnStatus(),
                            ],
                            [
                                'routeName' => 'product.medicine.medicine_delete',
                                'params' => [$data->id],
                                'label' => 'Delete',
                                'delete' => true,
                            ],
                        ],
                    ])->render();
                })
                ->rawColumns(['best_selling', 'featured', 'status', 'action'])
                ->make(true);
        }

        return view('admin.product_management.medicine.index');
    }

    public function details($slug): View
    {
        $data['medicine'] = Medicine::with(['pro_cat', 'pro_sub_cat', 'generic', 'company', 'strength', 'created_user', 'updated_user', 'discounts', 'units' => function ($q) {
            $q->orderBy('quantity', 'asc');
        }])->where('slug', $slug)->first();
        $data['precaution'] = ProductPrecaution::where('product_id', $data['medicine']->id)->first();
        return view('admin.product_management.medicine.details', $data);
    }


    public function create(): View
    {
        $data['pro_cats'] = ProductCategory::activated()->orderBy('name')->latest()->get();
        $data['generics'] = GenericName::activated()->orderBy('name')->latest()->get();
        $data['companies'] = CompanyName::activated()->orderBy('name')->latest()->get();
        $data['medicine_cats'] = MedicineCategory::activated()->orderBy('name')->latest()->get();
        $data['medicine_doses'] = MedicineDose::activated()->orderBy('name')->latest()->get();
        $data['strengths'] = MedicineStrength::activated()->latest()->get();
        $data['units'] = MedicineUnit::activated()->orderBy('name')->latest()->get();
        $data['document'] = Documentation::where([['module_key', 'product'], ['type', 'create']])->first();
        return view('admin.product_management.medicine.create', $data);
    }
    public function store(MedicineRequest $req): RedirectResponse
    {
        $medicine = new Medicine();

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->slug . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'products/' . $req->slug;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $medicine->image = $path;
        }
        $medicine->name = $req->name;
        $medicine->slug = $req->slug;

        $medicine->pro_cat_id = $req->pro_cat_id;

        $medicine->pro_sub_cat_id = $req->pro_sub_cat_id ?? null;
        $medicine->generic_id = $req->generic_id ?? null;
        $medicine->company_id = $req->company_id ?? null;
        $medicine->strength_id = $req->strength_id ?? null;

        $medicine->price = $req->price;
        $medicine->description = $req->description;
        $medicine->prescription_required = $req->prescription_required;
        $medicine->kyc_required = $req->kyc_required;
        $medicine->max_quantity = $req->max_quantity;
        $medicine->created_by = admin()->id;
        $medicine->save();

        //medicine unit bkdn
        foreach ($req->units as $unit) {
            MedicineUnitBkdn::create([
                'medicine_id' => $medicine->id,
                'unit_id' => $unit['id'],
                'price' => $unit['price'],
            ]);
        }

        $discount = new Discount();
        $discount->pro_id = $medicine->id;
        $discount->discount_amount = $req->discount_amount;
        $discount->discount_percentage = $req->discount_percentage;
        $discount->created_by = admin()->id;
        $discount->save();

        if ($req->has('precaution')) {
            ProductPrecaution::create([
                'description' => $req->precaution,
                'status' => $req->precaution_status ?? 0,
                'product_id' => $medicine->id,
                'created_by' => admin()->id,
            ]);
        }

        flash()->addSuccess('Medicine ' . $medicine->name . ' created successfully.');
        return redirect()->route('product.medicine.medicine_list');
    }
    public function edit($slug): View
    {
        $data['medicine'] = Medicine::with([
            'pro_cat',
            'pro_sub_cat',
            'generic',
            'company',
            'strength',
            'discounts',
            'units' => function ($q) {
                $q->orderBy('price', 'asc');
            },
        ])->where('slug', $slug)->first();
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
        $data['document'] = Documentation::where([['module_key', 'product'], ['type', 'update']])->first();
        $data['discounts'] = $data['medicine']->discounts->where('status', 0) ?? [];
        $data['precaution'] = ProductPrecaution::where('product_id', $data['medicine']->id)->first();

        return view('admin.product_management.medicine.edit', $data);
    }
    public function update(MedicineRequest $req, $id): RedirectResponse
    {
        DB::beginTransaction();
        $medicine = Medicine::findOrFail($id);

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->slug . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'products/' . $req->slug;
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

        $medicine->price = $req->price;
        $medicine->description = $req->description;
        $medicine->prescription_required = $req->prescription_required;
        $medicine->kyc_required = $req->kyc_required;
        $medicine->max_quantity = $req->max_quantity;
        $medicine->updated_by = admin()->id;
        $medicine->save();

        //medicine unit bkdn
        MedicineUnitBkdn::where('medicine_id', $medicine->id)->forceDelete();
        if ($req->units) {
            foreach ($req->units as $unit) {
                MedicineUnitBkdn::create([
                    'medicine_id' => $medicine->id,
                    'unit_id' => $unit['id'],
                    'price' => $unit['price'],
                ]);
            }
        }

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
        if ($req->precaution) {
            $check = ProductPrecaution::where('product_id', $medicine->id)->first();
            if ($check) {
                $check->update([
                    'description' => $req->precaution,
                    'status' => $req->precaution_status ?? 0,
                    'updated_by' => admin()->id,
                ]);
            } else {
                ProductPrecaution::create([
                    'product_id' => $medicine->id,
                    'description' => $req->precaution,
                    'status' => $req->precaution_status ?? 0,
                    'created_by' => admin()->id,
                ]);
            }
        }
        DB::commit();
        flash()->addSuccess('Medicine ' . $medicine->name . ' updated successfully.');
        // return redirect()->route('product.medicine.medicine_list');
        return redirect()->route('product.medicine.details.medicine_list', $medicine->slug);
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

        flash()->addSuccess('Medical device ' . $medicine->name . ' updated successfully.');
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

    public function bulkEntry()
    {
        $data['pro_cats'] = ProductCategory::activated()->orderBy('name')->latest()->get();
        $data['generics'] = GenericName::activated()->orderBy('name')->latest()->get();
        $data['companies'] = CompanyName::activated()->orderBy('name')->latest()->get();
        $data['medicine_cats'] = MedicineCategory::activated()->orderBy('name')->latest()->get();
        $data['medicine_doses'] = MedicineDose::activated()->orderBy('name')->latest()->get();
        $data['strengths'] = MedicineStrength::activated()->latest()->get();
        $data['units'] = MedicineUnit::activated()->orderBy('name')->latest()->get();
        $data['document'] = Documentation::where([['module_key', 'product'], ['type', 'create']])->first();

        return view('admin.product_management.medicine.bulk_entry', $data);
    }

    public function bulkImport(Request $request)
    {
        $medicine = $request->input('medicine', []);
        $result = $this->medicineEntryService->storeMedicine($medicine);
        return response()->json($result);
    }
}