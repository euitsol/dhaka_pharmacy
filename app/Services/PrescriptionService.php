<?php

namespace App\Services;

use App\Models\Prescription;
use App\Models\PrescriptionImage;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Instanceof_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrescriptionService
{
    protected User $user;
    protected Prescription $prescription;

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setPrescription(int $prescriptionId): self
    {
        $prescription = Prescription::with('images')->where('id', $prescriptionId)->first();
        if(!$prescription){
            throw new NotFoundHttpException("Prescription not found");
        }
        $this->prescription = $prescription;
        return $this;
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
            throw new \RuntimeException('Failed to upload file');
        }

        if(!isset($this->prescription) || !$this->prescription instanceof Prescription){
            $this->prescription = $this->createPrescription([]);
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
        if(isset($this->prescription) && $this->prescription instanceof Prescription){
            $image = PrescriptionImage::create([
                'prescription_id' => $this->prescription->id,
                'path' => $path,
            ]);
            return $image;
        }
        return new Exception("Prescription not found");

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

    // public function createPrescriptionOrder(array $data, int $userId): Order
    // {
    //     return DB::transaction(function () use ($data, $userId) {
    //         $order = Order::create($data['order_data']);

    //         foreach ($data['file_uuids'] as $uuid) {
    //             $this->processFile($uuid, $order, $userId);
    //         }

    //         return $order->load('prescriptionImages');
    //     });
    // }

    protected function processFile(string $uuid, Order $order, int $userId): void
    {
        $tempPath = $this->generateTempPath($userId, $uuid);
        $newPath = $this->generatePermanentPath($uuid);

        if (!Storage::disk('s3')->exists($tempPath)) {
            throw new NotFoundHttpException("File not found for UUID: $uuid");
        }

        Storage::disk('s3')->move($tempPath, $newPath);

        PrescriptionImage::create([
            'prescription_id' => $order->id,
            'path' => $newPath,
        ]);
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
}
