<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\OperationArea;
use Illuminate\View\View;


class OperationalAreaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('rider');
    }
    public function index(): View
    {
        $data['operational_areas'] = OperationArea::with(['operation_sub_areas', 'creater'])->activated()->orderBy('name')->get();
        return view('rider.operational_area.index', $data);
    }
}
