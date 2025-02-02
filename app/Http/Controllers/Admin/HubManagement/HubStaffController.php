<?php

namespace App\Http\Controllers\Admin\HubManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\HubStaffRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
use App\Models\Hub;
use App\Models\HubStaff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HubStaffController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): View
    {
        $data['hub_staffs'] = HubStaff::with(['hub', 'creater'])->orderBy('name')->get();
        return view('admin.hub_management.hub_staff.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = HubStaff::with('hub')->findOrFail($id);
        $this->morphColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['hubs'] = Hub::activated()->latest()->get();
        $data['document'] = Documentation::where([['module_key', 'hub_staff'], ['type', 'create']])->first();
        return view('admin.hub_management.hub_staff.create', $data);
    }
    public function store(HubStaffRequest $req): RedirectResponse
    {
        $hub_staff = new HubStaff();
        $hub_staff->name = $req->name;
        $hub_staff->email = $req->email;
        $hub_staff->password = $req->password;
        $hub_staff->hub_id = $req->hub;
        $hub_staff->creater()->associate(admin());
        $hub_staff->save();
        flash()->addSuccess('Hub Staff ' . $hub_staff->name . ' created successfully.');
        return redirect()->route('hm.hub_staff.hub_staff_list');
    }
    public function edit($id): View
    {
        $data['hub_staff'] = HubStaff::findOrFail($id);
        $data['hubs'] = Hub::activated()->latest()->get();
        $data['document'] = Documentation::where([['module_key', 'hub_staff'], ['type', 'update']])->first();
        return view('admin.hub_management.hub_staff.edit', $data);
    }
    public function update(HubStaffRequest $req, $id): RedirectResponse
    {
        $hub_staff = HubStaff::findOrFail($id);
        $hub_staff->name = $req->name;
        $hub_staff->email = $req->email;
        $hub_staff->password = $req->password ?? $hub_staff->password;
        $hub_staff->hub_id = $req->hub;
        $hub_staff->updater()->associate(admin());
        $hub_staff->update();
        flash()->addSuccess('Hub Staff ' . $hub_staff->name . ' updated successfully.');
        return redirect()->route('hm.hub_staff.hub_staff_list');
    }

    public function status($id): RedirectResponse
    {
        $hub_staff = HubStaff::findOrFail($id);
        $this->statusChange($hub_staff);
        flash()->addSuccess('Hub Staff ' . $hub_staff->name . ' status updated successfully.');
        return redirect()->route('hm.hub_staff.hub_staff_list');
    }
    public function delete($id): RedirectResponse
    {
        $hub_staff = HubStaff::findOrFail($id);
        $hub_staff->deleter()->associate(admin());
        $hub_staff->delete();
        flash()->addSuccess('Hub Staff ' . $hub_staff->name . ' deleted successfully.');
        return redirect()->route('hm.hub_staff.hub_staff_list');
    }
}
