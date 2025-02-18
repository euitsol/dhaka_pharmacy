<?php

namespace App\Http\Controllers\Hub\Order;

use App\Http\Controllers\Controller;
use App\Models\{Hub, Order, OrderHub};
use App\Services\OrderHubManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderManagementController extends Controller
{
    protected OrderHubManagementService $orderHubManagementService;

    public function __construct(OrderHubManagementService $orderHubManagementService)
    {
        $this->orderHubManagementService = $orderHubManagementService;
    }

    public function list($status)
    {
        $data['status'] = (string)$status;
        $data['status_bg'] = $this->orderHubManagementService->resolveStatusBg($status);

        switch ($status) {
            case 'assigned':
                $data['ohs'] = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub(staff()->hub->id)->where('status', $this->orderHubManagementService->resolveStatus($status))->get();
                return view('hub.order.list', $data);
            default:
                flash()->addWarning('Invalid status');
                return redirect()->back();
        }
    }

    public function details($id)
    {
        $data['oh'] = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub(staff()->hub->id)->findOrFail(decrypt($id));

        return view('hub.order.details', $data);
    }
}
