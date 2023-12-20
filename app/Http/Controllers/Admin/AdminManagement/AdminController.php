<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class AdminController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $s['admins'] = Admin::with(['role','created_user'])->where('deleted_at',null)->get();
        return view('admin.admin_management.admin.index',$s);
    }
    public function details($id): JsonResponse
    {
        $data = Admin::with('role')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('admin.admin_management.admin.create',$s);
    }
    public function store(AdminRequest $req): RedirectResponse
    {
        $admin = new Admin();
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        $admin->password = Hash::make($req->password);
        $admin->created_by = admin()->id;
        $admin->save();

        $admin->assignRole($admin->role->name);

        return redirect()->route('am.admin.admin_list')->withStatus(__('Admin '.$admin->name.' created successfully.'));
    }
    public function edit($id): View
    {
        $s['admin'] = Admin::findOrFail($id);
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('admin.admin_management.admin.edit',$s);
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
        $admin->updated_by = admin()->id;
        $admin->update();

        $admin->syncRoles($admin->role->name);

        return redirect()->route('am.admin.admin_list')->withStatus(__('Admin '.$admin->name.' updated successfully.'));
    }
    public function status($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $this->statusChange($admin);
        return redirect()->route('am.admin.admin_list')->withStatus(__('Admin '.$admin->name.' status updated successfully.'));
    }
    public function delete($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('am.admin.admin_list')->withStatus(__('Admin '.$admin->name.' deleted successfully.'));

    }


}
