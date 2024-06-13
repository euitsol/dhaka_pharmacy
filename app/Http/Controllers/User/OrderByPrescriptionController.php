<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadPrescriptionRequest;
use App\Models\Address;
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

        try {
            $data = [];
            $up = new OrderPrescription();
            $temp_file = TempFile::findOrFail($request->image);
            if ($temp_file) {
                $from_path = 'public/' . $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'prescription/' . str_replace(' ', '-', user()->name) . '/' . time() . '/' . $temp_file->filename;
                Storage::move($from_path, 'public/' . $to_path);
                $up->image = $to_path;
                $up->address_id = $request->address_id;
                $up->delivery_type = $request->delivery_type;
                $up->delivery_fee = $request->delivery_fee;
                $up->user_id = user()->id;
                $up->save();
                Storage::deleteDirectory('public/' . $temp_file->path);
                $temp_file->forceDelete();
                $data['message'] = 'Order by prescription successfully done';
            } else {
                $data['message'] = 'Something is wrong, please try again';
            }
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Somethings is wrong'], 500);
        }
    }
    public function address($id): JsonResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        return response()->json($data);
    }
}
