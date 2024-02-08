<?php

namespace App\Http\Controllers\Admin\DM_Management;

use App\Http\Controllers\Controller;
use App\Models\KycSetting;
use App\Models\SubmittedKyc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class DmKycController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index():View
    {
        $data['datas'] = SubmittedKyc::with('creater')->where('type','dm')->latest()->get();
        $data['count']= $data['datas']->map(function($data){
            return count(json_decode($data->submitted_data,true));
        });
        return view('admin.dm_management.submitted_kyc.index',$data);

    }
    public function details($id):View
    {
        $data['data'] = SubmittedKyc::findOrFail($id);
        $data['kyc_setting'] = KycSetting::where('type','dm')->first();
        return view('admin.dm_management.submitted_kyc.details',$data);

    }
    public function status($id, $status = NULL)
    {
        $data = SubmittedKyc::findOrFail($id);
        $data->status = $status;
        $data->update();
        if($data->status === 1){
            flash()->addSuccess('KYC accepted succesfully');
        }
        if($data->status === NULL){
            flash()->addSuccess('KYC declined succesfully');
        }
        return redirect()->back();

    }

    public function view_or_download($file_url){
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
