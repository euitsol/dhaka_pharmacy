<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\PrescriptionCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\PrescriptionService;
use Exception;
use App\Http\Requests\API\User\PrescriptionUploadRequest;

class PrescriptionController extends Controller
{
    protected PrescriptionService $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }
    public function upload(PrescriptionUploadRequest $request): JsonResponse
    {
        try {
            $data = $this->prescriptionService->uploadPrescriptionImage($request->file('file'));
            return sendResponse(true, 'Prescription image uploaded successfully', $data);
        } catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), [], 500);
        }
    }

    public function create(PrescriptionCreateRequest $request)
    {
        try {
            $data = $this->prescriptionService->processPrescription($request->all());
            return sendResponse(true, 'Prescription created successfully', $data);
        } catch (Exception $e) {
            return sendResponse(false, $e->getMessage(), [], 500);
        }
    }
}
