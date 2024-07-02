<?php

namespace App\Http\Controllers\Admin\PharmacyManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyDiscountRequest;
use App\Http\Requests\PharmacyRequest;
use App\Models\Documentation;
use App\Models\Pharmacy;
use App\Models\PharmacyDiscount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class PharmacyController extends Controller
{
    use DetailsCommonDataTrait;

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['pharmacies'] = Pharmacy::with('creater')->latest()->get();
        return view('admin.pharmacy_management.pharmacy.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Pharmacy::with(['creater', 'updater'])->findOrFail(decrypt($id));
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['pharmacy'] = Pharmacy::with(['creater', 'updater'])->findOrFail(decrypt($id));
        return view('admin.pharmacy_management.pharmacy.profile', $data);
    }
    public function loginAs($id)
    {
        $user = Pharmacy::findOrFail(decrypt($id));
        if ($user) {
            Auth::guard('pharmacy')->login($user);
            return redirect()->route('pharmacy.dashboard');
        } else {
            flash()->addError('Pharmacy not found');
            return redirect()->back();
        }
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'pharmacy')->first();
        return view('admin.pharmacy_management.pharmacy.create', $data);
    }
    public function store(PharmacyRequest $req): RedirectResponse
    {
        $pharmacy = new Pharmacy();
        $pharmacy->name = $req->name;
        $pharmacy->email = $req->email;
        $pharmacy->password = Hash::make($req->password);
        $pharmacy->creater()->associate(admin());
        $pharmacy->save();
        flash()->addSuccess('Pharmacy ' . $pharmacy->name . ' created successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }
    public function edit($id): View
    {
        $data['pharmacy'] = Pharmacy::findOrFail(decrypt($id));
        $data['document'] = Documentation::where('module_key', 'pharmacy')->first();
        return view('admin.pharmacy_management.pharmacy.edit', $data);
    }
    public function update(PharmacyRequest $req, $id): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->name = $req->name;
        $pharmacy->email = $req->email;
        if ($req->password) {
            $pharmacy->password = Hash::make($req->password);
        }
        $pharmacy->updater()->associate(admin());
        $pharmacy->update();
        flash()->addSuccess('Pharmacy ' . $pharmacy->name . ' updated successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }
    public function status($id): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail(decrypt($id));
        $this->statusChange($pharmacy);
        flash()->addSuccess('Pharmacy ' . $pharmacy->name . ' status updated successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }
    public function delete($id): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail(decrypt($id));
        $pharmacy->delete();
        flash()->addSuccess('Pharmacy ' . $pharmacy->name . ' deleted successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }


    public function pharmacyDiscount($id)
    {
        $data['pharmacy'] = Pharmacy::with(['pharmacyDiscounts' => function ($query) {
            $query->latest();
        }])->findOrFail(decrypt($id));
        $data['pharmacy_discount'] = PharmacyDiscount::activated()->where('pharmacy_id', decrypt($id))->first();
        return view('admin.pharmacy_management.pharmacy.discount', $data);
    }
    public function pharmacyDiscountUpdate(PharmacyDiscountRequest $req, $id)
    {
        PharmacyDiscount::where('pharmacy_id', decrypt($id))->update(['status' => 0]);
        if ($req->discount_percent != 0) {
            $discount = new PharmacyDiscount();
            $discount->pharmacy_id = decrypt($id);
            $discount->discount_percent = $req->discount_percent;
            $discount->creater()->associate(admin());
            $discount->save();
        }
        flash()->addSuccess('Pharmacy discount updated successfully.');
        return redirect()->back();
    }
}
