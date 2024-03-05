<?php

namespace App\Http\Controllers\LAM\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Documentation;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('lam');
    }

    public function index(): View
    {
        $data['users'] = User::with('creater')
            ->where('creater_id', lam()->id)
            ->where('creater_type', get_class(lam()))
            ->latest()->get();
        return view('local_area_manager.user_management.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = User::with(['creater', 'updater'])->findOrFail($id);
        $data->creating_time = $data->created_date();
        $data->updating_time = $data->updated_date();
        $data->created_by = $data->creater_name();
        $data->updated_by = $data->updater_name();
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['creater', 'updater'])->findOrFail($id);
        return view('local_area_manager.user_management.profile', $data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key', 'user')->first();
        return view('local_area_manager.user_management.create', $data);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->creater()->associate(lam());
        $user->save();
        flash()->addSuccess('User ' . $user->name . ' created successfully.');
        return redirect()->route('lam.user.list');
    }
    public function edit($id): View
    {
        $data['user'] = User::findOrFail($id);
        $data['document'] = Documentation::where('module_key', 'user')->first();
        return view('local_area_manager.user_management.edit', $data);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->updater()->associate(lam());
        $user->update();
        flash()->addSuccess('User ' . $user->name . ' updated successfully.');
        return redirect()->route('lam.user.list');
    }
    public function status($id): RedirectResponse
    {
        $user = user::findOrFail($id);
        $this->statusChange($user);
        flash()->addSuccess('User ' . $user->name . ' status updated successfully.');
        return redirect()->route('lam.user.list');
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash()->addSuccess('User ' . $user->name . ' deleted successfully.');
        return redirect()->route('lam.user.list');
    }
}