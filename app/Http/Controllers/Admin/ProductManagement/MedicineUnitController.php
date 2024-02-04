<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineUnitRequest;
use App\Models\Documentation;
use App\Models\MedicineUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MedicineUnitController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicine_units'] = MedicineUnit::with(['created_user', 'updated_user'])->orderBy('name')->get();
        return view('admin.product_management.medicine_unit.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = MedicineUnit::findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'medicine_unit')->first();
        return view('admin.product_management.medicine_unit.create', $data);
    }
    public function store(MedicineUnitRequest $req): RedirectResponse
    {
        $medicine_unit = new MedicineUnit();
        $medicine_unit->name = $req->name;
        $medicine_unit->quantity = $req->quantity;
        $medicine_unit->created_by = admin()->id;
        $medicine_unit->save();
        flash()->addSuccess('Medici generic name ' . $medicine_unit->name . ' created successfully.');
        return redirect()->route('product.medicine_unit.medicine_unit_list');
    }
    public function edit($id): View
    {
        $data['medicine_unit'] = MedicineUnit::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'medicine_unit')->first();
        return view('admin.product_management.medicine_unit.edit', $data);
    }
    public function update(MedicineUnitRequest $req, $id): RedirectResponse
    {
        $medicine_unit = MedicineUnit::findOrFail($id);
        $medicine_unit->name = $req->name;
        $medicine_unit->quantity = $req->quantity;
        $medicine_unit->updated_by = admin()->id;
        $medicine_unit->update();
        flash()->addSuccess('Medici generic name ' . $medicine_unit->name . ' updated successfully.');
        return redirect()->route('product.medicine_unit.medicine_unit_list');
    }
    public function status($id): RedirectResponse
    {
        $medicine_unit = MedicineUnit::findOrFail($id);
        $this->statusChange($medicine_unit);
        flash()->addSuccess('Medicine unit ' . $medicine_unit->name . ' status updated successfully.');
        return redirect()->route('product.medicine_unit.medicine_unit_list');
    }
    public function delete($id): RedirectResponse
    {
        $medicine_unit = MedicineUnit::findOrFail($id);
        $medicine_unit->delete();
        flash()->addSuccess('Medici generic name ' . $medicine_unit->name . ' deleted successfully.');
        return redirect()->route('product.medicine_unit.medicine_unit_list');
    }
}
