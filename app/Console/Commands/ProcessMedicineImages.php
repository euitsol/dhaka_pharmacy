<?php

namespace App\Console\Commands;

use App\Jobs\ProcessImageJob;
use App\Models\Medicine;
use Illuminate\Console\Command;
use App\Services\BgRemoveService;

class ProcessMedicineImages extends Command
{
    protected $signature = 'medicine:process-images
                            {medicineId? : Optional ID of a specific medicine}
                            {--force : Force reprocess even if already marked}';
    protected $description = 'Process images for active medicines';

    public function handle()
    {
        $medicineId = $this->argument(key: 'medicineId');
        $force = $this->option('force');

        // $query = Medicine::where('status', Medicine::STATUS_ACTIVE)
        $query = Medicine::with(relations: 'processedImage')->whereNotNull('image')->featured()->activated()
            ->when($medicineId, fn($q) => $q->where('id', $medicineId))
            ->when(!$force, function($q) {
                $q->where(function($query) {
                    $query->whereDoesntHave('processedImage')
                        ->orWhereHas('processedImage', function($q) {
                            $q->whereIn('status', [0, -1]);
                        });
                });
            })->take(10);

        $query->chunkById(100, function ($medicines) use ($force) {
            foreach ($medicines as $index=>$medicine) {
                ProcessImageJob::dispatch($medicine, $force)->delay(now()->addSeconds(5*$index));
            }
        });
    }
}
