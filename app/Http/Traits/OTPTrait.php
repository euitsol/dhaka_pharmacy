<?php

namespace App\Http\Traits;

use App\Models\DeliveryOtp;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

trait OTPTrait{

    public function generateDeliveryOtp(array $data)
    {
        $this->disablePreviousOtps($data['order_distribution_id']);

        $do = new DeliveryOtp;
        $do->order_distribution_id = $data['order_distribution_id'];
        $do->user_id = $data['user_id'];
        $do->otp = otp();
        $do->status = 1;
        $do->created_by = $data['user_id'];
        $do->save();

        return $do;
    }

    public function disablePreviousOtps($od_id)
    {
        DeliveryOtp::where('order_distribution_id', $od_id)->activated()->update(['status' => -1]);
    }

}
