<?php

namespace App\Services;

use App\Models\TempFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileUploadService
{
    protected $disk;

    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk;
    }

    public function moveFromTemp(?int $tempFileId, string $destinationPath, string $filename): ?string
    {
        if (empty($tempFileId)) {
            Log::warning('No temp file ID provided');
            return null;
        }

        $tempFile = TempFile::find($tempFileId);
        if (!$tempFile) {
            Log::warning('Temp file not found', ['temp_file_id' => $tempFileId]);
            return null;
        }

        if (empty($tempFile->path) || empty($tempFile->filename)) {
            Log::error('Temp file has no path or filename', [
                'temp_file_id' => $tempFileId,
                'path' => $tempFile->path,
                'filename' => $tempFile->filename
            ]);
            return null;
        }

        $fullSourcePath = rtrim($tempFile->path, '/') . '/' . $tempFile->filename;
        
        if (!Storage::disk($this->disk)->exists($fullSourcePath)) {
            Log::error('Temp file does not exist in storage', [
                'temp_file_id' => $tempFileId,
                'full_path' => $fullSourcePath
            ]);
            $tempFile->delete(); // Clean up invalid record
            return null;
        }

        try {
            $file = Storage::disk($this->disk)->get($fullSourcePath);
            $extension = pathinfo($tempFile->filename, PATHINFO_EXTENSION);
            $fullFilename = $filename . '.' . $extension;
            $fullPath = $destinationPath . '/' . $fullFilename;

            Storage::disk($this->disk)->put($fullPath, $file);
            Storage::disk($this->disk)->delete($fullSourcePath);
            $tempFile->delete();

            Log::info('File moved to permanent storage', [
                'from' => $fullSourcePath,
                'to' => $fullPath
            ]);

            return $fullPath;
        } catch (\Exception $e) {
            Log::error('Error moving file from temp storage', [
                'temp_file_id' => $tempFileId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}
