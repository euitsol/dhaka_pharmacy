<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Documentation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class UserController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['users'] = User::with('created_user')->latest()->get();
        return view('admin.user_management.user.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = User::with('role')->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->created_by ? $data->created_user->name : 'System';
        $data->updated_by = $data->updated_by ? $data->updated_user->name : 'N/A';
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['role','created_user','updated_user'])->findOrFail($id);
        return view('admin.user_management.user.profile',$data);
    }
    public function create(): View
    {
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key','user')->first();
        return view('admin.user_management.user.create',$data);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->created_by = admin()->id;
        $user->save();

        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' created successfully.'));
    }
    public function edit($id): View
    {
        $data['user'] = User::findOrFail($id);
        $data['document'] = Documentation::where('module_key','user')->first();
        $data['roles'] = Role::latest()->get();
        return view('admin.user_management.user.edit',$data);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->email = $req->email;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
        $user->updated_by = admin()->id;
        $user->update();

        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' updated successfully.'));
    }
    public function status($id): RedirectResponse
    {
        $user = user::findOrFail($id);
        $this->statusChange($user);
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' status updated successfully.'));
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' deleted successfully.'));

    }
}
