<?php

namespace App\Http\Controllers\DM\LAM_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocalAreaManagerRequest;
use App\Models\DistrictManager;
use App\Models\Documentation;
use App\Models\LocalAreaManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Earning;
use App\Models\KycSetting;
use App\Models\SubmittedKyc;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\SmsTrait;

class LamManagementController extends Controller
{
    use DetailsCommonDataTrait, SmsTrait;
    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function index(): View
    {
        $data['lams'] = LocalAreaManager::with(['dm', 'creater'])->where('dm_id', dm()->id)->latest()->get();
        return view('district_manager.lam_management.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = LocalAreaManager::with(['dm.operation_area', 'operation_sub_area', 'creater', 'updater'])->findOrFail($id);
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $data->kycVerifyTitle = $data->getKycStatus();
        $data->kycVerifyBg = $data->getKycStatusClass();
        $data->phoneVerifyTitle = $data->getPhoneVerifyStatus();
        $data->phoneVerifyBg = $data->getPhoneVerifyClass();
        $this->morphColumnData($data);
        $data->image = auth_storage_url($data->image, $data->gender);
        return response()->json($data);
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
        return view('district_manager.lam_management.profile', $data);
    }


    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'lam'], ['type', 'create']])->first();
        return view('district_manager.lam_management.create', $data);
    }
    public function store(LocalAreaManagerRequest $req): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Create a new District Manager
            $lam = new LocalAreaManager();
            $lam->name = $req->name;
            $lam->phone = $req->phone;
            $lam->dm_id = dm()->id;
            $lam->osa_id = $req->osa_id;
            $lam->password = Hash::make($req->password);
            $lam->creater()->associate(dm());
            $lam->save();

            // Send SMS notification
            // $message = "Your Local Area Manager account has been created successfully. Your login credentials are: <br> Phone: " . $lam->phone . "<br> Password: " . $req->password;
            // $smsSent = $this->send_single_sms($lam->phone, $message);
            $smsSent = false;

            if ($smsSent === true) {
                session()->flash('success', 'Local Area Manager ' . $lam->name . ' created successfully.');
            } else {
                Log::error("Failed to send SMS to {$lam->phone}");
                session()->flash('warning', 'Local Area Manager created, but SMS could not be sent.');
            }

            DB::commit();
            return redirect()->route('dm.lam.list');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Local Area Manager creation failed: " . $e->getMessage());
            session()->flash('error', 'An error occurred while creating the Local Area Manager. Please try again.');
            return redirect()->back();
        }
    }
    public function edit($id): View
    {
        $data['lam'] = LocalAreaManager::findOrFail($id);
        $data['dms'] = DistrictManager::latest()->get();
        $data['document'] = Documentation::where([['module_key', 'lam'], ['type', 'update']])->first();
        return view('district_manager.lam_management.edit', $data);
    }
    public function update(LocalAreaManagerRequest $req, $id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->name = $req->name;
        $lam->phone = $req->phone;
        $lam->dm_id = dm()->id;
        $lam->osa_id = $req->osa_id;
        if ($req->password) {
            $lam->password = Hash::make($req->password);
        }
        $lam->updater()->associate(dm());
        $lam->update();

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' updated successfully.');
        return redirect()->route('dm.lam.list');
    }
    public function status($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $this->statusChange($lam);

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' status updated successfully.');
        return redirect()->route('dm.lam.list');
    }
    public function delete($id): RedirectResponse
    {
        $lam = LocalAreaManager::findOrFail($id);
        $lam->delete();

        flash()->addSuccess('Local Area Manager ' . $lam->name . ' deleted successfully.');
        return redirect()->route('dm.lam.list');
    }
}