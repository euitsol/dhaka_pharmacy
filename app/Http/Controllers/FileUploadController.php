<?php

namespace App\Http\Controllers;

use App\Models\TempFile;
use Carbon\Carbon;
use Illuminate\Http\Request;


class FileUploadController extends Controller
{
    public function uploads(Request $request)
    {
        if ($request->hasFile($request->name)) {
            $file = $request->file($request->name);
            $filename = $file->getClientOriginalName();
            $folder = uniqid();
            $file->storeAs('file/tmp/' . $folder, $filename);
            $path = "file/tmp/" . $folder;
            // $url = "file/tmp/" . $folder . "/" . $filename;

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