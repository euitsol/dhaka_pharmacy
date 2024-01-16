<?php

namespace App\Http\Controllers\Admin\DM_LAM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\DistrictManager;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class DistrictManagerController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['dms'] = DistrictManager::with('created_user')->latest()->get();
        return view('admin.dm_lam_management.district_manager.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = DistrictManager::findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        return view('admin.dm_lam_management.district_manager.create');
    }
    public function store(DistrictManagerRequest $req): RedirectResponse
    {
        $dm = new DistrictManager();
        $dm->name = $req->name;
        $dm->email = $req->email;
        $dm->password = Hash::make($req->password);
        $dm->created_by = admin()->id;
        $dm->save();
        flash()->addSuccess('Admin '.$dm->name.' created successfully.');
        return redirect()->route('dmlam.district_manager.district_manager_list');
    }
    public function edit($id): View
    {
        $data['dm'] = DistrictManager::findOrFail($id);
        return view('admin.dm_lam_management.district_manager.edit',$data);
    }
    public function update(DistrictManagerRequest $req, $id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $dm->name = $req->name;
        $dm->email = $req->email;
        if($req->password){
            $dm->password = Hash::make($req->password);
        }
        $dm->updated_by = admin()->id;
        $dm->update();
        flash()->addSuccess('Admin '.$dm->name.' updated successfully.');
        return redirect()->route('dmlam.district_manager.district_manager_list');
    }
    public function status($id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $this->statusChange($dm);
        flash()->addSuccess('Admin '.$dm->name.' status updated successfully.');
        return redirect()->route('dmlam.district_manager.district_manager_list');
    }
    public function delete($id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $dm->delete();
        flash()->addSuccess('Admin '.$dm->name.' deleted successfully.');
        return redirect()->route('dmlam.district_manager.district_manager_list');

    }


}
