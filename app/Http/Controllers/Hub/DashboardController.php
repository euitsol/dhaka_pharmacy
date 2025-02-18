<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\HubStaff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('staff');
    }
    public function dashboard(): View
    {
        $data['hub'] = Hub::withCount('staffs')->findOrFail(staff()->id);
        return view('hub.dashboard.dashboard', $data);
    }
}
