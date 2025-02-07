<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadPrescriptionRequest;
use App\Http\Traits\DeliveryTrait;
use App\Models\Address;
use App\Models\OrderPrescription;
use App\Models\TempFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class OrderByPrescriptionController extends Controller
{
    use DeliveryTrait;

    public function __construct()
    {
        // return $this->middleware('auth');
    }
    public function prescription_upload(UploadPrescriptionRequest $request): JsonResponse
    {

        try {
            $data = [];
            $up = new OrderPrescription();
            $address = Address::findOrFail($request->address_id);
            $temp_file = TempFile::findOrFail($request->image);

            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $parent_directory = 'prescription/' . str_replace(' ', '-', user()->name);
                $to_path = $parent_directory . '/' . time() . '/' . $temp_file->filename;

                // Ensure the parent directory exists
                Storage::disk('public')->makeDirectory($parent_directory);

                // Move the file
                Storage::disk('public')->move($from_path, $to_path);

                // Save the order prescription
                $up->image = $to_path;
                $up->address_id = $request->address_id;
                $up->delivery_type = 1;
                $up->delivery_fee = $this->getDeliveryCharge($address->latitude, $address->longitude);
                $up->user_id = user()->id;
                $up->save();

                // Clean up temporary files
                Storage::disk('public')->deleteDirectory($temp_file->path);
                $temp_file->forceDelete();

                $data['message'] = 'Order by prescription successfully done';
            } else {
                $data['message'] = 'Something is wrong, please try again';
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
    public function check_auth()
    {
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'requiresLogin' => true,
                'message' => 'You need to log in to place an order.',
            ]);
        } else {
            return response()->json(['success' => true]);
        }
    }
}