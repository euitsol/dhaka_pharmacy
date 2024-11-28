<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImageUpdateRequest;
use App\Http\Requests\Admin\PasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Documentation;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['admins'] = Admin::with(['role', 'created_user', 'updated_user'])->latest()->get();
        return view('admin.admin_management.admin.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Admin::with(['role', 'created_user', 'updated_user'])->findOrFail($id);
        $ipsArray = json_decode($data->ip, true);
        if (is_array($ipsArray)) {
            $ips = implode(' | ', $ipsArray);
            $data->ips = $ips;
        } else {
            $data->ips = '';
        }
        $data->dob = $data->date_of_birth ? date('d M, Y', strtotime($data->date_of_birth)) : "null";
        $data->identificationType = $data->identificationType();
        $data->getGender = $data->getGender() ?? null;
        $data->identification_file_url = !empty($data->identification_file) ? route("am.admin.download.admin_profile", base64_encode($data->identification_file)) : null;
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function profile($id): View
    {
        if (admin()->id != $id) {
            abort(404);
        }
        $data['document'] = Documentation::where('module_key', 'admin_profile_documentation')->first();
        $data['admin'] = Admin::with(['role', 'created_user', 'updated_user'])->findOrFail($id);
        $ipsArray = json_decode($data['admin']->ip, true);
        if (is_array($ipsArray)) {
            $ips = implode(' | ', $ipsArray);
            $data['admin']->ips = $ips;
        } else {
            $data['admin']->ips = '';
        }
        return view('admin.admin_management.admin.profile', $data);
    }



    public function u_profile(ProfileUpdateRequest $request)
    {

        $admin = Admin::findOrFail(admin()->id);

        if ($request->hasFile('identification_file')) {
            $file = $request->file('identification_file');
            $fileName = admin()->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $folderName = 'admin/identification-file/' . admin()->id;
            $path = $file->storeAs($folderName, $fileName, 'public');
            if (!empty($admin->identification_file)) {
                $this->fileDelete($admin->identification_file);
            }
            $admin->identification_file = $path;
        }

        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->emergency_phone = $request->emergency_phone;
        $admin->father_name = $request->father_name;
        $admin->mother_name = $request->mother_name;
        $admin->designation = $request->designation;
        $admin->gender = $request->gender;
        $admin->identification_type = $request->identification_type;
        $admin->identification_no = $request->identification_no;
        $admin->date_of_birth = $request->date_of_birth;
        $admin->bio = $request->bio;
        $admin->present_address = $request->present_address;
        $admin->permanent_address = $request->permanent_address;
        $admin->updated_by = admin()->id;
        $admin->update();
        flash()->addSuccess('Profile updated successfully.');
        return redirect()->back();
    }
    public function profile_pu(PasswordUpdateRequest $request)
    {

        $admin = Admin::findOrFail(admin()->id);
        $admin->password = $request->password;
        $admin->updated_by = admin()->id;
        $admin->update();
        flash()->addSuccess('Password updated successfully.');
        return redirect()->back();
    }
    public function profile_imgupdate(ImageUpdateRequest $request)
    {
        $admin = Admin::findOrFail(admin()->id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = admin()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $folderName = 'admin/' . admin()->id;
            $path = $image->storeAs($folderName, $imageName, 'public');
            $admin->image = $path;
            $admin->save();
            return response()->json(['message' => 'Image uploaded successfully', 'image' => storage_url($admin->image)], 200);
        }
        return response()->json(['message' => 'Image not uploaded'], 400);
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


























    public function create(): View
    {
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key', 'admin')->first();
        return view('admin.admin_management.admin.create', $data);
    }
    public function store(AdminRequest $req): RedirectResponse
    {
        $admin = new Admin();
        $admin->name = $req->name;
        $admin->ip = json_encode($req->ip);
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        $admin->password = Hash::make($req->password);
        $admin->created_by = admin()->id;
        $admin->save();

        $admin->assignRole($admin->role->name);

        flash()->addSuccess('Admin ' . $admin->name . ' created successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function edit($id): View
    {
        $data['admin'] = Admin::with('role')->findOrFail($id);
        $data['roles'] = Role::latest()->get();
        $data['document'] = Documentation::where('module_key', 'admin')->first();
        return view('admin.admin_management.admin.edit', $data);
    }
    public function update(AdminRequest $req, $id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->name = $req->name;
        $admin->ip = json_encode($req->ip);
        $admin->email = $req->email;
        $admin->role_id = $req->role;
        if ($req->password) {
            $admin->password = Hash::make($req->password);
        }
        $admin->updated_by = admin()->id;
        $admin->update();

        $admin->syncRoles($admin->role->name);

        flash()->addSuccess('Admin ' . $admin->name . ' updated successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function status($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $this->statusChange($admin);
        flash()->addSuccess('Admin ' . $admin->name . ' status updated successfully.');
        return redirect()->route('am.admin.admin_list');
    }
    public function delete($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        flash()->addSuccess('Admin ' . $admin->name . ' deleted successfully.');
        return redirect()->route('am.admin.admin_list');
    }
}
