<?php

namespace App\Http\Controllers\Admin\HubManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\HubRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
use App\Models\Hub;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HubController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): view
    {
        $data['hubs'] = Hub::with(['created_user', 'updated_user'])->orderBy('name')->get();
        return view('admin.hub_management.hub.index', $data);
    }

    public function details($id): JsonResponse
    {
        $data = Hub::findOrFail($id);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): view
    {
        $data['document'] = Documentation::where([['module_key', 'hub'], ['type', 'create']])->first();
        return view('admin.hub_management.hub.create', $data);
    }
    public function store(HubRequest $req): RedirectResponse
    {
        $hub = new Hub();
        $hub->name = $req->name;
        $hub->slug = $req->slug;
        $hub->description = $req->description;
        $hub->created_by = admin()->id;
        $hub->save();
        flash()->addSuccess('Hub ' . $hub->name . ' created successfully. ');
        return redirect()->route('hm.hub.hub_list');
    }
    public function edit($slug): view
    {
        $data['hub'] = Hub::where('slug', $slug)->first();
        $data['document'] = Documentation::where([['module_key', 'hub'], ['type', 'update']])->first();
        return view('admin.hub_management.hub.edit', $data);
    }
    public function update(HubRequest $req, $id): RedirectResponse
    {
        $hub = Hub::findorFail($id);
        $hub->name = $req->name;
        $hub->slug = $req->slug;
        $hub->description = $req->description;
        $hub->updated_by = admin()->id;
        $hub->update();
        flash()->addSuccess('Hub ' . $hub->name . ' updated Successfully ');
        return redirect()->route('hm.hub.hub_list');
    }
    public function status($id): RedirectResponse
    {
        $hub = Hub::findOrFail($id);
        $this->statusChange($hub);
        flash()->addSuccess('Hub ' . $hub->name . ' status updated successfully.');
        return redirect()->route('hm.hub.hub_list');
    }

    public function delete($id): RedirectResponse
    {
        $hub = Hub::findOrFail($id);
        $hub->delete();
        flash()->addSuccess('Hub ' . $hub->name . ' deleted successfully.');
        return redirect()->route('hm.hub.hub_list');
    }
}
