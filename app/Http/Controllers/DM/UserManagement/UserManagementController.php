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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $data->statusTitle = $data->getStatus();
        $data->statusBg = $data->getStatusBadgeClass();
        $data->kycVerifyTitle = $data->getKycStatus();
        $data->kycVerifyBg = $data->getKycStatusClass();
        $data->phoneVerifyTitle = $data->getPhoneVerifyStatus();
        $data->phoneVerifyBg = $data->getPhoneVerifyClass();
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
        DB::beginTransaction();
        try {
            // Create a new District Manager
            $user = new User();
            $user->name = $req->name;
            $user->phone = $req->phone;
            $user->creater()->associate(dm());
            $user->save();

            // Send SMS notification
            // $message = "Your account has been created successfully. Your account registration phone number is: " . $user->phone . ". Please use this number to verify and login to your account. Thank you for choosing our services.";
            // $smsSent = $this->send_single_sms($user->phone, $message);
            $smsSent = false;

            if ($smsSent === true) {
                session()->flash('success', 'User ' . $user->name . ' created successfully.');
            } else {
                Log::error("Failed to send SMS to {$user->phone}");
                session()->flash('warning', 'User created, but SMS could not be sent.');
            }

            DB::commit();
            return redirect()->route('dm.user.list');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("User creation failed: " . $e->getMessage());
            session()->flash('error', 'An error occurred while creating the user. Please try again.');
            return redirect()->back();
        }
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