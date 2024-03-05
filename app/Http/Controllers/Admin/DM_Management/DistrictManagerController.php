<?php

namespace App\Http\Controllers\Admin\DM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\DistrictManager;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class DistrictManagerController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['dms'] = DistrictManager::with(['lams','operation_area','created_user'])->latest()->get();
        return view('admin.dm_management.district_manager.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = DistrictManager::with('operation_area')->findOrFail($id);
        $data->total_lams = count($data->lams);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->created_user_name();
        $data->updated_by = $data->updated_user_name();
        return response()->json($data);
    }

    public function loginAs($id)
    {
        $user = DistrictManager::findOrFail($id);
        if ($user) {
            Auth::guard('dm')->login($user);
            return redirect()->route('dm.dashboard');
        } else {
            flash()->addError('User not found');
            return redirect()->back();
        }
    }



    
    public function profile($id): View
    {
        $data['dm'] = DistrictManager::with(['lams','operation_area','created_user','updated_user'])->findOrFail($id);
        return view('admin.dm_management.district_manager.profile',$data);
    }
    public function create(): View
    {
        $data['operation_areas'] = OperationArea::activeted()->orderBy('name')->get();
        $data['document'] = Documentation::where('module_key','district_manager')->first();
        return view('admin.dm_management.district_manager.create',$data);
    }
    public function store(DistrictManagerRequest $req): RedirectResponse
    {
        $dm = new DistrictManager();
        $dm->name = $req->name;
        $dm->phone = $req->phone;
        $dm->oa_id = $req->oa_id;
        $dm->password = Hash::make($req->password);
        $dm->created_by = admin()->id;
        $dm->save();
        flash()->addSuccess('District Manager '.$dm->name.' created successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
    }
    public function edit($id): View
    {
        $data['dm'] = DistrictManager::findOrFail($id);
        $data['operation_areas'] = OperationArea::activeted()->orderBy('name')->get();
        $data['document'] = Documentation::where('module_key','district_manager')->first();
        return view('admin.dm_management.district_manager.edit',$data);
    }
    public function update(DistrictManagerRequest $req, $id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $dm->name = $req->name;
        $dm->phone = $req->phone;
        $dm->oa_id = $req->oa_id;
        if($req->password){
            $dm->password = Hash::make($req->password);
        }
        $dm->updated_by = admin()->id;
        $dm->update();
        flash()->addSuccess('District Manager '.$dm->name.' updated successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
    }
    public function status($id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $this->statusChange($dm);
        flash()->addSuccess('District Manager '.$dm->name.' status updated successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
    }
    public function delete($id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $dm->delete();
        flash()->addSuccess('District Manager '.$dm->name.' deleted successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');

    }


}
