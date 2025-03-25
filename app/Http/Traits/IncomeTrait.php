<?php

namespace App\Http\Traits;

use App\Models\Earning;
use App\Models\PointHistory;

trait IncomeTrait
{
    /**
     * Adds income to the database.
     *
     * @param mixed $receiver The model instance of the income receiver.
     * @param float $amount The amount of income.
     * @param string $amount_type The unit of $amount. 'point' or 'tk'.
     * @param int $order_id [optional] The order id associated with the income.
     *
     * @return void
     */
    private function addIncome($receiver, $amount, $amount_type, $order_id = Null)
    {
        $ph = PointHistory::activated()->first();
        $earning = new Earning();
        if ($amount_type == 'point') {
            $earning->point = $amount;
            $earning->eq_amount = $amount * $ph->eq_amount;
        } elseif ($amount_type == 'tk') {
            $earning->point = $amount / $ph->eq_amount;
            $earning->eq_amount = $amount;
        }
        $earning->activity = 0;
        $earning->receiver()->associate($receiver);
        // $earning->order_id = $order_id;
        $earning->ph_id = $ph->id;
        $earning->description = 'Income is pending clearance';
        $earning->save();
    }
}
