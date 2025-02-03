<?php

namespace App\Services;

use App\Models\{Voucher, User, VoucherRedemption, Order};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class VoucherService
{
    protected User $user;
    protected Order $order;


    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setOrder(string|null $order_id): self
    {
        $order = Order::where('order_id', $order_id)->first();
        if (!$order) {
            throw new ModelNotFoundException('Invalid order id');
        }
        $this->order = $order;
        return $this;
    }

    public function check(string|null $code):Voucher|ModelNotFoundException|Exception
    {
        return DB::transaction(function () use ($code): Voucher {
            $voucher = Voucher::select('id', 'code', 'type', 'discount_amount', 'min_order_amount', 'starts_at', 'expires_at', 'usage_limit', 'user_usage_limit', 'status')
                ->where('code', $code)
                ->first();
            if(empty($voucher)){
                throw new ModelNotFoundException('Invalid voucher code');
            }

            $validityCheck = $this->checkValidity($voucher);

            if (!$validityCheck['valid']) {
                throw new ModelNotFoundException($validityCheck['message']);
            }
            return $voucher;
        });
    }

    private function checkValidity(Voucher $voucher): array
    {
        // Basic voucher state checks
        if ($voucher->status != Voucher::STATUS_ACTIVE) {
            return ['valid' => false, 'message' => 'Voucher is inactive'];
        }

        if (!$voucher->isActivePeriod()) {
            return ['valid' => false, 'message' => 'Voucher is not within valid date range'];
        }

        // Usage limits checks
        if ($voucher->hasReachedUsageLimit()) {
            return ['valid' => false, 'message' => 'Voucher usage limit reached'];
        }

        // User-specific checks
        if($this->user){
            if ($voucher->hasUserReachedLimit($this->user->id)) {
                return ['valid' => false, 'message' => 'You have reached your usage limit for this voucher'];
            }
        }

        //Order-specific checks
        if($this->order){
            if (!$voucher->isMinOrderAmountReached($this->order)) {
                return ['valid' => false, 'message' => 'Minimum order amount not met'];
            }
        }
        return ['valid' => true, 'message' => ''];
    }

    public function updateVoucherUsage(Voucher $voucher, User $user, Order $order): void
    {
        $voucher->redemptions()->forceDelete();
        $voucher->redemptions()->create([
            'voucher_id' => $voucher->id,
            'user_id' => $user->id,
            'order_id' => $order->id,
        ]);
    }
}
