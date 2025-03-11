<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class ExtractTranslations extends Command
{
    protected $signature = 'translations:extract';
    protected $description = 'Extract translation strings into JSON file for Bengali translations';

    public function handle()
    {
        $strings = [];

        // Define directories to search (adjust as needed)
        $directories = [
            app_path('Http/Controllers/Frontend'),
            // app_path('Http/Controllers/User'),
            app_path('Http/Controllers/Auth'),
            resource_path('views/frontend'),
            // resource_path('views/user'),
            resource_path('views/auth'),
        ];

        $finder = (new Finder())
            ->in($directories)
            ->name('*.php')
            ->name('*.blade.php')
            ->files();

        foreach ($finder as $file) {
            $content = $file->getContents();
            // Match all __("...") and __('...') occurrences
            preg_match_all('/__\(\s*[\'"](.+?)[\'"]\s*\)/s', $content, $matches);
            foreach ($matches[1] as $string) {
                $strings[] = $string;
            }
        }

        $strings = array_unique($strings);

        $locale = 'bn';
        $langFile = lang_path("{$locale}.json");

        // Load existing translations
        $existingTranslations = [];
        if (file_exists($langFile)) {
            $existingTranslations = json_decode(file_get_contents($langFile), true) ?: [];
        }

        // Merge new strings without overwriting existing ones
        foreach ($strings as $string) {
            if (!isset($existingTranslations[$string])) {
                $existingTranslations[$string] = '';
            }
        }

        // Sort translations alphabetically
        // ksort($existingTranslations);

        // Save the translations
        if (!is_dir(lang_path())) {
            mkdir(lang_path(), 0755, true);
        }

        file_put_contents(
            $langFile,
            json_encode($existingTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );

        $this->info("Translation strings extracted and saved to {$langFile}. Review and add Bengali translations.");
    }
}
