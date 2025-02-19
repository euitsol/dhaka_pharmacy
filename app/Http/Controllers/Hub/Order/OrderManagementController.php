<?php

namespace App\Http\Controllers\Hub\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hub\ItemCollectRequest;
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
                $data['ohs'] = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub()->where('status', $this->orderHubManagementService->resolveStatus($status))->get();
                return view('hub.order.list', $data);
            case 'collecting':
                $data['ohs'] = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub()->where('status', $this->orderHubManagementService->resolveStatus($status))->get();
                return view('hub.order.list', $data);
            default:
                flash()->addWarning('Invalid status');
                return redirect()->back();
        }
    }

    public function details($id)
    {
        $data['oh'] = OrderHub::with(['hub', 'orderhubproducts.product', 'order'])->ownedByHub()->where('id', decrypt($id))->get()->first();
        // dd($data['oh']->toArray());
        $data['pharmacies'] = Pharmacy::activated()->latest()->get();
        try{
            $data['timelines'] = $this->orderTimelineService->getHubProcessedTimeline($data['oh']->order);
        }catch(\Exception $e){
            flash()->addError($e->getMessage());
            return redirect()->back();
        }
        return view('hub.order.details', $data);
    }

    public function collecting($id)
    {
        $id = decrypt($id);
        try{
            $orderHub = OrderHub::with(['order', 'hub', 'order.products'])->ownedByHub()->where('order_id', $id)->get()->first();

            $this->orderHubManagementService->setOrderHub($orderHub);
            $this->orderHubManagementService->collecting();
            sweetalert()->addSuccess('You have successfully entered into the collecting stage.');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->addError($e->getMessage());
            return redirect()->back();
        }
    }

    public function collected(ItemCollectRequest $request)
    {
        dd($request->all());
    }
}
