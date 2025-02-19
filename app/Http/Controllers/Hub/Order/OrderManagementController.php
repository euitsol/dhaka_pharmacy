<?php

namespace App\Http\Controllers\Hub\Order;

use App\Http\Controllers\Controller;
use App\Models\{Hub, Order, OrderHub, Pharmacy};
use App\Services\{OrderHubManagementService, OrderTimelineService};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderManagementController extends Controller
{
    protected OrderHubManagementService $orderHubManagementService;
    protected OrderTimelineService $orderTimelineService;

    public function __construct(OrderHubManagementService $orderHubManagementService, OrderTimelineService $orderTimelineService)
    {
        $this->orderHubManagementService = $orderHubManagementService;
        $this->orderTimelineService = $orderTimelineService;
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
        $data['pharmacies'] = Pharmacy::activated()->latest()->get();
        try{
            $data['timelines'] = $this->orderTimelineService->getHubProcessedTimeline($data['oh']->order);
        }catch(\Exception $e){
            flash()->addError($e->getMessage());
            return redirect()->back();
        }
        return view('hub.order.details', $data);
    }

    public function collect($id)
    {
        $id = decrypt($id);
        try{
            $orderHub = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub(staff()->hub->id)->findOrFail($id);
            $this->orderHubManagementService->setOrderHub($orderHub);
            $this->orderHubManagementService->collect();
            flash()->addSuccess('Order collected successfully');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->addError($e->getMessage());
            return redirect()->back();
        }
    }
}
