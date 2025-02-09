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

    public function setUserByPhone(int $phone): self
    {
        $user = User::where('phone', $phone)->first();
        if($user){
            $this->user = $user;
        }else{

        }
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

    public function processPrescription(array $data): Prescription
    {
        $this->setUserByPhone($data['phone']);
        $prescription = $this->createPrescription($data);
        foreach($data['uploaded_image'] as $image){
            $this->updatePrescriptionImage($image, ['status' => 1, 'prescription_id' => $prescription->id]);
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
            throw new \RuntimeException('Failed to upload file');
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
