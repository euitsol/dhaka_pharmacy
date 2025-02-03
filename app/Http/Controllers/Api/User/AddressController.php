<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\API\AddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Traits\DeliveryTrait;
use App\Services\AddressService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends BaseController
{
    use DeliveryTrait;
    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function cities(Request $request)
    {
        try{
            return sendResponse(true, 'Cities retrieved successfully.', $this->addressService->getCities($request->query('city_name')));
        }catch(ModelNotFoundException $e){
            return sendResponse(false, $e->getMessage());
        }catch(Exception $e){
            return sendResponse(false, $e->getMessage());
        }
    }
    public function store(AddressRequest $request): JsonResponse
    {
        try{
            $this->addressService->setUser($request->user())->create($request->validated());
            return sendResponse(true, 'New address added successfully.');
        }catch(ModelNotFoundException $e){
            return sendResponse(false, $e->getMessage());
        }catch(Exception $e){
            return sendResponse(false, $e->getMessage());
        }
    }
    public function update(AddressRequest $request): JsonResponse
    {
        try{
            $this->addressService->setUser($request->user())->update($request->address_id,$request->validated());
            return sendResponse(true, 'Address updated successfully.');
        }catch(ModelNotFoundException $e){
            return sendResponse(false, $e->getMessage());
        }catch(Exception $e){
            return sendResponse(false, $e->getMessage());
        }
    }

    public function list(Request $request)
    {
        try{
            $delivery_details = $request->query('delivery_details', false) == true;
            return sendResponse(true, 'Address list retrived successfully', $this->addressService->setUser($request->user())->list($delivery_details));
        }catch(ModelNotFoundException $e){
            return sendResponse(false, $e->getMessage());
        }catch(Exception $e){
            return sendResponse(false, $e->getMessage());
        }
    }

}
