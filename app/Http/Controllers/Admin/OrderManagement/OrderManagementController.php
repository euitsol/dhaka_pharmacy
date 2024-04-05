<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class OrderManagementController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }
    public function index($status): View
    {
        
        $data['orders'] = Order::with(['address','customer','ref_user'])->status($status)->latest()->get();
        $data['status'] = ucfirst($status);
        return view('admin.order_management.index',$data);
    }

    
}
