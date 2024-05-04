<?php

namespace App\Http\Controllers\DM\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Documentation;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserManagementController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('dm');
    }

    public function index(): View
    {
        $data['users'] = User::with('creater')
                        ->where('creater_id', dm()->id)
                        ->where('creater_type', get_class(dm()))
                        ->latest()->get();
        return view('district_manager.user_management.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = User::with(['creater','updater'])->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = timeFormate($data->updated_at);
        $data->created_by = c_user_name($data->creater);
        $data->updated_by = u_user_name($data->updater);
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['creater','updater'])->findOrFail($id);
        return view('district_manager.user_management.profile',$data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key','user')->first();
        return view('district_manager.user_management.create',$data);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->creater()->associate(dm());
        $user->save();
        flash()->addSuccess('User '.$user->name.' created successfully.');
        return redirect()->route('dm.user.list');
    }
    public function edit($id): View
    {
        $data['user'] = User::findOrFail($id);
        $data['document'] = Documentation::where('module_key','user')->first();
        return view('district_manager.user_management.edit',$data);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->updater()->associate(dm());
        $user->update();
        flash()->addSuccess('User '.$user->name.' updated successfully.');
        return redirect()->route('dm.user.list');
    }
    public function status($id): RedirectResponse
    {
        $user = user::findOrFail($id);
        $this->statusChange($user);
        flash()->addSuccess('User '.$user->name.' status updated successfully.');
        return redirect()->route('dm.user.list');
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash()->addSuccess('User '.$user->name.' deleted successfully.');
        return redirect()->route('dm.user.list');

    }


}