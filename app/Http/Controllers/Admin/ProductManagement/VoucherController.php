<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Voucher;


class VoucherController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct() {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $data['vouchers'] = Voucher::with(['created_user'])
            ->orderBy('starts_at', 'desc')
            ->get();

        return view('admin.product_management.vouchers.index', $data);
    }

    public function details($id): JsonResponse
    {
        $voucher = Voucher::with(['created_user', 'updated_user'])
        ->withCount('redemptions')
        ->findOrFail($id);

        $this->simpleColumnData($voucher);
        return response()->json($voucher);
    }
}
