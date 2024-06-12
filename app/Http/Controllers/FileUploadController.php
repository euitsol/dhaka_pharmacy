<?php

namespace App\Http\Controllers;

use App\Models\TempFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function uploads(Request $request)
    {
        if ($request->hasFile($request->name)) {
            $file = $request->file($request->name);
            $filename = $file->getClientOriginalName();
            $folder = uniqid();
            $file->storeAs('file/tmp/' . $folder, $filename, 'public');
            $path = "file/tmp/" . $folder;

            $save = new TempFile();
            $save->path = $path;
            $save->filename = $filename;
            $save->created_at = Carbon::now()->toDateTimeString();
            $creater = $this->getCreator($request->creatorType);
            $save->creater()->associate($creater);
            $save->save();
            return $save->id;
        }
        return $request->name;
    }

    public function deleteTempFile()
    {

        $temp_file = TempFile::findOrFail(request()->getContent());
        if ($temp_file) {
            Storage::deleteDirectory('public/' . $temp_file->path);
            $temp_file->forceDelete();
            return response()->json(['message' => 'Revert success']);
        }
    }

    // public function resetFilePond(Request $request)
    // {
    //     $fileId = $request->input('fileId');
    //     dd($fileId);
    //     $temp_file = TempFile::findOrFail($fileId);
    //     if ($temp_file) {
    //         Storage::deleteDirectory('public/' . $temp_file->path);
    //         $temp_file->forceDelete();
    //         return response()->json(['message' => 'Revert success']);
    //     }
    // }


    private function getCreator($creatorType)
    {
        switch ($creatorType) {
            case 'user':
                return user();
            case 'admin':
                return admin();
            case 'pharmacy':
                return pharmacy();
            case 'rider':
                return rider();
            case 'lam':
                return lam();
            case 'dm':
                return dm();
        }
    }
}
