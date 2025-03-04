<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDescriptionJob;
use App\Models\Medicine;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateDescription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medicine:generate-description
                            {medicineId : Required ID of a specific medicine}
                            {--force : Force reprocess even if already have description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate description for a medicine';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $medicineId = $this->argument(key: 'medicineId');
        $force = $this->option('force');

        if(!$medicineId){
            $this->error("Medicine with ID is required");
            return;
        }else{
            $medicine = Medicine::find($medicineId);
            if (!$medicine) {
                $this->error("Medicine with ID $medicineId not found");
                return;
            }
            GenerateDescriptionJob::dispatch($medicine, $force);
            Log::info("Dispatched job to generate description for medicine ID: $medicineId and force: $force");
        }

    }
}
