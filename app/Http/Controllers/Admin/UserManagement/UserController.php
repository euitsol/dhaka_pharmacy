<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\KycSetting;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Review;
use App\Models\SubmittedKyc;
use App\Models\WishList;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use DetailsCommonDataTrait, TransformOrderItemTrait;

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['users'] = User::with('creater')->latest()->get();
        return view('admin.user_management.user.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = User::with(['creater', 'updater'])->findOrFail($id);
        $data->dob = $data->dob ? date('d M, Y', strtotime($data->dob)) : "null";
        $data->identificationType = $data->identificationType();
        $data->getGender = $data->getGender() ?? null;
        $data->identification_file_url = !empty($data->identification_file) ? route("um.user.download.user_profile", base64_encode($data->identification_file)) : null;
        $this->morphColumnData($data);
        $data->image = auth_storage_url($data->image, $data->gender);
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['creater', 'updater'])->findOrFail($id);
        $user_class = get_class($data['user']);
        $data['submitted_kyc'] = SubmittedKyc::with('kyc')->where('creater_id', $id)->where('creater_type', $user_class)->first();
        $data['orders'] = Order::with('products', 'products.units', 'products.discounts', 'products.pivot.unit', 'od')->where('customer_id', $id)->where('customer_type', $user_class)->latest()->get()->each(function (&$order) {
            $this->calculateOrderTotalDiscountPrice($order);
        });
        $data['reviews'] = Review::with('product')->where('customer_id', $id)->latest()->get();
        $data['payments'] = Payment::with(['customer', 'order.od'])->where('customer_id', $id)->where('customer_type', $user_class)->latest()->get();
        return view('admin.user_management.user.profile', $data);
    }
    public function loginAs($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            Auth::guard('web')->login($user);
            return redirect()->route('user.dashboard');
        } else {
            flash()->addError('User not found');
            return redirect()->back();
        }
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'user')->first();
        return view('admin.user_management.user.create', $data);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->creater()->associate(admin());
        $user->save();
        flash()->addSuccess('User ' . $user->name . ' created successfully.');
        return redirect()->route('um.user.user_list');
    }
    public function edit($id): View
    {
        $data['user'] = User::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'user')->first();
        return view('admin.user_management.user.edit', $data);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->updater()->associate(admin());
        $user->update();
        flash()->addSuccess('User ' . $user->name . ' updated successfully.');
        return redirect()->route('um.user.user_list');
    }
    public function status($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $this->statusChange($user);
        flash()->addSuccess('User ' . $user->name . ' status updated successfully.');
        return redirect()->route('um.user.user_list');
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash()->addSuccess('User ' . $user->name . ' deleted successfully.');
        return redirect()->route('um.user.user_list');
    }

    public function view_or_download($file_url)
    {
        $file_url = base64_decode($file_url);
        if (Storage::exists('public/' . $file_url)) {
            $fileExtension = pathinfo($file_url, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) === 'pdf') {
                return response()->file(storage_path('app/public/' . $file_url), [
                    'Content-Disposition' => 'inline; filename="' . basename($file_url) . '"'
                ]);
            } else {
                return response()->download(storage_path('app/public/' . $file_url), basename($file_url));
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
