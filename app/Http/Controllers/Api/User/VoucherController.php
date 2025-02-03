<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\VoucherService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class VoucherController extends Controller
{
    private $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function check(Request $request): JsonResponse
    {
        try{
            $this->voucherService->setUser($request->user());
            $order_id = $request->query('order_id', null);
            if ($order_id) {
                $this->voucherService->setOrder($order_id);
            }
            $voucher = $this->voucherService->check($request->get('voucher_code', null));
            return sendResponse(true, 'Voucher checked successfully.', $voucher);
        }catch(ModelNotFoundException $e){
            return sendResponse(false, $e->getMessage());
        }catch(Exception $e){
            return sendResponse(false, $e->getMessage());
        }
    }

}
