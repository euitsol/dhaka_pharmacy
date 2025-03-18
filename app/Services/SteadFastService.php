<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\OrderHub;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Throw_;
use SteadFast\SteadFastCourierLaravelPackage\SteadfastCourier;

class SteadFastService
{
    protected SteadfastCourier $steadFastCourier;
    protected Delivery $delivery;

    public function __construct(SteadfastCourier $steadFastCourier)
    {
        $this->steadFastCourier = $steadFastCourier;
    }

    public function setDelivery(Delivery $delivery): self
    {
        $this->delivery = $delivery;
        return $this;
    }
    public function createShipment():void
    {
        $this->validateDelivery();
        try {
            $response = $this->steadFastCourier->placeOrder([
                'invoice' => json_decode($this->delivery->payload)->invoice,
                'recipient_name' => json_decode($this->delivery->payload)->recipient_name,
                'recipient_phone' => json_decode($this->delivery->payload)->recipient_phone,
                'recipient_address' => json_decode($this->delivery->payload)->recipient_address,
                'cod_amount' => json_decode($this->delivery->payload)->cod_amount,
                'note' => json_decode($this->delivery->payload)->note
            ]);
            $this->updateDelivery($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function validateDelivery():void
    {
        if(!isset($this->delivery) || !($this->delivery instanceof Delivery)){
            throw new \InvalidArgumentException("Delivery not found");
        }
        if(!$this->delivery->payload){
            throw new \InvalidArgumentException("Payload not found");
        }
    }

    private function updateDelivery($response): void
    {
        $status = '';
        $trackingId = null;

        if (isset($response['status']) && $response['status'] === 200 &&
            isset($response['consignment']['status'])) {
            $status = $response['consignment']['status'];
            $trackingId = $response['consignment']['consignment_id'];
        }

        $this->delivery->update([
            'response' => json_encode($response),
            'tracking_id' => $trackingId,
            'status_code' => $status,
        ]);
    }



    public function refreshShipment()
    {
        $this->validateDelivery();
        try {
            $response = $this->steadFastCourier->checkDeliveryStatusByConsignmentId($this->delivery->tracking_id);
            if(isset($response['status']) && $response['status'] === 200){
                // $this->updateDelivery($response);
                $this->handleRefreshResponse($response);
            }else{
                Log::error("Error refreshing shipment: ".json_encode($response));
                throw new Exception("Error refreshing shipment");
            }
        } catch (Exception $th) {
            throw $th;
        }
    }

    protected function handleRefreshResponse($response)
    {
        $status = '';

        if (isset($response['status']) && $response['status'] === 200 &&
            isset($response['consignment']['status'])) {
            $status = $response['consignment']['status'];
        }

        $this->delivery->update([
            'status_code' => $status,
        ]);
    }
}
