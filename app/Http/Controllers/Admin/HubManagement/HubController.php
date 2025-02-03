<?php

namespace App\Http\Controllers\Admin\HubManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\HubRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Address;
use App\Models\Documentation;
use App\Models\Hub;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        try {
            DB::transaction(function () use ($req) {
                // Create Hub
                $hub = new Hub();
                $hub->name = $req->name;
                $hub->slug = $req->slug;
                $hub->description = $req->description;
                $hub->created_by = admin()->id;
                $hub->save();

                // Create Address
                $hub_address = new Address();
                $hub_address->longitude = $req->long;
                $hub_address->latitude = $req->lat;
                $hub_address->address = $req->address;
                $hub_address->city = $req->city;
                $hub_address->street_address = $req->street;
                $hub_address->apartment = $req->apartment;
                $hub_address->floor = $req->floor;
                $hub_address->delivery_instruction = $req->instruction;
                $hub_address->creater()->associate($hub);
                $hub_address->save();
            });
            flash()->addSuccess('Hub created successfully.');
        } catch (\Exception $e) {
            Log::info("message: " . $e->getMessage());
            flash()->addError('An error occurred while creating the hub. Please try again.');
            return redirect()->back()->withInput();
        }
        return redirect()->route('hm.hub.hub_list');
    }
    public function edit($slug): view
    {
        $data['hub'] = Hub::with('address')->where('slug', $slug)->first();
        $data['document'] = Documentation::where([['module_key', 'hub'], ['type', 'update']])->first();
        return view('admin.hub_management.hub.edit', $data);
    }
    public function update(HubRequest $req, $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($req, $id) {
                // Create Hub
                $hub = Hub::findOrFail($id);
                $hub->name = $req->name;
                $hub->slug = $req->slug;
                $hub->description = $req->description;
                $hub->created_by = admin()->id;
                $hub->save();

                // Create or Update Address
                $hub_address_data = [
                    'longitude' => $req->long,
                    'latitude' => $req->lat,
                    'address' => $req->address,
                    'city' => $req->city,
                    'street_address' => $req->street,
                    'apartment' => $req->apartment,
                    'floor' => $req->floor,
                    'delivery_instruction' => $req->instruction,
                ];
                Address::updateOrCreate(
                    ['creater_id' => $hub->id, 'creater_type' => get_class($hub)],
                    $hub_address_data
                );
            });
            flash()->addSuccess('Hub created successfully.');
        } catch (\Exception $e) {
            Log::info("message: " . $e->getMessage());
            flash()->addError('An error occurred while creating the hub. Please try again.');
            return redirect()->back()->withInput();
        }
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