<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyNameRequest;
use App\Models\CompanyName;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\Request;


class CompanyNameController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['company_names'] = CompanyName::with(['created_user'])->orderBy('name')->get();
        return view('admin.product_management.company_name.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = CompanyName::wth(['created_user', 'updated_user'])->findOrFail($id);
        $data->address = html_entity_decode($data->address);
        $data->note = html_entity_decode($data->note);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'company'], ['type', 'create']])->first();
        return view('admin.product_management.company_name.create', $data);
    }
    public function store(CompanyNameRequest $req): RedirectResponse
    {
        $company_name = new CompanyName();
        $company_name->name = $req->name;
        $company_name->slug = $req->slug;
        $company_name->address = $req->address;
        $company_name->note = $req->note;
        $company_name->created_by = admin()->id;
        $company_name->save();
        flash()->addSuccess('Company name ' . $company_name->name . ' created successfully.');
        return redirect()->route('product.company_name.company_name_list');
    }
    public function edit($slug): View
    {
        $data['company_name'] = CompanyName::where('slug', $slug)->first();
        $data['document'] = Documentation::where([['module_key', 'company'], ['type', 'update']])->first();
        return view('admin.product_management.company_name.edit', $data);
    }
    public function update(CompanyNameRequest $req, $id): RedirectResponse
    {
        $company_name = CompanyName::findOrFail($id);
        $company_name->name = $req->name;
        $company_name->slug = $req->slug;
        $company_name->address = $req->address;
        $company_name->note = $req->note;
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

    public function search(Request $request): JsonResponse
    {
        $search = $request->get('q');
        $company_names = CompanyName::where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name')
            ->get();

        return response()->json($company_names);
    }
}
