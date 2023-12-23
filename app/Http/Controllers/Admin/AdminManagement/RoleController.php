<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class RoleController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }
    public function index(): View
    {
        $s['roles'] = Role::with('permissions')->latest()->get()
        ->map(function($role){
            $permissionNames = $role->permissions->pluck('name')->implode(' | ');
            $role->permissionNames = $permissionNames;
            return $role;
        });
        return view('admin.admin_management.role.index', $s);
    }
    public function details($id): JsonResponse
    {
        $data = Permission::findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        $data->permissionNames = $data->permissions->pluck('name')->implode(' | ');
        return response()->json($data);
    }
    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('admin.admin_management.role.create',$s);
    }
    public function store(RoleRequest $req): RedirectResponse
    {
        $role = new Role();
        $role->name = $req->name;
        $role->created_by = admin()->id;
        $role->save();

        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
        return redirect()->route('am.role.role_list')->withStatus(__("$role->name role created successfully"));


    }
    public function edit($id): View
    {
        $s['role'] = Role::findOrFail($id);
        $s['permissions'] = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $s['permissions']->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('admin.admin_management.role.edit',$s);
    }

    public function update(RoleRequest $req, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->name = $req->name;
        $role->updated_by = admin()->id;
        $role->save();
        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('am.role.role_list')->withStatus(__($role->name.' role updated successfully.'));
    }

    public function delete($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('am.role.role_list')->withStatus(__($role->name.' role deleted successfully.'));
    }
}
