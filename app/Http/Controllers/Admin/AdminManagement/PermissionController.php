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
use App\Http\Traits\DetailsCommonDataTrait;



class PermissionController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['permissions'] = Permission::with(['created_user', 'updated_user'])->orderBy('prefix')->get();
        return view('admin.admin_management.permission.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Permission::findOrFail($id);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create()
    {
        $data['document'] = Documentation::where('module_key', 'permission')->first();
        return view('admin.admin_management.permission.create', $data);
    }

    public function store(PermissionRequest $req): RedirectResponse
    {
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->guard_name = 'admin';
        $permission->created_by = admin()->id;
        $permission->save();
        flash()->addSuccess("$permission->name permission created successfully");
        return redirect()->route('am.permission.permission_list');
    }
    public function edit($id): View
    {
        $data['permission'] = Permission::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'permission')->first();
        return view('admin.admin_management.permission.edit', $data);
    }
    public function update(PermissionRequest $req, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->guard_name = 'admin';
        $permission->updated_by = admin()->id;
        $permission->update();
        flash()->addSuccess("$permission->name permission updated successfully");
        return redirect()->route('am.permission.permission_list');
    }
}
