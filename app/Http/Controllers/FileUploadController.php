<?php

namespace App\Http\Controllers;

use App\Models\SubmittedKyc;
use App\Models\TempFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    /**
     * Deletes a KYC file based on the provided request parameters.
     *
     * @param Request $request The request containing the file path, ID, and key.
     * @return void
     */
    public function kycFileDelete(Request $request)
    {
        $file_path = $request->get('url') ? decrypt($request->get('url')) : null;
        $id = $request->get('id') ? decrypt($request->get('id')) : null;
        $key = $request->get('key') ?? null;

        if ($file_path) {
            $acc_file_path = $file_path;

            if (!Str::startsWith($acc_file_path, 'public/')) {
                $file_path = 'public/' . $acc_file_path;
            }
        }
        if ($file_path != null) {
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            if ($id != null && $key != null) {
                $sp = SubmittedKyc::findOrFail($id);
                $saved_data = json_decode($sp->saved_data, true);
                if (isset($saved_data[$key])) {
                    if (is_array($saved_data)) {
                        $array = $saved_data[$key];
                        $index = array_search($acc_file_path, $array);
                        unset($array[$index]);
                        $saved_data[$key] = $array;
                    } else {
                        unset($saved_data[$key]);
                    }
                    dd($saved_data);
                    $sp->submitted_kyc = json_encode($saved_data);
                    $sp->save();
                }
            }
        } else {
            if ($id != null && $key != null) {
                $kyc = SubmittedKyc::where('id', $id)->firstOrFail();
                $saved_data = json_decode($kyc->saved_data, true);
                if (isset($saved_data[$key])) {
                    if (Storage::exists('public/' . $saved_data[$key])) {
                        Storage::delete('public/' . $saved_data[$key]);
                    }
                    unset($saved_data[$key]);
                    $kyc->submitted_kyc = json_encode($saved_data);
                    $kyc->save();
                }
            }
        }
        return response()->json(['message' => 'File deleted successfully.']);
    }
}
