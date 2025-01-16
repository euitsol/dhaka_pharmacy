<?php

namespace App\Http\Controllers\Admin\LAM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocalAreaManagerRequest;
use App\Models\DistrictManager;
use App\Models\Documentation;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Earning;
use App\Models\KycSetting;
use App\Models\SubmittedKyc;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class LocalAreaManagerController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['lams'] = LocalAreaManager::with(['dm.operation_area', 'operation_sub_area', 'creater'])
            ->latest()
            ->get();
        return view('admin.lam_management.local_area_manager.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = LocalAreaManager::with(['dm.operation_area', 'creater', 'operation_sub_area', 'updater'])->findOrFail($id);
        $data->getGender = $data->getGender() ?? null;
        $data->identificationType = $data->identificationType();
        $data->cv = !empty($data->cv) ? route("lam_management.local_area_manager.download.local_area_manager_profile", base64_encode($data->cv)) : null;
        $this->morphColumnData($data);
        $data->image = auth_storage_url($data->image, $data->gender);
        return response()->json($data);
    }

    public function loginAs($id)
    {
        $user = LocalAreaManager::findOrFail($id);
        if ($user) {
            Auth::guard('lam')->login($user);
            return redirect()->route('lam.dashboard');
        } else {
            flash()->addError('User not found');
            return redirect()->back();
        }
    }

    public function profile($id): View
    {
        $data['lam'] = LocalAreaManager::with(['creater', 'operation_sub_area', 'updater'])->findOrFail($id);
        $lam_class = get_class($data['lam']);
        $data['submitted_kyc'] = SubmittedKyc::with('kyc')->where('creater_id', $id)->where('creater_type', $lam_class)->first();
        $data['users'] = User::where('creater_id', $id)->where('creater_type', $lam_class)->latest()->get();
        $data['earnings'] = Earning::with(['receiver', 'point_history', 'withdraw_earning.withdraw.withdraw_method'])
            ->where('receiver_id', $id)->where('receiver_type', $lam_class)->get();
        $data['point_name'] = getPointName();
        return view('admin.lam_management.local_area_manager.profile', $data);
    }


    public function create(): View
    {
        $data['dms'] = DistrictManager::latest()->get();
        $data['document'] = Documentation::where([['module_key', 'lam'], ['type', 'create']])->first();
        return view('admin.lam_management.local_area_manager.create', $data);
    }
    public function store(LocalAreaManagerRequest $req): RedirectResponse
    {
        $lam = new LocalAreaManager();
        $lam->name = $req->name;
        $lam->phone = $req->phone;
        $lam->dm_id = $req->dm_id;
        $lam->osa_id = $req->osa_id;
        $lam->password = Hash::make($req->password);
        $lam->creater()->associate(admin());
        $lam->save();
        flash()->addSuccess('Local Area Manager ' . $lam->name . ' created successfully.');
        return redirect()->route('lam_management.local_area_manager.local_area_manager_list');
    }
    public function edit($id): View
    {
        $data['lam'] = LocalAreaManager::findOrFail($id);
        $data['dms'] = DistrictManager::latest()->get();
        $data['document'] = Documentation::where([['module_key', 'lam'], ['type', 'update']])->first();
        return view('admin.lam_management.local_area_manager.edit', $data);
    }
    public function update(LocalAreaManagerRequest $req, $id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->name = $req->name;
        $lam->phone = $req->phone;
        $lam->dm_id = $req->dm_id;
        $lam->osa_id = $req->osa_id;
        if ($req->password) {
            $lam->password = Hash::make($req->password);
        }
        $lam->updater()->associate(admin());
        $lam->update();

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' updated successfully.');
        return redirect()->route('lam_management.local_area_manager.local_area_manager_list');
    }
    public function status($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $this->statusChange($lam);

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' status updated successfully.');
        return redirect()->route('lam_management.local_area_manager.local_area_manager_list');
    }
    public function delete($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->delete();

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' deleted successfully.');
        return redirect()->route('lam_management.local_area_manager.local_area_manager_list');
    }



    public function get_operation_area($dm_id): JsonResponse
    {
        $data['dm'] = DistrictManager::with('operation_area.operation_sub_areas')->findOrFail($dm_id);
        $data['operation_sub_areas'] = $data['dm']->operation_area->operation_sub_areas->filter(function ($sub_area) {
            return $sub_area->status == 1;
        });
        return response()->json($data);
    }
    public function view_or_download($file_url)
    {
        $file_url = base64_decode($file_url);
        if (Storage::exists('public/' . $file_url)) {
            $fileExtension = pathinfo($file_url, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) === 'pdf') {
                return response()->file(storage_path('app/public/' . $file_url), [
                    'Content-Disposition' => 'inline; filename="' . basename($file_url) . '"'
                ]);
            } else {
                return response()->download(storage_path('app/public/' . $file_url), basename($file_url));
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
