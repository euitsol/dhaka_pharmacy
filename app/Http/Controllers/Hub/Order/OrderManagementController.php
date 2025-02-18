<?php

namespace App\Http\Controllers\Hub\Order;

use App\Http\Controllers\Controller;
use App\Models\{Hub, Order, OrderHub};
use App\Services\OrderManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderManagementController extends Controller
{
    protected OrderManagementService $orderManagementService;

    public function __construct(OrderManagementService $orderManagementService)
    {
        $this->orderManagementService = $orderManagementService;
    }

    public function list($status)
    {
        $data['status'] = (string)$status;
        $data['status_bg'] = $this->orderManagementService->resolveStatusBg($status);

        switch ($status) {
            case 'assigned':
                $data['ohs'] = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub(staff()->hub->id)->where('status', OrderHub::ASSIGNED)->latest()->get();
                return view('hub.order.list', $data);
            default:
                flash()->addWarning('Invalid status');
                return redirect()->back();
        }
    }

}
