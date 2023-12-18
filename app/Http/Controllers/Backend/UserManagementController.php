<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;

class UserManagementController extends Controller
{
    // User Methods 
    public function index(): View
    {
        $s['users'] = User::with(['role','createdBy'])->where('deleted_at',null)->get();
        return view('backend.user_management.user.index',$s);
    }
    public function details($id): JsonResponse
    {
        $user = User::with('role')->where('id',$id)->where('deleted_at',null)->first();
        $user['created_date'] = date('d M, Y', strtotime($user->created_at));
        $user['updated_date'] = ($user->updated_at != $user->created_at) ? (date('d M, Y', strtotime($user->updated_at))) : 'N/A';
        $user['created_user'] = $user->created_by ? $user->createdBy->name : 'System';
        $user['updated_user'] = $user->updated_by ? $user->updatedBy->name : 'N/A';
        $s['user'] = $user;
        return response()->json($s);
    }
    public function create(): View
    {
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.create',$s);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->role_id = $req->role;
        $user->password = Hash::make($req->password);
        $user->created_by = auth()->user()->id;
        $user->save();

        $user->assignRole($user->role->name);

        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' created successfully.'));
    }
    public function edit($id): View
    {
        $s['user'] = User::findOrFail($id);
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.edit',$s);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->role_id = $req->role;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
        $user->updated_by = auth()->user()->id;
        $user->update();

        $user->assignRole($user->role->name);
        
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' updated successfully.'));
    }
    public function status($id): RedirectResponse
    {
        $user = user::findOrFail($id);
        $this->statusChange($user);
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' status updated successfully.'));
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' deleted successfully.'));

    }


     // Permission Methods PermissionRequest
     public function p_index(): View
     {
        $s['permissions'] = Permission::orderBy('prefix')->get();
        return view('backend.user_management.permission.index',$s);
    }
    public function p_details($id): JsonResponse
    {
        $permission = Permission::where('id',$id)->where('deleted_at',null)->first();
        $permission['created_date'] = date('d M, Y', strtotime($permission->created_at));
        $permission['updated_date'] = ($permission->updated_at != $permission->created_at) ? (date('d M, Y', strtotime($permission->updated_at))) : 'N/A';
        $permission['created_user'] = $permission->created_by ? $permission->createdBy->name : 'System';
        $permission['updated_user'] = $permission->updated_by ? $permission->updatedBy->name : 'N/A';
        $s['permission'] = $permission;
        return response()->json($s);
    }
    public function p_create(){
        return view('backend.user_management.permission.create');
    }

    public function p_store(PermissionRequest $req): RedirectResponse
    {
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->created_by = auth()->user()->id;
        $permission->save();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission created successfully"));     
    }
    public function p_edit($id): View
    {
        $s['permission'] = Permission::findOrFail($id);
        return view('backend.user_management.permission.edit',$s);
    }
    public function p_update(PermissionRequest $req, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
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
        return view('backend.user_management.role.index', $s);
    }
    public function r_details($id): JsonResponse
    {
        $role = Role::where('id',$id)->where('deleted_at',null)->first();
        $role['created_date'] = date('d M, Y', strtotime($role->created_at));
        $role['updated_date'] = ($role->updated_at != $role->created_at) ? (date('d M, Y', strtotime($role->updated_at))) : 'N/A';
        $role['created_user'] = $role->created_by ? $role->createdBy->name : 'System';
        $role['updated_user'] = $role->updated_by ? $role->updatedBy->name : 'N/A';
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
        return view('backend.user_management.role.create',$s);
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
        return view('backend.user_management.role.edit',$s);
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
