<?php

use App\Models\Discount;
use App\Models\Medicine;
use App\Models\MedicineUnit;
use Illuminate\Support\Facades\Route;
use League\Csv\Writer;
use App\Models\Permission;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


//This will retun the route prefix of the routes for permission check
function get_permission_routes()
{
  return [
            'am.','um.','pm.','om.','rm.','opa.','do.','pym.','push.','settings.','dm_management.','lam_management','product.','payment_gateway.'
        ];
}

//This will check the permission of the given route name. Can be used for buttons
function check_access_by_route_name($routeName = null): bool
{



    if($routeName == null){
        $routeName = Route::currentRouteName();

    }
    $allowedPrefixes = get_permission_routes();

    $shouldCheckPermission = false;
    foreach ($allowedPrefixes as $prefix) {
        if (str_starts_with($routeName, $prefix)) {
            $shouldCheckPermission = true;
            break;
        }
    }

    if ($shouldCheckPermission) {
        $routeParts = explode('.', $routeName);
        $lastRoutePart = end($routeParts);

        if (!auth()->user()->can($lastRoutePart)) {
            return false;
        }
    }

    return true;
}

//This will export the permissions as csv for seeders
function createCSV($filename = 'permissions.csv'): string
{
    $permissions = Permission::all();

    $data = $permissions->map(function ($permission) {
        return [
            'name' => $permission->name,
            'guard_name' => $permission->guard_name,
            'prefix' => $permission->prefix,
        ];
    });

    $csv = Writer::createFromPath(public_path('csv/' . $filename), 'w+');

    $csv->insertOne(array_keys($data->first()));

    foreach ($data as $record) {
        $csv->insertOne($record);
    }

    return public_path('csv/' . $filename);
}

function storage_url($urlOrArray){
    if (is_array($urlOrArray) || is_object($urlOrArray)) {
        $result = '';
        $count = 0;
        $itemCount = count($urlOrArray);
        foreach ($urlOrArray as $index => $url) {

            $result .= $url ? asset('storage/'.$url) : asset('frontend\default\cat_img.png');

            if($count === $itemCount - 1) {
                $result .= '';
            }else{
                $result .= ', ';
            }
            $count++;
        }
        return $result;
    } else {
        return $urlOrArray ? asset('storage/'.$urlOrArray) : asset('frontend\default\cat_img.png');
    }
}

function timeFormate($time){
    $dateFormat = env('DATE_FORMAT', 'd-M-Y');
    $timeFormat = env('TIME_FORMAT', 'H:i A');
    return date($dateFormat." ".$timeFormat, strtotime($time));
}

function user(){
    return auth()->guard('web')->user();
}
function admin(){
    return auth()->guard('admin')->user();
}
function pharmacy(){
    return auth()->guard('pharmacy')->user();
}
function dm(){
    return auth()->guard('dm')->user();
}
function lam(){
    return auth()->guard('lam')->user();
}
function rider(){
    return auth()->guard('rider')->user();
}


function mainMenuCheck($array){
    $check = false;

    $allowedPrefixes = get_permission_routes();
    foreach($array['prefixes'] as $prefix){
        if(in_array($prefix, $allowedPrefixes)){
            foreach($array['routes'] as $route){
                if (auth()->user()->can($route)) {
                    $check = true;
                    break;
                }
            }
        }

    }
    return $check;
}

function availableTimezones(){
    $timezones = [];
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();

    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $timezone = new DateTimeZone($timezoneIdentifier);
        $offset = $timezone->getOffset(new DateTime());
        $offsetPrefix = $offset < 0 ? '-' : '+';
        $offsetFormatted = gmdate('H:i', abs($offset));

        $timezones[] = [
            'timezone' => $timezoneIdentifier,
            'name' => "(UTC $offsetPrefix$offsetFormatted) $timezoneIdentifier",
        ];
    }

    return $timezones;
}
function settings($key){
    $setting = SiteSetting::where('key',$key)->where('deleted_at', null)->first();
    if($setting){
        return $setting->value;
    }
}


function file_name_from_url($url = null){
    if($url){
        $fileNameWithExtension = basename($url);
        return $fileNameWithExtension;
    }
}


function file_title_from_url($url = null){
    if($url){
        $fileTitle = pathinfo($url, PATHINFO_FILENAME);
        return $fileTitle;
    }
}
function removeHttpProtocol($url)
{
    return str_replace(['http://', 'https://'], '', $url);
}

function str_limit($data, $limit = 20, $end = '...'){
    return Str::limit($data, $limit, $end);
}

function generateOrderId() {
    // $alphaPart = strtoupper(Str::random(3)); // Generates 3 random uppercase letters
    $numericPart = mt_rand(100000, 999999); // Generates 5 random alphanumeric characters

    $alphaPart = 'DP';
    $date = date('d'); // Generates 5 random alphanumeric characters


    return $alphaPart.$date.$numericPart;
}
function generateTranId() {
    $prefix = 'SSL'; // Specify the prefix
    $numericPart = mt_rand(100000, 999999); // Generates 5 random alphanumeric characters
    $date = date('d'); // Generates 5 random alphanumeric characters

    return $prefix.$date.$numericPart;
}
// function productDiscountAmount($pro_id){
//     $discount = Discount::activated()
//                 ->where('pro_id', $pro_id)
//                 ->where(function ($query) {
//                     $query->whereNotNull('discount_amount')
//                         ->orWhereNotNull('discount_percentage');
//                 })->where('status',1)
//                 ->first();
//     if($discount){
//         if(!empty($discount->discount_amount)){
//             return $discount->discount_amount;
//         }
//         else if(!empty($discount->discount_percentage)){
//             return ($discount->product->price/100)*$discount->discount_percentage;
//         }
//     }
// }


// function productDiscountPercentage($pro_id){
//     $discount = Discount::activated()
//                 ->where('pro_id', $pro_id)
//                 ->where(function ($query) {
//                     $query->whereNotNull('discount_amount')
//                         ->orWhereNotNull('discount_percentage');
//                 })->where('status',1)
//                 ->first();
//     $result = 0;
//     if($discount){
//         if(!empty($discount->discount_amount)){
//             $result = ($discount->discount_amount/$discount->product->price)*100;
//         }
//         else if(!empty($discount->discount_percentage)){
//             $result = $discount->discount_percentage;
//         }

//         return $result;
//     }
// }

function calculateProductDiscount($product, $isPercent = false) {
    $discount = $product->discounts->where('status', 1)->first();
    if($discount){
        if($isPercent){
            if (!empty($discount->discount_amount)) {
                return ($discount->discount_amount/$product->price)*100;
            } elseif (!empty($discount->discount_percentage)) {
                return $discount->discount_percentage;
            } else {
                return 0; // No discount
            }
        }else{
            if (!empty($discount->discount_amount)) {
                return $discount->discount_amount;
            } elseif (!empty($discount->discount_percentage)) {
                return ($product->price / 100) * $discount->discount_percentage;
            } else {
                return 0; // No discount
            }
        }
    }
    
    
}






function formatPercentageNumber($number) {
    $formattedNumber = rtrim(rtrim(number_format($number,2), '0'), '.');
    return $formattedNumber;
}

function otp(){
    // $otp =  mt_rand(100000, 999999);
    $otp =  000000;
    return $otp;
}

function get_taka_icon(){
    return '&#2547; ';
}


function c_user_name($user){
    return $user->name ?? 'System';
}
function u_user_name($user){
    return $user->name ?? '--';
}

function readablePrepTime($start_time, $end_time){
    $duration = Carbon::parse($end_time)->diff(Carbon::parse($start_time));
    $formattedDuration = '';
    if ($duration->h > 0) {
        $formattedDuration .= $duration->h . ' hours ';
    }
    if ($duration->i > 0) {
        $formattedDuration .= $duration->i . ' minutes';
    }
    return $formattedDuration;
}

function prepTotalSeconds($start_time, $end_time){
    $duration = Carbon::parse($end_time)->diff(Carbon::parse($start_time));
    $totalSeconds = $duration->s + ($duration->i * 60) + ($duration->h * 3600) + ($duration->days * 86400);
    return $totalSeconds;
}

function formatOperationArea($pharmacy) {
    return $pharmacy->operation_area ? '(' . $pharmacy->operation_area->name . ($pharmacy->operation_sub_area ? ' - ' : ')') : '';
}

function formatOperationSubArea($pharmacy) {
    return $pharmacy->operation_sub_area ? ($pharmacy->operation_area ? $pharmacy->operation_sub_area->name . ' )' : '( ' . $pharmacy->operation_sub_area->name . ' )') : '';
}

function formatPharmacyOption($pharmacy) {
    $area = formatOperationArea($pharmacy);
    $sub_area = formatOperationSubArea($pharmacy);
    return $pharmacy->name . $area . $sub_area;
}
