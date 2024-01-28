<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    
    public function statusChange($modelData)
    {
        if($modelData->status == 1){
            $modelData->status = 0;
        }else{
            $modelData->status = 1;
        }
        // $modelData->updated_by = admin()->id;
        $modelData->save();
    }
    public function fileDelete($image)
    {
        if ($image) {
            Storage::delete('public/' . $image);
        }
    }
}
