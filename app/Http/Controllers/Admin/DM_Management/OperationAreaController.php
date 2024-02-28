<?php

namespace App\Http\Controllers\Admin\DM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationAreaRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class OperationAreaController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): view
    {
        $data['operation_area'] = OperationArea::with(['created_used', 'updated_user'])->orderBy('name')->get();
        return view('admin.dm_management.operation_area.index', $data);
    }

    public function details($id): JsonResponse
    {
        $data = OperationArea::with('role')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): view
    {
        $data['document'] = Documentation::where('module_key', 'operation_area')->first();
        return view('admin.dm_management.operation_area.create', $data);
    }
    public function store(OperationArea $req): RedirectResponse
    {
        $operation_area_name = new OperationArea();
        $operation_area_name->name = $req->name;
        $operation_area_name->slug = $req->slug;
        $operation_area_name->created_by = admin()->id;
        $operation_area_name->save();
        flash()->addSuccess('Opeation area ' . $operation_area_name->name . ' created successfully. ');
        return redirect()->route('product. operation_area_name.operation_area_list');
    }
    public function edit($slug): view
    {
        $data['operation_area_name'] = OperationArea::where('slug', $slug)->first();
        $data['document'] = Documentation::where('operation-area', 'operation_area_name_edit', $data);
        return view('admin.dm_management.operation_area.edit', $data);
    }
    public function update(OperationAreaRequest $req, $id): RedirectResponse
    {
        $operation_area_name = OperationArea::findorFail($id);
        $operation_area_name->name = $req->name;
        $operation_area_name->slug = $req->slug;
        $operation_area_name->updated_by = admin()->id;
        $operation_area_name->update();
        flash()->addSuccess('operation area name ' . $operation_area_name->name . ' Updated Successfully ');
        return redirect()->route('product.operation_area_name.operation_area_list');
    }
    public function status($id): RedirectResponse
    {
        $operation_area_name = OperationArea::findOrFail($id);
        $this->statusChange($operation_area_name);
        flash()->addSuccess('Operation Area ' . $operation_area_name->name . ' status updated successfully.');
        return redirect()->route('product.$operation_area_name.$operation_area_list');
    }

    public function delete($id): RedirectResponse
    {
        $operation_area_name = OperationArea::findOrFail($id);
        $operation_area_name->delete();
        flash()->addSuccess('Opearation area name ' . $operation_area_name->name . ' deleted successfully.');
        return redirect()->route('product.$operation_area_name.$operation_area_name_list');
    }
}
