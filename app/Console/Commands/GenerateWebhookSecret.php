<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateWebhookSecret extends Command
{
    protected $signature = 'steadfast:generate-secret';
    protected $description = 'Generate a new webhook secret for Steadfast and update the .env file';

    public function handle()
    {
        $key = 'STEADFAST_WEBHOOK_SECRET';
        $currentSecret = env($key);

        if (!empty($currentSecret)) {
            $this->info('Webhook secret already exists in .env file.');
            $this->line('If you want to generate a new secret, please remove the existing one from .env first.');
            return;
        }

        $newSecret = Str::random(40);
        $envPath = app()->environmentFilePath();
        $lines = file($envPath, FILE_IGNORE_NEW_LINES);
        $newLine = "{$key}=\"{$newSecret}\"";

        $updated = false;
        foreach ($lines as $index => $line) {
            if (str_starts_with($line, "{$key}=")) {
                $lines[$index] = $newLine;
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $lines[] = $newLine;
        }

        // Write the content back to the .env file
        $content = implode(PHP_EOL, $lines);
        file_put_contents($envPath, $content . PHP_EOL);

        $this->info('New webhook secret generated and saved to .env file.');
        $this->warn('Please clear your configuration cache with "php artisan config:clear" if needed.');
    }
}
