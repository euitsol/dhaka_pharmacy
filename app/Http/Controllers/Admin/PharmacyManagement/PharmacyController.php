<?php

namespace App\Http\Controllers\Admin\PharmacyManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyRequest;
use App\Models\Documentation;
use App\Models\Pharmacy;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class PharmacyController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['pharmacies'] = Pharmacy::with('created_user')->latest()->get();
        return view('admin.pharmacy_management.pharmacy.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = Pharmacy::with('role')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['pharmacy'] = Pharmacy::with(['created_user','updated_user'])->findOrFail($id);
        return view('admin.pharmacy_management.pharmacy.profile',$data);
    }
    public function create(): View
    {
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key','pharmacy')->first();
        return view('admin.pharmacy_management.pharmacy.create',$data);
    }
    public function store(PharmacyRequest $req): RedirectResponse
    {
        $pharmacy = new Pharmacy();
        $pharmacy->name = $req->name;
        $pharmacy->email = $req->email;
        $pharmacy->password = Hash::make($req->password);
        $pharmacy->created_by = admin()->id;
        $pharmacy->save();
        flash()->addSuccess('Pharmacy '.$pharmacy->name.' created successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }
    public function edit($id): View
    {
        $data['pharmacy'] = Pharmacy::findOrFail($id);
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key','pharmacy')->first();
        return view('admin.pharmacy_management.pharmacy.edit',$data);
    }
    public function update(PharmacyRequest $req, $id): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->name = $req->name;
        $pharmacy->email = $req->email;
        if($req->password){
            $pharmacy->password = Hash::make($req->password);
        }
        $pharmacy->updated_by = admin()->id;
        $pharmacy->update();
        flash()->addSuccess('Pharmacy '.$pharmacy->name.' updated successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }
    public function status($id): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $this->statusChange($pharmacy);
        flash()->addSuccess('Pharmacy '.$pharmacy->name.' status updated successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');
    }
    public function delete($id): RedirectResponse
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->delete();
        flash()->addSuccess('Pharmacy '.$pharmacy->name.' deleted successfully.');
        return redirect()->route('pm.pharmacy.pharmacy_list');

    }
}
