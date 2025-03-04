<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BgRemoveService
{
    public function removeBackground($inputPath, $outputPath)
    {
        if (!file_exists($inputPath)) {
            throw new \InvalidArgumentException("Input file does not exist: {$inputPath}");
        }

        $pythonScript = base_path('pyEngine/bg_remover.py');
        $command = [
            base_path('pyEngine/venv/bin/python'), // Use full path to python executable
            $pythonScript,
            $inputPath,
            $outputPath
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $outputPath;
    }
}
