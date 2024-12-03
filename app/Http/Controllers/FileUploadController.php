<?php

namespace App\Http\Controllers;

use App\Models\ContentImage;
use App\Models\SubmittedKyc;
use App\Models\TempFile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
                $submitted_data = json_decode($sp->submitted_data, true);
                if (isset($submitted_data[$key])) {
                    if (is_array($submitted_data)) {
                        $array = $submitted_data[$key];
                        $index = array_search($acc_file_path, $array);
                        unset($array[$index]);
                        $submitted_data[$key] = $array;
                    } else {
                        unset($submitted_data[$key]);
                    }
                    $sp->submitted_data = json_encode($submitted_data);
                    $sp->save();
                }
            }
        } else {
            if ($id != null && $key != null) {
                $kyc = SubmittedKyc::where('id', $id)->firstOrFail();
                $submitted_data = json_decode($kyc->submitted_data, true);
                if (isset($submitted_data[$key])) {
                    if (Storage::exists('public/' . $submitted_data[$key])) {
                        Storage::delete('public/' . $submitted_data[$key]);
                    }
                    unset($submitted_data[$key]);
                    $kyc->submitted_data = json_encode($submitted_data);
                    $kyc->save();
                }
            }
        }
        flash()->addSuccess('File deleted successfully.');
        return redirect()->back();
    }


    public function content_image_upload(Request $request): JsonResponse
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = $file->getClientOriginalName();
            $folder = uniqid();
            $file->storeAs('content_image/' . $folder, $filename, 'public');
            $path = "content_image/" . $folder;

            $save = new ContentImage();
            $save->path = $path;
            $save->filename = $filename;
            $save->created_at = Carbon::now()->toDateTimeString();
            $save->creater()->associate(admin());
            $save->save();
            return response()->json([
                'success' => 'File upload successfully',
                'url' => asset('storage/' . $path . '/' . $filename),
                'data_id' => $save->id,
            ]);
        }
        return response()->json(['error' => 'File upload failed'], 400);
    }
}