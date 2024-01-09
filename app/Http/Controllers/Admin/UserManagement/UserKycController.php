<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\SubmittedKyc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserKycController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }

    public function index(){
        $s['datas'] = SubmittedKyc::where('type','user')->latest()->get();
        $s['count']= $s['datas']->map(function($data){
            return count(json_decode($data->submitted_data,true));
        });
        return view('admin.user_management.submitted_kyc.index',$s);

    }

}
