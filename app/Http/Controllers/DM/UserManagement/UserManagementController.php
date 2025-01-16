<?php

namespace App\Http\Controllers\DM\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\KycSetting;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Review;
use App\Models\SubmittedKyc;
use App\Models\WishList;

class UserManagementController extends Controller
{
    use DetailsCommonDataTrait;

    public function __construct()
    {
        return $this->middleware('dm');
    }

    public function index(): View
    {
        $data['users'] = User::with('creater')
            ->where('creater_id', dm()->id)
            ->where('creater_type', get_class(dm()))
            ->latest()->get();
        return view('district_manager.user_management.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = User::with(['creater', 'updater'])->findOrFail($id);
        $this->morphColumnData($data);
        $data->image = auth_storage_url($data->image, $data->gender);
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['creater', 'updater'])->findOrFail($id);
        $user_class = get_class($data['user']);
        $data['submitted_kyc'] = SubmittedKyc::with('kyc')->where('creater_id', $id)->where('creater_type', $user_class)->first();
        $data['orders'] = Order::where('customer_id', $id)->where('customer_type', $user_class)->latest()->get();
        $data['reviews'] = Review::where('customer_id', $id)->latest()->get();
        $data['payments'] = Payment::where('customer_id', $id)->where('customer_type', $user_class)->latest()->get();
        return view('district_manager.user_management.profile', $data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'user'], ['type', 'create']])->first();
        return view('district_manager.user_management.create', $data);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->creater()->associate(dm());
        $user->save();
        flash()->addSuccess('User ' . $user->name . ' created successfully.');
        return redirect()->route('dm.user.list');
    }
    public function edit($id): View
    {
        $data['user'] = User::findOrFail($id);
        $data['document'] = Documentation::where([['module_key', 'user'], ['type', 'update']])->first();
        return view('district_manager.user_management.edit', $data);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->updater()->associate(dm());
        $user->update();
        flash()->addSuccess('User ' . $user->name . ' updated successfully.');
        return redirect()->route('dm.user.list');
    }
    public function status($id): RedirectResponse
    {
        $user = user::findOrFail($id);
        $this->statusChange($user);
        flash()->addSuccess('User ' . $user->name . ' status updated successfully.');
        return redirect()->route('dm.user.list');
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash()->addSuccess('User ' . $user->name . ' deleted successfully.');
        return redirect()->route('dm.user.list');
    }
}
