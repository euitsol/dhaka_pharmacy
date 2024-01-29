<?php

namespace App\Http\Controllers\Admin\DM_LAM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocalAreaManagerRequest;
use App\Models\DistrictManager;
use App\Models\Documentation;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class LocalAreaManagerController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['lams'] = LocalAreaManager::with(['dm','creater'])->latest()->get();
        return view('admin.dm_lam_management.local_area_manager.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = LocalAreaManager::with('dm')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->creater_id ? $data->creater->name : 'System';
        $data->updated_by = $data->updater_id ? $data->updater->name : 'N/A';
        return response()->json($data);
    }

    public function profile($id): View
    {
        $data['lam'] = LocalAreaManager::with(['creater','updater'])->findOrFail($id);
        return view('admin.dm_lam_management.local_area_manager.profile',$data);
    }


    public function create(): View
    {
        $data['dms'] = DistrictManager::latest()->get();
        $data['document'] = Documentation::where('module_key','local_area_manager')->first();
        return view('admin.dm_lam_management.local_area_manager.create',$data);
    }
    public function store(LocalAreaManagerRequest $req): RedirectResponse
    {
        $lam = new LocalAreaManager();
        $lam->name = $req->name;
        $lam->phone = $req->phone;
        $lam->dm_id = $req->dm_id;
        $lam->password = Hash::make($req->password);
        $lam->creater()->associate(admin());
        $lam->save();
        flash()->addSuccess('Local Area Manager '.$lam->name.' created successfully.');
        return redirect()->route('dmlam.local_area_manager.local_area_manager_list');
    }
    public function edit($id): View
    {
        $data['lam'] = LocalAreaManager::findOrFail($id);
        $data['dms'] = DistrictManager::latest()->get();
        $data['document'] = Documentation::where('module_key','local_area_manager')->first();
        return view('admin.dm_lam_management.local_area_manager.edit',$data);
    }
    public function update(LocalAreaManagerRequest $req, $id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->name = $req->name;
        $lam->phone = $req->phone;
        $lam->dm_id = $req->dm_id;
        if($req->password){
            $lam->password = Hash::make($req->password);
        }
        $lam->updater()->associate(admin());
        $lam->update();

        flash()->addSuccess('Local Area Manager '.$lam->name.' updated successfully.');
        return redirect()->route('dmlam.local_area_manager.local_area_manager_list');
    }
    public function status($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $this->statusChange($lam);

        flash()->addSuccess('Local Area Manager '.$lam->name.' status updated successfully.');
        return redirect()->route('dmlam.local_area_manager.local_area_manager_list');
    }
    public function delete($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->delete();

        flash()->addSuccess('Local Area Manager '.$lam->name.' deleted successfully.');
        return redirect()->route('dmlam.local_area_manager.local_area_manager_list');

    }


}
