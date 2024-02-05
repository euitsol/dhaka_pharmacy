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
use App\DataTables\UsersDataTable;


class UserController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(UsersDataTable $dataTable): View
    {
        // $data['users'] = User::with('created_user')->latest()->get();

        return $dataTable->render('admin.user_management.user.index');
        // return view('admin.user_management.user.index',$data);
    }
    public function details($id): JsonResponse
    {
        $data = User::with(['creater','updater'])->findOrFail($id);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = ($data->updated_at != $data->created_at) ? (timeFormate($data->updated_at)) : 'N/A';
        $data->created_by = $data->creater_id ? $data->creater->name : 'System';
        $data->updated_by = $data->updater_id ? $data->updater->name : 'N/A';
        return response()->json($data);
    }
    public function profile($id): View
    {
        $data['user'] = User::with(['creater','updater'])->findOrFail($id);
        return view('admin.user_management.user.profile',$data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where('module_key','user')->first();
        return view('admin.user_management.user.create',$data);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->password = Hash::make($req->password);
        $user->creater()->associate(admin());
        $user->save();
        flash()->addSuccess('User ' . $user->name . ' created successfully.');
        return redirect()->route('um.user.user_list');
    }
    public function edit($id): View
    {
        $data['user'] = User::findOrFail($id);
        $data['document'] = Documentation::where('module_key','user')->first();
        return view('admin.user_management.user.edit',$data);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->phone = $req->phone;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
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
