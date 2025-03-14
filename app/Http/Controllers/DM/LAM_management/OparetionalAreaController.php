<?php

namespace App\Http\Controllers\DM\LAM_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationSubAreaRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class OparetionalAreaController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function index(): View
    {
        $data['operational_areas'] = OperationArea::with(['operation_sub_areas', 'creater'])->activated()->orderBy('name')->get();
        return view('district_manager.lam_management.operational_areas.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = OperationSubArea::with('operation_area')->findOrFail($id);
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'operation_sub_area'], ['type', 'create']])->first();
        return view('district_manager.lam_management.operational_areas.create', $data);
    }
    public function store(OperationSubAreaRequest $req): RedirectResponse
    {
        $lam_area = new OperationSubArea();
        $lam_area->name = $req->name;
        $lam_area->slug = $req->slug;
        $lam_area->oa_id = $req->oa_id;
        $lam_area->status = 0;
        $lam_area->creater()->associate(dm());
        $lam_area->save();
        flash()->addSuccess('Operation sub area ' . $lam_area->name . ' create request submitted successfully.');
        return redirect()->route('dm.lam_area.list');
    }
    public function edit($slug): View
    {
        $data['lam_area'] = OperationSubArea::where('slug', $slug)->first();
        $data['document'] = Documentation::where([['module_key', 'operation_sub_area'], ['type', 'update']])->first();
        return view('district_manager.lam_management.operational_areas.edit', $data);
    }
    public function update(OperationSubAreaRequest $req, $id): RedirectResponse
    {
        $lam_area = OperationSubArea::findOrFail($id);
        $lam_area->name = $req->name;
        $lam_area->slug = $req->slug;
        $lam_area->oa_id = $req->oa_id;
        $lam_area->status = 0;
        $lam_area->updater()->associate(dm());
        $lam_area->update();
        flash()->addSuccess('Operation sub area ' . $lam_area->name . ' update request submitted successfully.');
        return redirect()->route('dm.lam_area.list');
    }
}
