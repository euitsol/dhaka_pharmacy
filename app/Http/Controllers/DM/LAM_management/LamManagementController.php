<?php

namespace App\Http\Controllers\DM\LAM_management;

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


class LamManagementController extends Controller
{
    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function index(): View
    {
        $data['lams'] = LocalAreaManager::with(['dm', 'created_user'])->where('dm_id', dm()->id)->latest()->get();
        return view('district_manager.lam_management.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = LocalAreaManager::with('dm')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }

    public function profile($id): View
    {
        $data['lam'] = LocalAreaManager::with(['created_user', 'updated_user'])->findOrFail($id);
        return view('district_manager.lam_management.profile', $data);
    }


    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'local_area_manager')->first();
        return view('district_manager.lam_management.create', $data);
    }
    public function store(LocalAreaManagerRequest $req): RedirectResponse
    {
        $lam = new LocalAreaManager();
        $lam->name = $req->name;
        $lam->email = $req->email;
        $lam->dm_id = $req->dm_id;
        $lam->password = Hash::make($req->password);
        $lam->created_by = admin()->id;
        $lam->save();
        flash()->addSuccess('Local Area Manager ' . $lam->name . ' created successfully.');
        return redirect()->route('district_manager.lam_management.list');
    }
    public function edit($id): View
    {
        $data['lam'] = LocalAreaManager::findOrFail($id);
        $data['dms'] = DistrictManager::latest()->get();
        $data['document'] = Documentation::where('module_key', 'local_area_manager')->first();
        return view('district_manager.lam_management.edit', $data);
    }
    public function update(LocalAreaManagerRequest $req, $id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->name = $req->name;
        $lam->email = $req->email;
        $lam->dm_id = $req->dm_id;
        if ($req->password) {
            $lam->password = Hash::make($req->password);
        }
        $lam->updated_by = admin()->id;
        $lam->update();

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' updated successfully.');
        return redirect()->route('district_manager.lam_management.list');
    }
    public function status($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $this->statusChange($lam);

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' status updated successfully.');
        return redirect()->route('district_manager.lam_management.list');
    }
    public function delete($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->delete();

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' deleted successfully.');
        return redirect()->route('district_manager.lam_management.list');
    }
}
