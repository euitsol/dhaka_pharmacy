<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PrescriptionRequest;
use App\Http\Requests\User\PrescriptionImageRequest;
use App\Http\Services\PrescriptionService;
use App\Models\User;
use Exception;

class OrderByPrescriptionController extends Controller
{
    protected PrescriptionService $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }
    public function create(PrescriptionRequest $request)
    {
        try{
            $prescription = $this->prescriptionService->processPrescription($request->all());
            flash()->addSuccess('Prescription submitted successfully. Our team will contact you soon.');
            return redirect()->route('home');
        }catch(Exception $e){
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }

    public function image_upload(PrescriptionImageRequest $request)
    {
        try {
            $file = $request->file('file');

            if(user()){
                $this->prescriptionService->setUser(User::find(user()->id));
            }

            $data = $this->prescriptionService->uploadPrescriptionImage($file);

            return response()->json([
                'message' => 'Prescription image uploaded successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while uploading the prescription image.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
