<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;


class BaseController extends Controller
{
    public function __construct() {
        $data['categories'] = ProductCategory::where('status',1)->where('deleted_at', null)->orderBy('name')->get();
        view()->share($data);
    }

    public function productSearch($search_value, $category){
        

        $filter = Medicine::with(['pro_sub_cat','generic','company','strength']);
        if($category !== 'all'){
            $filter = $filter->where('pro_cat_id',$category);
        }

        $data['products'] = $filter->where(function ($query) use ($search_value) {
            $query->whereHas('generic', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->where('status', 1);
                })
                ->orWhereHas('company', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->where('status', 1);
                })
                ->orWhereHas('pro_sub_cat', function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->where('status', 1);
                })
                ->orWhere('name', 'like', '%' . $search_value . '%');
        })
        ->get()->map(function ($product) {
            $product->image = storage_url($product->image);
            $product->name =(Str::ucfirst(Str::lower($product->name)));
            $product->generic->name =(Str::ucfirst(Str::lower($product->generic->name)));
            $product->company->name =(Str::ucfirst(Str::lower($product->company->name)));
            $product->pro_sub_cat->name =(Str::ucfirst(Str::lower($product->pro_sub_cat->name)));
            return $product;
        });
        return response()->json($data);
    }
}
