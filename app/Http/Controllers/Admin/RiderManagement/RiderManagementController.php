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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class RiderManagementController extends Controller
{
    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['riders'] = Rider::with(['operation_area','operation_sub_area','creater'])->latest()->get();
        return view('admin.rider_management.rider.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = Rider::with(['operation_area','creater','operation_sub_area','updater'])->findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->creater_name();
        $data->updated_by = $data->updater_name();
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
        $data['rider'] = Rider::with(['creater','operation_area','operation_sub_area','updater'])->findOrFail($id);
        return view('admin.rider_management.rider.profile',$data);
    }


    public function create(): View
    {
        $data['operational_areas'] = OperationArea::activated()->latest()->get();
        $data['document'] = Documentation::where('module_key','rider')->first();
        return view('admin.rider_management.rider.create',$data);
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
        flash()->addSuccess('Rider '.$rider->name.' created successfully.');
        return redirect()->route('rm.rider.rider_list');
    }
    public function edit($id): View
    {
        $data['rider'] = Rider::findOrFail($id);
        $data['operation_areas'] = OperationArea::activated()->latest()->get();
        $data['operation_sub_areas'] = OperationSubArea::activated()->latest()->get();
        $data['document'] = Documentation::where('module_key','rider')->first();
        return view('admin.rider_management.rider.edit',$data);
    }
    public function update(RiderRequest $req, $id): RedirectResponse
    {
        $rider = Rider::findOrFail($id);
        $rider->name = $req->name;
        $rider->phone = $req->phone;
        $rider->oa_id = $req->oa_id;
        $rider->osa_id = $req->osa_id;
        if($req->password){
            $rider->password = Hash::make($req->password);
        }
        $rider->updater()->associate(admin());
        $rider->update();

        flash()->addSuccess('Rider '.$rider->name.' updated successfully.');
        return redirect()->route('rm.rider.rider_list');
    }
    public function status($id): RedirectResponse
    {
        $rider = Rider::findOrFail($id);
        $this->statusChange($rider);
        flash()->addSuccess('Rider '.$rider->name.' status updated successfully.');
        return redirect()->route('rm.rider.rider_list');
    }
    public function delete($id): RedirectResponse
    {
        $rider = Rider::findOrFail($id);
        $rider->delete();
        flash()->addSuccess('Rider '.$rider->name.' deleted successfully.');
        return redirect()->route('rm.rider.rider_list');

    }


    
    public function get_operational_sub_area($oa_id): JsonResponse
    {
        $data['operation_area'] = OperationArea::with('operation_sub_areas')->activated()->findOrFail($oa_id);
        return response()->json($data);

    }
}
