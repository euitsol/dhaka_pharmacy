<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineUnitRequest;
use App\Models\Documentation;
use App\Models\MedicineUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class MedicineUnitController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicine_units'] = MedicineUnit::with('created_user')->orderBy('name')->get();
        return view('admin.product_management.medicine_unit.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = MedicineUnit::with(['created_user', 'updated_user'])->findOrFail($id);
        $data->image = storage_url($data->image);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'medicine_unit'], ['type', 'create']])->first();
        return view('admin.product_management.medicine_unit.create', $data);
    }
    public function store(MedicineUnitRequest $req): RedirectResponse
    {
        $medicine_unit = new MedicineUnit();
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'medicine_units/images';
            $path = $image->storeAs($folderName, $imageName, 'public');
            $medicine_unit->image = $path;
        }
        $medicine_unit->type = $req->type;
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
        $data['document'] = Documentation::where([['module_key', 'medicine_unit'], ['type', 'update']])->first();
        return view('admin.product_management.medicine_unit.edit', $data);
    }
    public function update(MedicineUnitRequest $req, $id): RedirectResponse
    {
        $medicine_unit = MedicineUnit::findOrFail($id);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'products/images';
            $path = $image->storeAs($folderName, $imageName, 'public');
            if (!empty($medicine_unit->image)) {
                $this->fileDelete($medicine_unit->image);
            }
            $medicine_unit->image = $path;
        }

        $medicine_unit->type = $req->type;
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
