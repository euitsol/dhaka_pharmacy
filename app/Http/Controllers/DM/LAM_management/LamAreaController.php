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


class LamAreaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function index(): View
    {
        $data['lam_areas'] = OperationSubArea::with(['operation_area', 'creater'])->where('oa_id',dm()->oa_id)->orderBy('name')->get();
        return view('district_manager.lam_management.lam_area.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = OperationSubArea::with('operation_area')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->creater->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updater->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'operation-sub-area')->first();
        return view('district_manager.lam_management.lam_area.create', $data);
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
        flash()->addSuccess('Operation sub area ' . $lam_area->name . ' created successfully.');
        return redirect()->route('dm.lam_area.list');
    }
    public function edit($slug): View
    {
        $data['lam_area'] = OperationSubArea::where('slug',$slug)->first();
        $data['document'] = Documentation::where('module_key', 'operation-sub-area')->first();
        return view('district_manager.lam_management.lam_area.edit', $data);
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
        flash()->addSuccess('Operation sub area ' . $lam_area->name . ' updated successfully.');
        return redirect()->route('dm.lam_area.list');
    }
    
}
