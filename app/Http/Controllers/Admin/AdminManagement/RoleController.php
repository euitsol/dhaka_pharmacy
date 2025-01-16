<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Documentation;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class RoleController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): View
    {
        $data['roles'] = Role::with(['permissions', 'created_user', 'updated_user'])->latest()->get()
            ->each(function ($role) {
                $permissionNames = $role->permissions->pluck('name')->implode(' | ');
                $role->permissionNames = $permissionNames;
                return $role;
            });
        return view('admin.admin_management.role.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Role::with(['permissions', 'created_user', 'updated_user'])->findOrFail($id);
        $this->simpleColumnData($data);
        $data->permissionNames = $data->permissions->pluck('name')->implode(' | ');
        return response()->json($data);
    }
    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'role'], ['type', 'create']])->first();
        $data['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('admin.admin_management.role.create', $data);
    }
    public function store(RoleRequest $req): RedirectResponse
    {
        $role = new Role();
        $role->name = $req->name;
        $role->created_by = admin()->id;
        $role->save();

        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
        flash()->addSuccess("$role->name role created successfully");
        return redirect()->route('am.role.role_list');
    }
    public function edit($id): View
    {
        $data['role'] = Role::with('permissions')->findOrFail($id);
        $data['permissions'] = Permission::orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'role'], ['type', 'update']])->first();
        $data['groupedPermissions'] = $data['permissions']->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('admin.admin_management.role.edit', $data);
    }

    public function update(RoleRequest $req, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->name = $req->name;
        $role->updated_by = admin()->id;
        $role->save();
        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);
        flash()->addSuccess($role->name . ' role updated successfully.');
        return redirect()->route('am.role.role_list');
    }

    public function delete($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        flash()->addSuccess($role->name . ' role deleted successfully.');
        return redirect()->route('am.role.role_list');
    }
}
