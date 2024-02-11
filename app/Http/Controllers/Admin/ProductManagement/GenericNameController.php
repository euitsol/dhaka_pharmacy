<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenericNameRequest;
use App\Models\Documentation;
use App\Models\GenericName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class GenericNameController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }
    public function index(): View
    {
        $data['generic_names'] = GenericName::with(['created_user','updated_user'])->orderBy('name')->get();
        return view('admin.product_management.generic_name.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = GenericName::findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key','generic_name')->first();
        return view('admin.product_management.generic_name.create',$data);
    }
    public function store(GenericNameRequest $req): RedirectResponse
    {
        $generic_name = new GenericName();
        $generic_name->name = $req->name;
        $generic_name->created_by = admin()->id;
        $generic_name->save();
        flash()->addSuccess('Medicine generic name '.$generic_name->name.' created successfully.');
        return redirect()->route('product.generic_name.generic_name_list');
    }
    public function edit($id): View
    {
        $data['generic_name'] = GenericName::findOrFail($id);
        $data['document'] = Documentation::where('module_key','generic_name')->first();
        return view('admin.product_management.generic_name.edit',$data);
    }
    public function update(GenericNameRequest $req, $id): RedirectResponse
    {
        $generic_name = GenericName::findOrFail($id);
        $generic_name->name = $req->name;
        $generic_name->updated_by = admin()->id;
        $generic_name->update();
        flash()->addSuccess('Medicine generic name '.$generic_name->name.' updated successfully.');
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
        flash()->addSuccess('Medicine generic name '.$generic_name->name.' deleted successfully.');
        return redirect()->route('product.generic_name.generic_name_list');

    }


}