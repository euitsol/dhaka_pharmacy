<?php

namespace App\Http\Controllers\Admin\HubManagement;

use App\Http\Controllers\Controller;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class HubStaffController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct() {
        return $this->middleware('admin');
    }

    public function details($id): JsonResponse
    {
        $data = User::with('role')->findOrFail($id);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
}
