<?php

namespace App\Http\Controllers\Admin\OperationalArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationAreaRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class OperationAreaController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): view
    {
        $data['operation_areas'] = OperationArea::with(['created_user', 'updated_user'])->orderBy('name')->get();
        return view('admin.operational_area.operation_area.index', $data);
    }

    public function details($id): JsonResponse
    {
        $data = OperationArea::findOrFail($id);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): view
    {
        $data['document'] = Documentation::where('module_key', 'operation-area')->first();
        return view('admin.operational_area.operation_area.create', $data);
    }
    public function store(OperationAreaRequest $req): RedirectResponse
    {
        $operation_area = new OperationArea();
        $operation_area->name = $req->name;
        $operation_area->slug = $req->slug;
        $operation_area->created_by = admin()->id;
        $operation_area->save();
        flash()->addSuccess('Opeation area ' . $operation_area->name . ' created successfully. ');
        return redirect()->route('opa.operation_area.operation_area_list');
    }
    public function edit($slug): view
    {
        $data['operation_area'] = OperationArea::where('slug', $slug)->first();
        $data['document'] = Documentation::where('module_key', 'operation-area')->first();
        return view('admin.operational_area.operation_area.edit', $data);
    }
    public function update(OperationAreaRequest $req, $id): RedirectResponse
    {
        $operation_area = OperationArea::findorFail($id);
        $operation_area->name = $req->name;
        $operation_area->slug = $req->slug;
        $operation_area->updated_by = admin()->id;
        $operation_area->update();
        flash()->addSuccess('Operation Area ' . $operation_area->name . ' Updated Successfully ');
        return redirect()->route('opa.operation_area.operation_area_list');
    }
    public function status($id): RedirectResponse
    {
        $operation_area = OperationArea::findOrFail($id);
        $this->statusChange($operation_area);
        flash()->addSuccess('Operation Area ' . $operation_area->name . ' status updated successfully.');
        return redirect()->route('opa.operation_area.operation_area_list');
    }

    public function delete($id): RedirectResponse
    {
        $operation_area = OperationArea::findOrFail($id);
        $operation_area->delete();
        flash()->addSuccess('Operation Area ' . $operation_area->name . ' deleted successfully.');
        return redirect()->route('opa.operation_area.operation_area_list');
    }
}
