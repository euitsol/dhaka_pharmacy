<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineDosesRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
use App\Models\MedicineDose;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MedicineDosesController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['medicine_doses'] = MedicineDose::with('created_user')->orderBy('name')->get();
        return view('admin.product_management.medicine_doses.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = MedicineDose::findOrFail($id);
        $data->image = storage_url($data->icon);
        $data->description = html_entity_decode($data->description);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'medicine_dose'], ['type', 'create']])->first();
        return view('admin.product_management.medicine_doses.create', $data);
    }
    public function store(MedicineDosesRequest $req): RedirectResponse
    {
        dd($req->all());
        $medicine_dose = new MedicineDose();

        if ($req->hasFile('icon')) {
            $icon = $req->file('icon');
            $iconName = $req->slug . '_' . time() . '.' . $icon->getClientOriginalExtension();
            $folderName = 'medicine_doses';
            $path = $icon->storeAs($folderName, $iconName, 'public');
            $medicine_dose->icon = $path;
        }

        $medicine_dose->name = $req->name;
        $medicine_dose->slug = $req->slug;
        $medicine_dose->description = $req->description;
        $medicine_dose->created_by = admin()->id;
        $medicine_dose->save();
        flash()->addSuccess('Medicine dose ' . $medicine_dose->name . ' created successfully.');
        return redirect()->route('product.medicine_dose.medicine_dose_list');
    }
    public function edit($slug): View
    {
        $data['medicine_dose'] = MedicineDose::where('slug', $slug)->first();
        $data['document'] = Documentation::where([['module_key', 'medicine_dose'], ['type', 'update']])->first();
        return view('admin.product_management.medicine_doses.edit', $data);
    }
    public function update(MedicineDosesRequest $req, $id): RedirectResponse
    {
        $medicine_dose = MedicineDose::findOrFail($id);
        if ($req->hasFile('icon')) {
            $icon = $req->file('icon');
            $iconName = $req->slug . '_' . time() . '.' . $icon->getClientOriginalExtension();
            $folderName = 'medicine_dose';
            $path = $icon->storeAs($folderName, $iconName, 'public');
            if (!empty($medicine_dose->icon)) {
                $this->fileDelete($medicine_dose->icon);
            }
            $medicine_dose->icon = $path;
        }
        $medicine_dose->name = $req->name;
        $medicine_dose->slug = $req->slug;
        $medicine_dose->description = $req->description;
        $medicine_dose->updated_by = admin()->id;
        $medicine_dose->update();
        flash()->addSuccess('Medicine dose ' . $medicine_dose->name . ' updated successfully.');
        return redirect()->route('product.medicine_dose.medicine_dose_list');
    }

    public function status($id): RedirectResponse
    {
        $medicine_dose = MedicineDose::findOrFail($id);
        $this->statusChange($medicine_dose);
        flash()->addSuccess('Medicine dose ' . $medicine_dose->name . ' status updated successfully.');
        return redirect()->route('product.medicine_dose.medicine_dose_list');
    }

    public function delete($id): RedirectResponse
    {
        $medicine_dose = MedicineDose::findOrFail($id);
        $medicine_dose->deleter()->associate(admin());
        $medicine_dose->delete();
        flash()->addSuccess('Medicine dose ' . $medicine_dose->name . ' deleted successfully.');
        return redirect()->route('product.medicine_dose.medicine_dose_list');
    }
}
