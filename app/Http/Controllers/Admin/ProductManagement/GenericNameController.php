<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenericNameRequest;
use App\Models\Documentation;
use App\Models\GenericName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\Request;


class GenericNameController extends Controller
{
    use DetailsCommonDataTrait;

    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(): View
    {
        $data['generic_names'] = GenericName::with(['created_user'])->orderBy('name')->get();
        return view('admin.product_management.generic_name.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = GenericName::with(['created_user', 'updated_user'])->findOrFail($id);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'generic_name'], ['type', 'create']])->first();
        return view('admin.product_management.generic_name.create', $data);
    }
    public function store(GenericNameRequest $req): RedirectResponse
    {
        $generic_name = new GenericName();
        $generic_name->name = $req->name;
        $generic_name->slug = $req->slug;
        $generic_name->created_by = admin()->id;
        $generic_name->save();
        flash()->addSuccess('Medicine generic name ' . $generic_name->name . ' created successfully.');
        return redirect()->route('product.generic_name.generic_name_list');
    }
    public function edit($slug): View
    {
        $data['generic_name'] = GenericName::where('slug', $slug)->first();
        $data['document'] = Documentation::where([['module_key', 'generic_name'], ['type', 'update']])->first();
        return view('admin.product_management.generic_name.edit', $data);
    }
    public function update(GenericNameRequest $req, $id): RedirectResponse
    {
        $generic_name = GenericName::findOrFail($id);
        $generic_name->name = $req->name;
        $generic_name->slug = $req->slug;
        $generic_name->updated_by = admin()->id;
        $generic_name->update();
        flash()->addSuccess('Medicine generic name ' . $generic_name->name . ' updated successfully.');
        return redirect()->route('product.generic_name.generic_name_list');
    }
    public function status($id): RedirectResponse
    {
        $generic_name = GenericName::findOrFail($id);
        $this->statusChange($generic_name);
        flash()->addSuccess('Generic name ' . $generic_name->name . ' status updated successfully.');
        return redirect()->route('product.generic_name.generic_name_list');
    }

    public function delete($id): RedirectResponse
    {
        $generic_name = GenericName::findOrFail($id);
        $generic_name->delete();
        flash()->addSuccess('Medicine generic name ' . $generic_name->name . ' deleted successfully.');
        return redirect()->route('product.generic_name.generic_name_list');
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->get('q');
        $generic_names = GenericName::where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name')
            ->get();

        return response()->json($generic_names);
    }
}
