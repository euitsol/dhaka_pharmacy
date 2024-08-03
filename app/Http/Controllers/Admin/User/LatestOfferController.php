<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LatestOfferRequest;
use App\Models\Documentation;
use App\Models\LatestOffer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;


class LatestOfferController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }
    public function index(): View
    {
        $data['latest_offer'] = LatestOffer::with('created_user')->latest()->get();
        return view('admin.latest_offer.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = LatestOffer::with(['created_user', 'updated_user'])->findOrFail($id);
        $data->image = storage_url($data->image);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'latest_offer')->first();
        return view('admin.latest_offer.create', $data);
    }
    public function store(LatestOfferRequest $req): RedirectResponse
    {
        $lf = new LatestOffer();
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->title . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'latest_offer/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            $lf->image = $path;
        }
        $lf->title = $req->title;
        $lf->created_by = admin()->id;
        $lf->save();
        flash()->addSuccess("Latest offer created successfully");
        return redirect()->route('latest_offer.lf_list');
    }
    public function edit($id): View
    {
        $data['latest_offer'] = LatestOffer::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'latest_offer')->first();
        return view('admin.latest_offer.edit', $data);
    }

    public function update(LatestOfferRequest $req, $id): RedirectResponse
    {
        $lf = LatestOffer::findOrFail($id);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = $req->title . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'latest_offer/';
            $path = $image->storeAs($folderName, $imageName, 'public');
            if (!empty($lf->image)) {
                $this->fileDelete($lf->image);
            }
            $lf->image = $path;
        }
        $lf->title = $req->title;
        $lf->updated_by = admin()->id;
        $lf->save();
        flash()->addSuccess("Latest offer updated successfully");
        return redirect()->route('latest_offer.lf_list');
    }
    public function status($id): RedirectResponse
    {
        $lf = LatestOffer::findOrFail($id);
        $this->statusChange($lf);
        flash()->addSuccess('Latest offer status updated successfully.');
        return redirect()->route('latest_offer.lf_list');
    }

    public function delete($id): RedirectResponse
    {
        $lf = LatestOffer::findOrFail($id);
        $lf->delete();
        flash()->addSuccess('Latest offer deleted successfully.');
        return redirect()->route('latest_offer.lf_list');
    }
}
