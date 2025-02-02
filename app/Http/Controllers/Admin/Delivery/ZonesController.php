<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\DeliveryZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ZonesController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct() {
        $this->middleware('admin');
    }

    public function index(): View
    {
        $data['zones'] = DeliveryZone::with(['cities'])->orderBy('id', 'asc')->get();
        return view('admin.delivery.zones.index', $data);
    }
}
