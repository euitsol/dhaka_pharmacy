<?php

namespace App\Http\Controllers\DM\LAM_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationSubAreaRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OparetionalAreaController extends Controller
{
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
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = timeFormate($data->updated_at);
        $data->created_by = c_user_name($data->creater);
        $data->updated_by = u_user_name($data->updater);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'operation-sub-area')->first();
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
        flash()->addSuccess('Operation Sub Area ' . $lam_area->name . ' created successfully.');
        return redirect()->route('dm.lam_area.list');
    }
    public function edit($slug): View
    {
        $data['lam_area'] = OperationSubArea::where('slug',$slug)->first();
        $data['document'] = Documentation::where('module_key', 'operation-sub-area')->first();
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
        flash()->addSuccess('Operation Sub Area ' . $lam_area->name . ' updated successfully.');
        return redirect()->route('dm.lam_area.list');
    }
    
}
