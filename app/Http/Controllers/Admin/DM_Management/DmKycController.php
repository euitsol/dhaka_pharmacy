<?php

namespace App\Http\Controllers\Admin\DM_Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmittedKycRequest;
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

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['datas'] = SubmittedKyc::with('creater')->where('type', 'dm')->orderBy('status', 'desc')->get()->groupBy('status');
        return view('admin.dm_management.submitted_kyc.index', $data);
    }
    public function details($id): View
    {
        $data['data'] = SubmittedKyc::with(['creater', 'updater'])->findOrFail($id);
        $data['kyc_setting'] = KycSetting::where('type', 'dm')->first();
        return view('admin.dm_management.submitted_kyc.details', $data);
    }
    public function accept($id)
    {
        $data = SubmittedKyc::findOrFail($id);
        $data->status = 1;
        $data->update();
        $data->creater->update(['kyc_status' => 1]);
        flash()->addSuccess('KYC accepted succesfully');
        return redirect()->back();
    }

    public function declained(SubmittedKycRequest $req, $id)
    {
        try {
            $data = SubmittedKyc::findOrFail($id);
            $data->status = NULL;
            $data->note = $req->note;
            $data->update();
            $data->creater->update(['kyc_status' => 1]);
            flash()->addSuccess('KYC declained succesfully');
            return response()->json(['message' => 'KYC declained succesfully']);
        } catch (\Exception $e) {
            flash()->addError('Somethings is wrong.');
            return response()->json(['message' => 'An error occurred'], 500);
        }
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