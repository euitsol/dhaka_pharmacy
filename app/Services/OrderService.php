<?php

namespace App\Services;

use App\Models\{AddToCart, Order, Voucher, Address, Medicine, Payment, User};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Services\{OrderTimelineService, VoucherService, AddressService, PaymentService};
use Exception;

class OrderService
{
    private User $user;
    private OrderTimelineService $orderTimelineService;
    private VoucherService $voucherService;
    private Order $order;
    private AddressService $addressService;
    private PaymentService $paymentService;

    public function __construct(OrderTimelineService $orderTimelineService, VoucherService $voucherService, AddressService $addressService, PaymentService $paymentService)
    {
        $this->orderTimelineService = $orderTimelineService;
        $this->voucherService = $voucherService;
        $this->addressService = $addressService;
        $this->paymentService = $paymentService;
    }

    // Set the authenticated user
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

    public function processOrder(array $data,  bool $isDirectOrder = false)
    {
        if (!$this->user) {
            throw new Exception('User not found.');
        }

        return DB::transaction(function () use ($data, $isDirectOrder) {
            $carts = collect(); // Initialize an empty collection

            if ($isDirectOrder) {
                // Handle direct order
                $product = Medicine::with([
                    'units' => function ($query) {
                        $query->select('medicine_units.id', 'medicine_unit_bkdns.price');
                    },
                    'active_discounts',
                ])->where('slug',$data['product_slug'])->first();

                if (!$product) {
                    throw new ModelNotFoundException('Product not found.');
                }

                $unit = $product->units->find($data['unit_id']);
                if (!$unit) {
                    throw new ModelNotFoundException('Unit not found.');
                }

                $carts->push((object)[
                    'product' => $product,
                    'unit_id' => $data['unit_id'],
                    'quantity' => $data['quantity'],
                ]);

            } else {
                // Handle cart-based order (existing logic)
                $carts = AddToCart::with([
                    'product.units' => function ($query) {
                        $query->select('medicine_units.id', 'medicine_unit_bkdns.price');
                    },
                    'product.active_discounts',
                ])->whereIn('id', $data['carts'])
                    ->where('customer_id', $this->user->id)
                    ->get();
            }

            if ($carts->isEmpty()) {
                throw new ModelNotFoundException('No valid data found');
            }

            // Calculate order values
            $subTotal = $this->calculateSubTotal(carts: $carts);
            $voucherDiscount = $this->calculateVoucherDiscount($data['voucher_id'] ?? null, $subTotal);
            $deliveryFee = $this->calculateDeliveryFee($data['address_id'] ?? null);

            // Create order
            $order = Order::create([
                'order_id' => generateOrderId('api'),
                'customer_id' => $this->user->id,
                'customer_type' => get_class($this->user),
                'creater_id' => $this->user->id,
                'creater_type' => get_class($this->user),
                'address_id' => $data['address_id'] ?? null,
                'voucher_id' => $data['voucher_id'] ?? null,
                'sub_total' => $subTotal,
                'voucher_discount' => $voucherDiscount,
                'product_discount' => 0, //will be added later
                'delivery_fee' => $deliveryFee,
                'status' => Order::INITIATED
            ]);

            // Create order items and clear carts
            $this->createOrderItems($order, $carts);
            $this->clearCarts($carts->pluck('id')->toArray());

            // Create ALL timeline entries for this order
            $this->orderTimelineService->createAllTimelineEntries($order);

            return $order;
        });
    }

    public function getOrderDetails(string $orderId, string $timelineType = 'user')
    {
        $order = Order::select(['id','order_id', 'customer_id', 'customer_type', 'address_id', 'voucher_id', 'sub_total', 'voucher_discount', 'product_discount','total_amount', 'delivery_fee','delivery_type', 'status'])->with([
                    'customer:id,name,phone',
                    'products:id,name,slug,status,pro_cat_id,pro_sub_cat_id,company_id,generic_id,strength_id,dose_id,price,image',
                    'products.pro_cat:id,name,slug,status',
                    'products.generic:id,name,slug,status',
                    'products.pro_sub_cat:id,name,slug,status',
                    'products.company:id,name,slug,status',
                    'address:id,name,phone,city,street_address,latitude,longitude,apartment,floor,delivery_instruction,address',
                    'voucher:id,code,type,discount_amount,usage_limit',
                    'timelines.statusRule',
                    'payments:id,order_id,customer_id,customer_type,amount,status,payment_method,transaction_id,creater_id,creater_type'
                ])
            ->where('order_id', $orderId)
            ->first();

        if (!$order) {
            throw new ModelNotFoundException('Order not found.');
        }

        // Authorization check (only if $this->user is set)
        if ($this->user) {
            if (($order->customer_id !== $this->user->id) || ($order->customer_type !== get_class($this->user))) {
                throw new Exception('Unauthorized access to this order.');
            }
        }

        // Process timeline entries based on the requested type.
        if ($timelineType === 'user') {
            $order->setRelation(
                'timelines',
                $this->orderTimelineService->getProcessedTimeline($order, true)
            );
        } else {
            $order->setRelation(
                'timelines',
                $this->orderTimelineService->getProcessedTimeline($order, false)
            );
        }

        return $order;
    }

    public function confirmOrder(array $data):Payment
    {
        $this->setOrder($data['order_id']);
        $this->checkConfirmAbility($this->order);
        $this->paymentService->setOrder($this->order)->setUser($this->user)->setPaymentMethod($data['payment_method']);
        $payment = $this->paymentService->createPayment();
        $this->order->update(['status' => Order::SUBMITTED]);
        $this->orderTimelineService->updateTimelineStatus($this->order, ORDER::SUBMITTED);
        return $payment;
    }

    public function cancelOrder():void
    {
        $this->checkCancelAbility($this->order);
        $this->paymentService->setOrder($this->order)->setUser($this->user)->cancelPayments();
        $this->order->update(['status' => Order::CANCELLED]);
        $this->orderTimelineService->updateTimelineStatus($this->order, currentStatus: ORDER::CANCELLED);
    }

    public function addAddress(string|null $addressId, string|null $deliveryType='standard'):void
    {
        $this->updateOrderDiscounts($this->order, null, $addressId, $deliveryType);
    }

    public function addVoucher(string|null $voucherCode):void
    {
        $this->voucherService->setUser($this->user);
        $this->voucherService->setOrder($this->order->order_id);
        $voucher = $this->voucherService->check($voucherCode);
        $this->updateOrderDiscounts($this->order, $voucher->id, $this->order->address_id);
        $this->voucherService->updateVoucherUsage($voucher, $this->user, $this->order);
    }

    public function updateOrderDiscounts( Order $order,int|null $voucherId = null, int|null $addressId = null, string $deliveryType='standard'):void
    {
        $data = [];
        if($voucherId !== null){
            $data['voucher_id'] = $voucherId;
            $data['voucher_discount'] = $this->calculateVoucherDiscount($data['voucher_id'], $order->sub_total);
        }
        if($addressId !== null){
            $data['address_id'] = $addressId;
            $data['delivery_fee'] = $this->calculateDeliveryFee($data['address_id'], $deliveryType)['charge'];
            $data['delivery_type'] = $this->calculateDeliveryFee($data['address_id'], $deliveryType)['delivery_type'];
        }
        $order->update($data);
    }

    private function calculateSubTotal($carts)
    {
        return $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->units->find($cart->unit_id)->price;
        });
    }

    private function calculateVoucherDiscount(?int $voucherId, float $subTotal)
    {
        if (!$voucherId) return 0;

        $voucher = Voucher::valid()->findOrFail($voucherId);
        return $voucher->calculateDiscount($subTotal);
    }

    private function calculateDeliveryFee(?int $addressId, string $deliveryType='standard'):array
    {
        $this->addressService->setAddress($addressId)->setUser($this->user);
        return $this->addressService->getDeliveryCharge($deliveryType);
    }

    private function createOrderItems(Order $order, $carts)
    {
        $totalDiscount = 0;

        $orderItems = $carts->map(function ($cart) use (&$totalDiscount) {
            $product = $cart->product;
            $unitPrice = $product->units->find($cart->unit_id)->price;
            $quantity = $cart->quantity;

            // Fetch discount from discounts table
            $discount = $product->active_discounts()->where('unit_id', $cart->unit_id)->first();
            $productDiscount = 0;

            if ($discount) {
                if ($discount->discount_percentage) {
                    $productDiscount = ($unitPrice * $discount->discount_percentage) / 100;
                } elseif ($discount->discount_amount) {
                    $productDiscount = $discount->discount_amount;
                }
            }

            $totalDiscount += $productDiscount * $quantity;

            return [
                'product_id' => $product->id,
                'unit_id' => $cart->unit_id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'unit_discount' => $productDiscount,
                'status' => 1,
                'creater_id' => $this->user->id,
                'creater_type' => get_class($this->user),

            ];
        });

        // Attach products with discounts
        $order->products()->attach($orderItems);

        // Update order with total discount
        $order->update(['product_discount' => $totalDiscount]);

        return $order;
    }

    private function clearCarts(array $cartIds)
    {
        AddToCart::whereIn('id', $cartIds)->delete();
    }

    private function checkConfirmAbility(Order $order):void
    {
        if ($order->status != Order::INITIATED) {
            throw new ModelNotFoundException('Order is not in a valid state to confirm');
        }
        if($order->customer_id !== $this->user->id || $order->customer_type !== get_class($this->user)){
            throw new ModelNotFoundException('Order ownership mismatch');
        }
        if(!$order->address){
            throw new ModelNotFoundException('Order address not found');
        }
        if(!$order->products->isNotEmpty()){
            throw new ModelNotFoundException('Order products not found');
        }
        if($order->total_amount <= 0){
            throw new ModelNotFoundException('Order total amount is invalid');
        }
    }
    private function checkCancelAbility(Order $order):void
    {
        if ($order->status != Order::INITIATED && $order->status != Order::SUBMITTED) {
            throw new ModelNotFoundException('Order is not in a valid state to cancel');
        }
        if($order->customer_id !== $this->user->id || $order->customer_type !== get_class($this->user)){
            throw new ModelNotFoundException('Order ownership mismatch');
        }
    }
}
