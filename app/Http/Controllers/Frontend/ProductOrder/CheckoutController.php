<?php

namespace App\Http\Controllers\Frontend\ProductOrder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CheckoutController extends BaseController
{
    function checkout(){
        return view('frontend.product_order.checkout');
    }
}
