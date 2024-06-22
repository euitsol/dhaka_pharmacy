<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineStrengthRequest;
use App\Models\Documentation;
use App\Models\MedicineStrength;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class MedicineStrengthController extends Controller
{
    use DetailsCommonDataTrait;

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicine_strengths'] = MedicineStrength::with('created_user')->orderBy('quantity')->get();
        return view('admin.product_management.medicine_strength.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = MedicineStrength::with(['created_user', 'updated_user'])->findOrFail($id);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'medicine_strength')->first();
        return view('admin.product_management.medicine_strength.create', $data);
    }
    public function store(MedicineStrengthRequest $req): RedirectResponse
    {
        $medicine_strength = new MedicineStrength();
        $medicine_strength->quantity = $req->quantity;
        $medicine_strength->unit = $req->unit;
        $medicine_strength->created_by = admin()->id;
        $medicine_strength->save();
        flash()->addSuccess('Medicine strength ' . $medicine_strength->quantity . ' ' . $medicine_strength->unit . ' created successfully.');
        return redirect()->route('product.medicine_strength.medicine_strength_list');
    }
    public function edit($id): View
    {
        $data['medicine_strength'] = MedicineStrength::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'medicine_strength')->first();
        return view('admin.product_management.medicine_strength.edit', $data);
    }
    public function update(MedicineStrengthRequest $req, $id): RedirectResponse
    {
        $medicine_strength = MedicineStrength::findOrFail($id);
        $medicine_strength->quantity = $req->quantity;
        $medicine_strength->unit = $req->unit;
        $medicine_strength->updated_by = admin()->id;
        $medicine_strength->update();
        flash()->addSuccess('Medicine strength ' . $medicine_strength->quantity . ' ' . $medicine_strength->unit . ' updated successfully.');
        return redirect()->route('product.medicine_strength.medicine_strength_list');
    }
    public function status($id): RedirectResponse
    {
        $medicine_strength = MedicineStrength::findOrFail($id);
        $this->statusChange($medicine_strength);
        flash()->addSuccess('Medicine strength ' . $medicine_strength->name . ' status updated successfully.');
        return redirect()->route('product.medicine_strength.medicine_strength_list');
    }
    public function delete($id): RedirectResponse
    {
        $medicine_strength = MedicineStrength::findOrFail($id);
        $medicine_strength->delete();
        flash()->addSuccess('Medicine strength ' . $medicine_strength->quantity . ' ' . $medicine_strength->unit . ' deleted successfully.');
        return redirect()->route('product.medicine_strength.medicine_strength_list');
    }
}
