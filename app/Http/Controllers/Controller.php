<?php

namespace App\Http\Controllers;

use App\Models\AddToCart;
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
    public function featuredChange($modelData)
    {
        if($modelData->is_featured == 1){
            $modelData->is_featured = 0;
        }else{
            $modelData->is_featured = 1;
        }
        // $modelData->updated_by = admin()->id;
        $modelData->save();
    }
    public function menuChange($modelData)
    {
        if($modelData->is_menu == 1){
            $modelData->is_menu = 0;
        }else{
            $modelData->is_menu = 1;
        }
        $modelData->save();
    }
    public function bestSellingChange($modelData)
    {
        if($modelData->is_best_selling == 1){
            $modelData->is_best_selling = 0;
        }else{
            $modelData->is_best_selling = 1;
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

    public function view_or_download($file_url){
        $file_url = base64_decode($file_url);
        dd($file_url);
        if (Storage::exists('public/' . $file_url)) {
            $fileExtension = pathinfo($file_url, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) === 'pdf') {
                return response()->file(storage_path('app/public/' . $file_url), [
                    'Content-Disposition' => 'inline; filename="' . basename($file_url) . '"'
                ]);
            } else {
                return response()->download(storage_path('app/public/' . $file_url), basename($file_url));
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    // public function calculateTotalPrice($orderDistribution) {
    //     return AddToCart::with('product')
    //         ->whereIn('id', json_decode($orderDistribution->order->carts))
    //         ->get()
    //         ->sum(function ($item){
    //             $discountedPrice = $item->product->discountPrice();
    //             $quantity = $item->quantity;
    //             $unitQuantity = $item->unit->quantity ?? 1;
    //             return ($discountedPrice * $unitQuantity * $quantity);
    //         });
    // }
}
