<?php

namespace App\Http\Controllers\Admin\OperationalArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationSubAreaRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class OperationSubAreaController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['op_sub_areas'] = OperationSubArea::with(['operation_area', 'creater'])->orderBy('name')->get();
        return view('admin.operational_area.operation_sub_area.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = OperationSubArea::with('operation_area')->findOrFail($id);
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['op_areas'] = OperationArea::activated()->latest()->get();
        $data['document'] = Documentation::where('module_key', 'operation-sub-area')->first();
        return view('admin.operational_area.operation_sub_area.create', $data);
    }
    public function store(OperationSubAreaRequest $req): RedirectResponse
    {
        $operation_sub_area = new OperationSubArea();
        $operation_sub_area->name = $req->name;
        $operation_sub_area->slug = $req->slug;
        $operation_sub_area->oa_id = $req->oa_id;
        $operation_sub_area->creater()->associate(admin());
        $operation_sub_area->save();
        flash()->addSuccess('Operation Sub Area ' . $operation_sub_area->name . ' created successfully.');
        return redirect()->route('opa.operation_sub_area.operation_sub_area_list');
    }
    public function edit($slug): View
    {
        $data['operation_sub_area'] = OperationSubArea::where('slug', $slug)->first();
        $data['operation_areas'] = OperationArea::activated()->latest()->get();
        $data['document'] = Documentation::where('module_key', 'operation-sub-area')->first();
        return view('admin.operational_area.operation_sub_area.edit', $data);
    }
    public function update(OperationSubAreaRequest $req, $id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::findOrFail($id);
        $operation_sub_area->name = $req->name;
        $operation_sub_area->slug = $req->slug;
        $operation_sub_area->oa_id = $req->oa_id;
        $operation_sub_area->updater()->associate(admin());
        $operation_sub_area->update();
        flash()->addSuccess('Operation Sub Area ' . $operation_sub_area->name . ' updated successfully.');
        return redirect()->route('opa.operation_sub_area.operation_sub_area_list');
    }

    public function status($id, $status): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::findOrFail($id);
        if ($status == 'accept') {
            $operation_sub_area->status = '1';
            $operation_sub_area->save();
            flash()->addSuccess('Operation Sub Area ' . $operation_sub_area->name . ' accepted successfully.');
        } elseif ($status == 'declined') {
            $operation_sub_area->status = '-1';
            $operation_sub_area->save();
            flash()->addSuccess('Operation Sub Area ' . $operation_sub_area->name . ' declined successfully.');
        }
        return redirect()->route('opa.operation_sub_area.operation_sub_area_list');
    }
    public function delete($id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::findOrFail($id);
        $operation_sub_area->delete();
        flash()->addSuccess('Operation Sub Area ' . $operation_sub_area->name . ' deleted successfully.');
        return redirect()->route('opa.operation_sub_area.operation_sub_area_list');
    }
}
