<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Documentation;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PermissionController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
     {
        $data['permissions'] = Permission::orderBy('prefix')->get();
        return view('admin.admin_management.permission.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = Permission::findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(){
        $data['document'] = Documentation::where('module_key','permission')->first();
        return view('admin.admin_management.permission.create',$data);
    }

    public function store(PermissionRequest $req): RedirectResponse
    {
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->guard_name = 'admin';
        $permission->created_by = admin()->id;
        $permission->save();
        return redirect()->route('am.permission.permission_list')->withStatus(__("$permission->name permission created successfully"));
    }
    public function edit($id): View
    {
        $data['permission'] = Permission::findOrFail($id);
        $data['document'] = Documentation::where('module_key','permission')->first();
        return view('admin.admin_management.permission.edit',$data);
    }
    public function update(PermissionRequest $req, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->guard_name = 'admin';
        $permission->updated_by = admin()->id;
        $permission->update();
        return redirect()->route('am.permission.permission_list')->withStatus(__("$permission->name permission updated successfully"));
    }
}
