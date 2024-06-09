<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadPrescriptionRequest;
use App\Models\OrderPrescription;
use App\Models\TempFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class OrderByPrescriptionController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function prescription_upload(UploadPrescriptionRequest $request): JsonResponse
    {
        $data = [];
        try {
            $up = new OrderPrescription();
            $temp_file = TempFile::findOrFail($request->image);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'prescription/' . user()->name . '_' . time() . '/' . $temp_file->filename;
                Storage::move($from_path, 'public/' . $to_path);
                Storage::deleteDirectory($temp_file->path);
                $up->image = $to_path;
                $up->address_id = $request->address_id;
                $up->user_id = user()->id;
                $up->save();
                $temp_file->delete();
                $data['message'] = 'Order by prescription successfully done';
            } else {
                $data['message'] = 'Something is wrong, please try again';
            }
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Somethings is wrong, please try again'], 500);
        }
    }
}