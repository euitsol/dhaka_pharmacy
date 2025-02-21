<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Hub;
use App\Models\Order;
use App\Services\SteadFastService;
use App\Models\OrderHub;
use Illuminate\Support\Facades\DB;

class OrderDeliveryService
{
    protected SteadFastService $steadFastService;
    protected OrderHub $orderHub;
    protected String $type;

    public function __construct(SteadFastService $steadFastService)
    {
        $this->steadFastService = $steadFastService;
    }

    public function setOrderHub(OrderHub $orderHub):self
    {
        $this->orderHub = $orderHub;
        return $this;
    }

    public function setType(String $type):self
    {
        $this->type = $type;
        return $this;
    }

    public function processDelivery()
    {
        $this->validateDelivery();
        // $delivery = $this->createDelivery($this->orderHub);
        if($this->type === 'steadfast'){
            // $this->steadFastService->setDelivery($delivery)->createShipment();
        }
    }

    public function getDeliveryInfo($hubId, $orderId){
        return Delivery::where('order_id', $orderId)->where('creater_id', $hubId)->where('creater_type', Hub::class)->first();
    }

    public function createDelivery(OrderHub $orderHub): Delivery
    {
        $orderHub->load('order');
        return DB::transaction(function () use ($orderHub) {
            $invoice = $this->generateInvoice($orderHub);
            $recipientCredentials = $this->prepareRecipientCredentials($orderHub);

            return Delivery::create([
                'type' => $this->type,
                'order_id' => $orderHub->order_id,
                'invoice' => $invoice,
                'payload' => json_encode([
                    'invoice' => $invoice,
                    'recipient_name' => $recipientCredentials['name'],
                    'recipient_phone' => $recipientCredentials['phone'],
                    'recipient_address' => $recipientCredentials['address'],
                    'cod_amount' => $orderHub->order->pament_status === Order::PAYMENT_COD ? $orderHub->order->total_amount : 0,
                    'note' => $recipientCredentials['note'],
                ]),

                'receiver_id' => $orderHub->order->customer->id,
                'receiver_type' => get_class($orderHub->order->customer),

                'address_id' => $orderHub->order->address->id,
                'created_at' => now(),
                'creater_id' => $orderHub->hub_id,
                'creater_type' => Hub::class
            ]);
        });
    }

    protected function prepareRecipientCredentials(OrderHub $orderHub): array
    {
        $orderHub->load(['order', 'order.customer', 'order.address']);
        $address = $orderHub->order->address;
        $note = $orderHub->order->address->delivery_instruction ?? '';

        $components = [
            $address->address,
            $address->city,
            $address->apartment ? "Flat# {$address->apartment}" : null,
            $address->floor ? "Floor# {$address->floor}" : null,
            $address->street_address ? "Street# {$address->street_address}" : null,

        ];

        $fullAddress = implode(', ', array_filter($components));

        if (strlen($fullAddress) > 230) {
            $fullAddress = substr($fullAddress, 0, 230);
        }

        if(strlen($note) > 230){
            $note = substr($note, 0, 230);
        }

        return [
            'name' => $orderHub->order->customer->name ?? config('app.name').' Customer',
            'phone' => $orderHub->order->customer->phone,
            'address' => $fullAddress,
            'note' => $note
        ];
    }


    protected function generateInvoice(OrderHub $orderHub): string
    {
        $prefix = 'DEL'. $orderHub->hub_id;
        $datePart = now()->format('ym');

        // Get the latest invoice number for current month
        $latestInvoice = Delivery::latest()->first();

        if ($latestInvoice) {
            $lastNumber = (int) substr($latestInvoice->id, -5);
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '00001';
        }

        return "{$prefix}{$datePart}{$nextNumber}";
    }

    public function validateDelivery()
    {
        if(!$this->orderHub){
            throw new \InvalidArgumentException("Order hub not found");
        }

        if(!$this->type || $this->type !== 'steadfast'){
            throw new \InvalidArgumentException("Type not found");
        }

        $this->orderHub->load('order', 'hub');
        if(!$this->orderHub->order){
            throw new \InvalidArgumentException("Order not found");
        }

        if(!$this->orderHub->hub){
            throw new \InvalidArgumentException("Hub not found");
        }

        if($this->orderHub->status != OrderHub::PREPARED){
            throw new \InvalidArgumentException("Order must be in Prepared status to process delivery");
        }

        if(!$this->orderHub->order->customer){
            throw new \InvalidArgumentException("Order customer not found");
        }

        if(!$this->orderHub->order->address){
            throw new \InvalidArgumentException("Order address not found");
        }

    }
}
