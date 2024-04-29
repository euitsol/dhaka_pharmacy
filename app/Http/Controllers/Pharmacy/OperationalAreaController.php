<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\OperationArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OperationalAreaController extends Controller
{
    public function __construct() {
        return $this->middleware('pharmacy');
    }
    public function index(): View
    {
        $data['operational_areas'] = OperationArea::with(['operation_sub_areas', 'creater'])->activated()->orderBy('name')->get();
        return view('pharmacy.operational_area.index', $data);
    }
}
