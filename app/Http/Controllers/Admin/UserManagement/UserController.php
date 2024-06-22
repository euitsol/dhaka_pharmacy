<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //

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
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = timeFormate($data->updated_at);
        $data->created_by = c_user_name($data->creater);
        $data->updated_by = u_user_name($data->updater);
        $data->image = auth_storage_url($data->image, $data->gender);
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['creater', 'updater'])->findOrFail($id);
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
}
