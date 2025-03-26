<?php

namespace App\Http\Controllers\LAM;

use App\Http\Controllers\Controller;
use App\Models\OperationArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OperationalAreaController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('lam');
    }
    public function index(): View
    {
        $data['operational_areas'] = OperationArea::with([
            'creater',
            'operation_sub_areas' => function ($query) {
                $query->whereIn('status', [0, 1]);
            }
        ])->whereHas('operation_sub_areas', function ($query) {
            $query->whereIn('status', [0, 1]);
        })->activated()->orderBy('name')->get();
        return view('local_area_manager.operational_area.index', $data);
    }
}