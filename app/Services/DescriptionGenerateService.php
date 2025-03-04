<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DescriptionGenerateService
{
    public function generateProductDescription($data)
    {
        $jsonInput = escapeshellarg(json_encode($data));

        $pythonScript = base_path('pyEngine/description_generator.py');

        $command = [
            base_path('pyEngine/venv/Scripts/python'), // Use full path to python executable
            $pythonScript,
            json_encode($data),
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = json_decode($process->getOutput(), true);

        if (isset($output['error'])) {
            throw new \Exception("AI Generation Error: " . $output['error']);
        }

        return $output;
    }
}
