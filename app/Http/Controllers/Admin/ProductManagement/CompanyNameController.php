<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyNameRequest;
use App\Models\CompanyName;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CompanyNameController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['company_names'] = CompanyName::with(['created_user', 'updated_user'])->orderBy('name')->get();
        return view('admin.product_management.company_name.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = CompanyName::findOrFail($id);
        $data->name = strtoupper($data->name);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'company_name')->first();
        return view('admin.product_management.company_name.create', $data);
    }
    public function store(CompanyNameRequest $req): RedirectResponse
    {
        $company_name = new CompanyName();
        $company_name->name = $req->name;
        $company_name->created_by = admin()->id;
        $company_name->save();
        flash()->addSuccess('Company name ' . $company_name->name . ' created successfully.');
        return redirect()->route('product.company_name.company_name_list');
    }
    public function edit($id): View
    {
        $data['company_name'] = CompanyName::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'company_name')->first();
        return view('admin.product_management.company_name.edit', $data);
    }
    public function update(CompanyNameRequest $req, $id): RedirectResponse
    {
        $company_name = CompanyName::findOrFail($id);
        $company_name->name = $req->name;
        $company_name->updated_by = admin()->id;
        $company_name->update();
        flash()->addSuccess('Company name ' . $company_name->name . ' updated successfully.');
        return redirect()->route('product.company_name.company_name_list');
    }
    public function status($id): RedirectResponse
    {
        $company_name = CompanyName::findOrFail($id);
        $this->statusChange($company_name);
        flash()->addSuccess('Company name ' . $company_name->name . ' status updated successfully.');
        return redirect()->route('product.company_name.company_name_list');
    }
    public function delete($id): RedirectResponse
    {
        $company_name = CompanyName::findOrFail($id);
        $company_name->delete();
        flash()->addSuccess('Company name ' . $company_name->name . ' deleted successfully.');
        return redirect()->route('product.company_name.company_name_list');
    }
}
