<?php

namespace App\Http\Controllers\Admin\RiderManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\RiderRequest;
use App\Models\Documentation;
use App\Models\OperationArea;
use App\Models\OperationSubArea;
use App\Models\Rider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Earning;
use App\Models\KycSetting;
use App\Models\SubmittedKyc;
use Illuminate\Support\Facades\Storage;

class RiderManagementController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['riders'] = Rider::with(['operation_area', 'operation_sub_area', 'creater'])->latest()->get();
        return view('admin.rider_management.rider.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Rider::with(['operation_area', 'creater', 'operation_sub_area', 'updater'])->findOrFail($id);
        $data->getGender = $data->getGender() ?? null;
        $data->identificationType = $data->identificationType();
        $data->cv = !empty($data->cv) ? route("rm.rider.download.rider_profile", base64_encode($data->cv)) : null;
        $this->morphColumnData($data);
        $data->image = auth_storage_url($data->image, $data->gender);
        return response()->json($data);
    }

    public function loginAs($id)
    {
        $user = Rider::findOrFail($id);
        if ($user) {
            Auth::guard('rider')->login($user);
            return redirect()->route('rider.dashboard');
        } else {
            flash()->addError('Rider not found');
            return redirect()->back();
        }
    }

    public function profile($id): View
    {
        $data['rider'] = Rider::with(['creater', 'odrs.od.order.address', 'operation_area', 'operation_sub_area', 'updater'])->findOrFail($id);
        $rider_class = get_class($data['rider']);
        $data['submitted_kyc'] = SubmittedKyc::with('kyc')->where('creater_id', $id)->where('creater_type', $rider_class)->first();
        $data['earnings'] = Earning::with(['receiver', 'order', 'point_history', 'withdraw_earning.withdraw.withdraw_method'])
            ->where('receiver_id', $id)->where('receiver_type', $rider_class)->get();
        $data['dors'] = $data['rider']->odrs()->orderBy('priority', 'desc')->latest()->get();
        $data['point_name'] = getPointName();
        return view('admin.rider_management.rider.profile', $data);
    }


    public function create(): View
    {
        $data['operational_areas'] = OperationArea::activated()->latest()->get();
        $data['document'] = Documentation::where('module_key', 'rider')->first();
        return view('admin.rider_management.rider.create', $data);
    }
    public function store(RiderRequest $req): RedirectResponse
    {
        $rider = new Rider();
        $rider->name = $req->name;
        $rider->phone = $req->phone;
        $rider->oa_id = $req->oa_id;
        $rider->osa_id = $req->osa_id;
        $rider->password = Hash::make($req->password);
        $rider->creater()->associate(admin());
        $rider->save();
        flash()->addSuccess('Rider ' . $rider->name . ' created successfully.');
        return redirect()->route('rm.rider.rider_list');
    }
    public function edit($id): View
    {
        $data['rider'] = Rider::findOrFail($id);
        $data['operation_areas'] = OperationArea::activated()->latest()->get();
        $data['operation_sub_areas'] = OperationSubArea::activated()->latest()->get();
        $data['document'] = Documentation::where('module_key', 'rider')->first();
        return view('admin.rider_management.rider.edit', $data);
    }
    public function update(RiderRequest $req, $id): RedirectResponse
    {
        $rider = Rider::findOrFail($id);
        $rider->name = $req->name;
        $rider->phone = $req->phone;
        $rider->oa_id = $req->oa_id;
        $rider->osa_id = $req->osa_id;
        if ($req->password) {
            $rider->password = Hash::make($req->password);
        }
        $rider->updater()->associate(admin());
        $rider->update();

        flash()->addSuccess('Rider ' . $rider->name . ' updated successfully.');
        return redirect()->route('rm.rider.rider_list');
    }
    public function status($id): RedirectResponse
    {
        $rider = Rider::findOrFail($id);
        $this->statusChange($rider);
        flash()->addSuccess('Rider ' . $rider->name . ' status updated successfully.');
        return redirect()->route('rm.rider.rider_list');
    }
    public function delete($id): RedirectResponse
    {
        $rider = Rider::findOrFail($id);
        $rider->delete();
        flash()->addSuccess('Rider ' . $rider->name . ' deleted successfully.');
        return redirect()->route('rm.rider.rider_list');
    }



    public function get_operational_sub_area($oa_id): JsonResponse
    {
        $data['operation_area'] = OperationArea::with('operation_sub_areas')->activated()->findOrFail($oa_id);
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
