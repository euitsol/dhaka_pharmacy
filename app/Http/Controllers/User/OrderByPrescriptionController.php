<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderPrescription;
use App\Models\TempFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class OrderByPrescriptionController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function prescription_upload(Request $request): RedirectResponse
    {
        $up = new OrderPrescription();
        if (isset($request->image) && $request->image != '') {
            $temp_file = TempFile::findOrFail($request->image);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'prescription/' . user()->name . '_' . time() . '/' . $temp_file->filename;
                Storage::move($from_path, 'public/' . $to_path);
                Storage::deleteDirectory($temp_file->path);
                $up->image = $to_path;
                $up->user_id = user()->id;
                $up->save();
                $temp_file->delete();
                flash()->addSuccess('Order by prescription successfully done');
            } else {
                flash()->addError('Something is wrong, please try again');
            }
        } else {
            flash()->addError('File upload failed');
        }

        return redirect()->back();
    }
}
