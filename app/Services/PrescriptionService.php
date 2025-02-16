<?php

namespace App\Services;

use App\Models\OrderPrescription;
use App\Models\Prescription;
use App\Models\PrescriptionImage;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Instanceof_;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrescriptionService
{
    protected ?User $user=null;
    protected ?Prescription $prescription=null;
    protected ?OrderPrescription $orderPrescription=null;

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setUserByPhone(int $phone): self|null
    {
        $user = User::where('phone', $phone)->first();
        if($user){
            $this->user = $user;
            return $this;
        }return null;
    }

    public function setPrescription(int $prescriptionId): self
    {
        $prescription = Prescription::with('images')->where('id', $prescriptionId)->first();
        if(!$prescription){
            throw new ModelNotFoundException("Prescription not found");
        }
        $this->prescription = $prescription;
        return $this;
    }

    public function setOrderPrescription(int $op_id): self
    {
        $orderPrescription = OrderPrescription::with('prescription')->where('id', $op_id)->first();
        if(!$orderPrescription){
            throw new ModelNotFoundException("Order Prescription not found");
        }
        $this->orderPrescription = $orderPrescription;
        return $this;
    }

    public function processPrescription(array $data, bool $create_order = false): Prescription
    {
        $this->setUserByPhone($data['phone']);
        $prescription = $this->createPrescription($data);
        foreach($data['uploaded_image'] as $image){
            $this->updatePrescriptionImage($image, ['status' => 1, 'prescription_id' => $prescription->id]);
        }

        if($create_order){
            $this->createOrderPrescription($prescription);
        }
        return $prescription;
    }

    public function uploadPrescriptionImage(UploadedFile $file): array
    {
        $uuid = Str::uuid();
        $extension = $file->getClientOriginalExtension();

        $tempPath = $this->generateTempPath( $uuid, $extension);
        $path = $file->storeAs(
            dirname($tempPath),
            basename($tempPath),
            'public'
        );

        if (!$path) {
            throw new RuntimeException('Failed to upload file');
        }

        $image = $this->createPrescriptionImage($path);

        return [
            'id' => $image->id,
            'path' => storage_url($image->path),
            'status' => $image->status,
        ];
    }

    public function createPrescriptionImage($path):PrescriptionImage|Exception
    {
        $image = PrescriptionImage::create([
            'path' => $path,
            'status' => 0,
        ]);
        return $image;
    }

    public function updatePrescriptionImage(int $id, array $data): void
    {
        PrescriptionImage::findOrFail($id)->update($data);
    }

    public function createPrescription(array $data): Prescription
    {
        return DB::transaction(function () use ($data) {
            if(isset($this->user) && $this->user instanceof User)
            {
                $data['creater_id'] = $this->user->id;
                $data['creater_type'] = get_class($this->user);
            }
            $data['status'] = 0;

            $prescription = Prescription::create($data);

            $this->prescription = $prescription;
            return $prescription;
        });
    }

    public function getOrderPrescriptions(int $status): Collection
    {
        return OrderPrescription::with(['order', 'prescription', 'prescription.images', 'creater' ])
                ->where('status', $status)->get();
    }

    public function getOrderPrescriptionsDetails(): OrderPrescription
    {
        if(isset($this->orderPrescription) && $this->orderPrescription instanceof OrderPrescription){
            return $this->orderPrescription->load(['order', 'prescription', 'prescription.images', 'creater' ]);
        }
        throw new ModelNotFoundException("Order Prescription not found");
    }

    protected function createOrderPrescription(Prescription $prescription): void
    {
        DB::transaction(function () use ($prescription) {
            OrderPrescription::create([
                'prescription_id' => $prescription->id,
                'status' => 0,
                'creater_id' => $this->user->id ?? null,
                'creater_type' => $this->user ? get_class($this->user) : null,
            ]);
        });
    }

    protected function generateTempPath(string $uuid, string $extension = ''): string
    {
        $filename = $extension ? "$uuid.$extension" : $uuid;
        return "temp/prescriptions/$uuid/$filename";
    }

    protected function generatePermanentPath(string $uuid): string
    {
        return "prescriptions/" . date('Y/m') . "/$uuid";
    }

    public function cleanupExpiredTempFiles(string $uuid): void
    {
        Storage::disk('public')
            ->deleteDirectory("temp/prescriptions/$uuid");
    }

    public function resolveStatus(string $status): int
    {
        return match ($status) {
            'pending' => OrderPrescription::STATUS_PENDING,
            'accepted' => OrderPrescription::STATUS_ACCEPTED,
            'rejected' => OrderPrescription::STATUS_REJECTED,
            default => throw new \InvalidArgumentException("Invalid status: $status"),
        };
    }

// Helper method to get human-readable status text
    public function getStatusText(int $status): string
    {
        return match ($status) {
            OrderPrescription::STATUS_PENDING => 'Pending',
            OrderPrescription::STATUS_ACCEPTED => 'Accepted',
            OrderPrescription::STATUS_REJECTED => 'Rejected',
            default => 'Unknown',
        };
    }
}
