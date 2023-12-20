<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class AdminManagementController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }
    // admin Methods
    public function index(): View
    {
        $s['admins'] = Admin::with(['role','created_admin'])->where('deleted_at',null)->get();
        return view('backend.admin.admin_management.admin.index',$s);
    }
    public function details($id): JsonResponse
    {
        $data = Admin::with('role')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_admin->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_admin->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.admin.admin_management.admin.create',$s);
    }
    public function store(AdminRequest $req): RedirectResponse
    {
        $admin = new Admin();
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        $admin->password = Hash::make($req->password);
        $admin->created_by = auth()->user()->id;
        $admin->save();

        $admin->assignRole($admin->role->name);

        return redirect()->route('um.admin.admin_list')->withStatus(__('Admin '.$admin->name.' created successfully.'));
    }
    public function edit($id): View
    {
        $s['admin'] = Admin::findOrFail($id);
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.admin.admin_management.admin.edit',$s);
    }
    public function update(AdminRequest $req, $id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        if($req->password){
            $admin->password = Hash::make($req->password);
        }
        $admin->updated_by = auth()->user()->id;
        $admin->update();

        $admin->assignRole($admin->role->name);

        return redirect()->route('um.admin.admin_list')->withStatus(__('Admin '.$admin->name.' updated successfully.'));
    }
    public function status($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $this->statusChange($admin);
        return redirect()->route('um.admin.admin_list')->withStatus(__('Admin '.$admin->name.' status updated successfully.'));
    }
    public function delete($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('um.admin.admin_list')->withStatus(__('Admin '.$admin->name.' deleted successfully.'));

    }


     // Permission Methods PermissionRequest
     public function p_index(): View
     {
        $s['permissions'] = Permission::orderBy('prefix')->get();
        return view('backend.admin.admin_management.permission.index',$s);
    }
    public function p_details($id): JsonResponse
    {
        $permission = Permission::where('id',$id)->where('deleted_at',null)->first();
        $permission['created_date'] = date('d M, Y', strtotime($permission->created_at));
        $permission['updated_date'] = ($permission->updated_at != $permission->created_at) ? (date('d M, Y', strtotime($permission->updated_at))) : 'N/A';
        $permission['created_admin'] = $permission->created_by ? $permission->createdBy->name : 'System';
        $permission['updated_admin'] = $permission->updated_by ? $permission->updatedBy->name : 'N/A';
        $s['permission'] = $permission;
        return response()->json($s);
    }
    public function p_create(){
        return view('backend.admin.admin_management.permission.create');
    }

    public function p_store(PermissionRequest $req): RedirectResponse
    {
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->guard_name = 'admin';
        $permission->created_by = auth()->user()->id;
        $permission->save();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission created successfully"));
    }
    public function p_edit($id): View
    {
        $s['permission'] = Permission::findOrFail($id);
        return view('backend.admin.admin_management.permission.edit',$s);
    }
    public function p_update(PermissionRequest $req, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->guard_name = 'admin';
        $permission->updated_by = auth()->user()->id;
        $permission->update();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission updated successfully"));
    }



    // Role Methods
    public function r_index(): View
    {
        $s['roles'] = Role::where('deleted_at', null)->with('permissions')->latest()->get()
        ->map(function($role){
            $permissionNames = $role->permissions->pluck('name')->implode(' | ');
            $role->permissionNames = $permissionNames;
            return $role;
        });
        return view('backend.admin.admin_management.role.index', $s);
    }
    public function r_details($id): JsonResponse
    {
        $role = Role::where('id',$id)->where('deleted_at',null)->first();
        $role['created_date'] = date('d M, Y', strtotime($role->created_at));
        $role['updated_date'] = ($role->updated_at != $role->created_at) ? (date('d M, Y', strtotime($role->updated_at))) : 'N/A';
        $role['created_admin'] = $role->created_by ? $role->createdBy->name : 'System';
        $role['updated_admin'] = $role->updated_by ? $role->updatedBy->name : 'N/A';
        $role['permissionNames'] = $role->permissions->pluck('name')->implode(' | ');
        $s['role'] = $role;
        return response()->json($s);
    }
    public function r_create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.admin.admin_management.role.create',$s);
    }
    public function r_store(RoleRequest $req): RedirectResponse
    {
        $role = new Role();
        $role->name = $req->name;
        $role->created_by = auth()->user()->id;
        $role->save();

        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
        return redirect()->route('um.role.role_list')->withStatus(__("$role->name role created successfully"));


    }
    public function r_edit($id): View
    {
        $s['role'] = Role::findOrFail($id);
        $s['permissions'] = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $s['permissions']->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.admin.admin_management.role.edit',$s);
    }

    public function r_update(RoleRequest $req, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->name = $req->name;
        $role->updated_by = auth()->user()->id;
        $role->save();
        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('um.role.role_list')->withStatus(__($role->name.' role updated successfully.'));
    }

    public function r_delete($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('um.role.role_list')->withStatus(__($role->name.' role deleted successfully.'));
    }
}
