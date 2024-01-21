<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Documentation;
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
        $data['admins'] = Admin::with(['role','created_user'])->latest()->get();
        return view('admin.admin_management.admin.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = Admin::with('role')->findOrFail($id);
        $ipsArray = json_decode($data->ip, true);
        if(is_array($ipsArray)){
            $ips = implode(' | ', $ipsArray);
            $data->ips = $ips;
        }else{
            $data->ips = '';
        }
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['admin'] = Admin::with(['role','created_user','updated_user'])->findOrFail($id);
        return view('admin.admin_management.admin.profile',$data);
    }
    public function create(): View
    {
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key','admin')->first();
        return view('admin.admin_management.admin.create',$data);
    }
    public function store(AdminRequest $req): RedirectResponse
    {
        $admin = new Admin();
        $admin->name = $req->name;
        $admin->ip = json_encode($req->ip);
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        $admin->password = Hash::make($req->password);
        $admin->created_by = admin()->id;
        $admin->save();

        $admin->assignRole($admin->role->name);

        flash()->addSuccess('Admin '.$admin->name.' created successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function edit($id): View
    {
        $data['admin'] = Admin::findOrFail($id);
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key','admin')->first();
        return view('admin.admin_management.admin.edit',$data);
    }
    public function update(AdminRequest $req, $id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->name = $req->name;
        $admin->ip = json_encode($req->ip);
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        if($req->password){
            $admin->password = Hash::make($req->password);
        }
        $admin->updated_by = admin()->id;
        $admin->update();

        $admin->syncRoles($admin->role->name);

        flash()->addSuccess('Admin '.$admin->name.' updated successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function status($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $this->statusChange($admin);
        flash()->addSuccess('Admin '.$admin->name.' status updated successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function delete($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        flash()->addSuccess('Admin '.$admin->name.' deleted successfully.');
        return redirect()->route('am.admin.admin_list');

    }


}
