<?php

namespace App\Services;

use App\Models\{User, Order, Payment};
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentService
{
    protected User $user;
    protected Order $order;
    protected string $paymentMethod;

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function createPayment():Payment
    {
        $this->cancelPayments();
        return Payment::create([
            'order_id' => $this->order->id,
            'transaction_id' => $this->generateTranId(),
            'customer_id' => $this->user->id,
            'customer_type' => get_class($this->user),
            'payment_method' => $this->paymentMethod,
            'amount' => $this->order->total_amount,
            'status' => Payment::STATUS_PAID,
            'creater_id' => $this->user->id,
            'creater_type' => get_class($this->user)
        ]);
    }

    protected function validate()
    {
        if (!$this->order) {
            throw new ModelNotFoundException('Order not found');
        }
        if (!$this->user) {
            throw new ModelNotFoundException('User not found');
        }
    }

    protected function generateTranId(): string
    {
        $prefix = strtoupper($this->paymentMethod);
        $numericPart = mt_rand(100000, 999999);
        $date = date('d');

        return $prefix . $date . $numericPart . str_pad($this->order->id, 5, '0', STR_PAD_LEFT);
    }

    public function cancelPayments():void
    {
        $this->order->payments()->update(['status' => Payment::STATUS_CANCELLED]);
    }
}


