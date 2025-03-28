<?php

namespace App\Http\Controllers\Admin\DM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictManagerRequest;
use App\Models\DistrictManager;
use App\Models\Documentation;
use App\Models\OperationArea;
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

class DistrictManagerController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['dms'] = DistrictManager::with(['lams', 'operation_area', 'created_user'])->latest()->get();
        return view('admin.dm_management.district_manager.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = DistrictManager::with('operation_area')->findOrFail($id);
        $data->total_lams = count($data->lams);
        $data->getGender = $data->getGender() ?? null;
        $data->identificationType = $data->identificationType() ?? null;
        $data->cv = !empty($data->cv) ? route("dm_management.district_manager.download.district_manager_profile", base64_encode($data->cv)) : null;
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $data->kycVerifyTitle = $data->getKycStatus();
        $data->kycVerifyBg = $data->getKycStatusClass();
        $data->phoneVerifyTitle = $data->getPhoneVerifyStatus();
        $data->phoneVerifyBg = $data->getPhoneVerifyClass();
        $this->simpleColumnData($data);
        $data->image = auth_storage_url($data->image, $data->gender);
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
        $data['dm'] = DistrictManager::with(['lams', 'operation_area', 'created_user', 'updated_user'])->findOrFail($id);
        $dm_class = get_class($data['dm']);
        $data['submitted_kyc'] = SubmittedKyc::with('kyc')->where('creater_id', $id)->where('creater_type', $dm_class)->first();
        $data['users'] = User::where('creater_id', $id)->where('creater_type', $dm_class)->latest()->get();
        $data['earnings'] = Earning::with(['receiver', 'point_history', 'withdraw_earning.withdraw.withdraw_method'])
            ->where('receiver_id', $id)->where('receiver_type', $dm_class)->latest()->get();
        $data['point_name'] = getPointName();
        return view('admin.dm_management.district_manager.profile', $data);
    }
    public function create(): View
    {
        $data['operation_areas'] = OperationArea::activated()->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'dm'], ['type', 'create']])->first();
        return view('admin.dm_management.district_manager.create', $data);
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
        flash()->addSuccess('District Manager ' . $dm->name . ' created successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
    }
    public function edit($id): View
    {
        $data['dm'] = DistrictManager::findOrFail($id);
        $data['operation_areas'] = OperationArea::activated()->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'dm'], ['type', 'update']])->first();
        return view('admin.dm_management.district_manager.edit', $data);
    }
    public function update(DistrictManagerRequest $req, $id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $dm->name = $req->name;
        $dm->phone = $req->phone;
        $dm->oa_id = $req->oa_id;
        if ($req->password) {
            $dm->password = Hash::make($req->password);
        }
        $dm->updated_by = admin()->id;
        $dm->update();
        flash()->addSuccess('District Manager ' . $dm->name . ' updated successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
    }
    public function status($id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $this->statusChange($dm);
        flash()->addSuccess('District Manager ' . $dm->name . ' status updated successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
    }
    public function delete($id): RedirectResponse
    {
        $dm = DistrictManager::findOrFail($id);
        $dm->delete();
        flash()->addSuccess('District Manager ' . $dm->name . ' deleted successfully.');
        return redirect()->route('dm_management.district_manager.district_manager_list');
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