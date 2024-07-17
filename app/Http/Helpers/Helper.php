<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use League\Csv\Writer;
use App\Models\Permission;
use App\Models\PointSetting;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;


//This will retun the route prefix of the routes for permission check
function get_permission_routes()
{
    return [
        'am.', 'um.', 'pm.', 'pm.', 'rm.', 'opa.', 'do.', 'pym.', 'push.', 'settings.', 'dm_management.', 'lam_management.', 'product.', 'payment_gateway.', 'obp.', 'om.', 'withdraw_method.', 'withdraw.'
    ];
}

//This will check the permission of the given route name. Can be used for buttons
function check_access_by_route_name($routeName = null): bool
{



    if ($routeName == null) {
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
// function createCSV($filename = 'permissions.csv'): string
// {
//     $permissions = Permission::all();

//     $data = $permissions->each(function ($permission) {
//         return [
//             'name' => $permission->name,
//             'guard_name' => $permission->guard_name,
//             'prefix' => $permission->prefix,
//         ];
//     });

//     $csv = Writer::createFromPath(public_path('csv/' . $filename), 'w+');

//     $csv->insertOne(array_keys($data->first()));

//     foreach ($data as $record) {
//         $csv->insertOne($record);
//     }

//     return public_path('csv/' . $filename);
// }

function createCSV($filename = 'permissions.csv'): string
{
    $permissions = Permission::all(['name', 'guard_name', 'prefix']);

    $csvPath = public_path('csv/' . $filename);
    // Ensure the directory exists
    File::ensureDirectoryExists(dirname($csvPath));
    // Create the CSV writer
    $csv = Writer::createFromPath($csvPath, 'w+');
    // Insert header
    $csv->insertOne(['name', 'guard_name', 'prefix']);
    // Insert records
    foreach ($permissions as $permission) {
        $csv->insertOne([
            $permission->name,
            $permission->guard_name,
            $permission->prefix,
        ]);
    }
    return $csvPath;
}

function storage_url($urlOrArray)
{
    $image = asset('frontend/default/default.png');
    if (is_array($urlOrArray) || is_object($urlOrArray)) {
        $result = '';
        $count = 0;
        $itemCount = count($urlOrArray);
        foreach ($urlOrArray as $index => $url) {

            $result .= $url ? asset('storage/' . $url) : $image;

            if ($count === $itemCount - 1) {
                $result .= '';
            } else {
                $result .= ', ';
            }
            $count++;
        }
        return $result;
    } else {
        return $urlOrArray ? asset('storage/' . $urlOrArray) : $image;
    }
}

function auth_storage_url($urlOrArray, $gender)
{
    $image = asset('default_img/other.png');
    if ($gender == 'Male') {
        $image = asset('default_img/male.png');
    } elseif ($gender == 'Male') {
        $image = asset('default_img/female.png');
    }

    if (is_array($urlOrArray) || is_object($urlOrArray)) {
        $result = '';
        $count = 0;
        $itemCount = count($urlOrArray);
        foreach ($urlOrArray as $index => $url) {

            $result .= $url ? asset('storage/' . $url) : $image;

            if ($count === $itemCount - 1) {
                $result .= '';
            } else {
                $result .= ', ';
            }
            $count++;
        }
        return $result;
    } else {
        return $urlOrArray ? asset('storage/' . $urlOrArray) : $image;
    }
}

function product_image($url)
{
    return $url ? asset('storage/' . $url) : asset('frontend/default/product.png');
}

function unit_image($url)
{
    return $url ? asset('storage/' . $url) : asset('frontend/default/default.png');
}
function timeFormate($time)
{
    $dateFormat = env('DATE_FORMAT', 'd-M-Y');
    $timeFormat = env('TIME_FORMAT', 'H:i A');
    return date($dateFormat . " " . $timeFormat, strtotime($time));
}

function user()
{
    return auth()->guard('web')->user();
}
function admin()
{
    return auth()->guard('admin')->user();
}
function pharmacy()
{
    return auth()->guard('pharmacy')->user();
}
function dm()
{
    return auth()->guard('dm')->user();
}
function lam()
{
    return auth()->guard('lam')->user();
}
function rider()
{
    return auth()->guard('rider')->user();
}

function mainMenuCheck($array)
{
    $check = false;

    $allowedPrefixes = get_permission_routes();
    foreach ($array['prefixes'] as $prefix) {
        if (in_array($prefix, $allowedPrefixes)) {
            foreach ($array['routes'] as $route) {
                if (auth()->user()->can($route)) {
                    $check = true;
                    break;
                }
            }
        } else {
            $check = true;
            break;
        }
    }
    return $check;
}

function availableTimezones()
{
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
function settings($key)
{
    $setting = SiteSetting::where('key', $key)->where('deleted_at', null)->first();
    if ($setting) {
        return $setting->value;
    }
}


function file_name_from_url($url = null)
{
    if ($url) {
        $fileNameWithExtension = basename($url);
        return $fileNameWithExtension;
    }
}


function file_title_from_url($url = null)
{
    if ($url) {
        $fileTitle = pathinfo($url, PATHINFO_FILENAME);
        return $fileTitle;
    }
}
function removeHttpProtocol($url)
{
    return str_replace(['http://', 'https://'], '', $url);
}

function str_limit($data, $limit = 20, $end = '...')
{
    return Str::limit($data, $limit, $end);
}

function generateOrderId($type = 'web')
{
    if ($type == 'web') {
        $prefix = 'DPW';
    } elseif ($type == 'api') {
        $prefix = 'DPA';
    } else {
        $prefix = 'DP';
    }

    $microseconds = explode(' ', microtime(true))[0];

    $date = date('ymd');
    $time = date('is');

    return $prefix . $date . $time . mt_rand(10000, 99999);
}
function generateTranId()
{
    $prefix = 'SSL'; // Specify the prefix
    $numericPart = mt_rand(100000, 999999); // Generates 5 random alphanumeric characters
    $date = date('d'); // Generates 5 random alphanumeric characters

    return $prefix . $date . $numericPart;
}

function calculateProductDiscount($product, $isPercent = false)
{
    $discount = $product->discounts->where('status', 1)->first();
    if ($discount) {
        if ($isPercent) {
            if (!empty($discount->discount_amount)) {
                return ($discount->discount_amount / $product->price) * 100;
            } elseif (!empty($discount->discount_percentage)) {
                return $discount->discount_percentage;
            } else {
                return 0; // No discount
            }
        } else {
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
function proDisPrice($price, $pro_discounts)
{
    $discount = $pro_discounts->where('status', 1)->first();
    if ($discount) {
        if (!empty($discount->discount_amount)) {
            return ($price - $discount->discount_amount);
        } else if (!empty($discount->discount_percentage)) {
            return ($price - (($price / 100) * $discount->discount_percentage));
        }
    }
    return $price;
}
function formatPercentageNumber($number)
{
    $formattedNumber = rtrim(rtrim(number_format($number, 2), '0'), '.');
    return $formattedNumber;
}

function otp()
{
    $otp =  mt_rand(100000, 999999);
    // $otp =  '000000';
    return $otp;
}

function get_taka_icon()
{
    return '&#2547; ';
}


function c_user_name($user)
{
    return $user->name ?? 'System';
}
function u_user_name($user)
{
    return $user->name ?? '--';
}
/**
 * Calculate the remaining time until the end time.
 *
 * @param string $endTime The end time.
 * @param bool $html Whether to return HTML formatted string.
 * @return string
 */
function remainingTime($endTime, $html = false)
{
    $end = Carbon::parse($endTime);
    $now = Carbon::now();
    $difference = $now->diffForHumans($end, [
        'parts' => 2,
        'join' => ', ',
        'syntax' => Carbon::DIFF_ABSOLUTE,
        'short' => true,
    ]);

    if ($now->lessThan($end)) {
        $result = $html ? "<span class='prep_time text-success' data-end-time='$endTime'>$difference remaining</span>" : "$difference remaining";
    } else {
        $result = $html ? "<span class='prep_time text-danger' data-end-time='$endTime'>Delayed</span>" : 0;
    }
    return $result;
}

function prepTimeConverter($end_time)
{
    $duration = Carbon::now()->diff(Carbon::parse($end_time));
}

function prepTotalSeconds($start_time, $end_time)
{
    $duration = Carbon::parse($end_time)->diff(Carbon::parse($start_time));
    $totalSeconds = $duration->s + ($duration->i * 60) + ($duration->h * 3600) + ($duration->days * 86400);
    return $totalSeconds;
}


function formatOperationArea($pharmacy)
{
    return $pharmacy->operation_area ? '(' . $pharmacy->operation_area->name . ($pharmacy->operation_sub_area ? ' - ' : ')') : '';
}
function sendResponse($success, $message, $data = null, $statusCode = 200, $additional = null)
{
    $responseData = [
        'success' => $success,
        'message' => $message,
        'data' => $data
    ];
    if (!empty($additional) && is_array($additional)) {
        $responseData = array_merge($responseData, $additional);
    }

    return response()->json($responseData, $statusCode);
}

function formatOperationSubArea($pharmacy)
{
    return $pharmacy->operation_sub_area ? ($pharmacy->operation_area ? $pharmacy->operation_sub_area->name . ' )' : '( ' . $pharmacy->operation_sub_area->name . ' )') : '';
}

function formatPharmacyOption($pharmacy)
{
    $area = formatOperationArea($pharmacy);
    $sub_area = formatOperationSubArea($pharmacy);
    return $pharmacy->name . $area . $sub_area;
}

function abbreviateName($name)
{
    $words = explode(' ', $name);
    if (count($words) == 1) {
        return $name;
    }
    $abbreviated = array_map(function ($word) {
        return strtoupper(substr($word, 0, 1));
    }, array_slice($words, 0, -1));
    $abbreviated[] = end($words);
    return implode(' ', $abbreviated);
}

function getFileType($filename)
{
    $path = storage_path('app/public/' . $filename);
    if (!file_exists($path)) {
        return NULL;
    }
    $fileMimeType = mime_content_type($path);
    switch ($fileMimeType) {
        case strpos($fileMimeType, 'image/') === 0:
            return 'image';
        case 'application/pdf':
            return 'pdf';
        case strpos($fileMimeType, 'video/') === 0:
            return 'video';
        default:
            return 'others';
    }
}

function pdf_storage_url($urlOrArray)
{
    if (is_array($urlOrArray) || is_object($urlOrArray)) {
        $result = '';
        $count = 0;
        $itemCount = count($urlOrArray);
        foreach ($urlOrArray as $index => $url) {

            $result .= asset('/laraview/#../storage/' . $url);

            if ($count === $itemCount - 1) {
                $result .= '';
            } else {
                $result .= ', ';
            }
            $count++;
        }
        return $result;
    } else {
        return asset('/laraview/#../storage/' . $urlOrArray);
    }
}

function getFormattedCountdown($pastDate)
{
    if (!($pastDate instanceof Carbon)) {
        $pastDate = Carbon::parse($pastDate);
    }

    $now = Carbon::now();
    // Check if the past date has passed
    if ($pastDate->gt($now)) {
        $years = $pastDate->diffInYears($now);
        $weeks = $pastDate->diffInWeeks($now) % 52;
        $days = $pastDate->diffInDays($now) % 7;
        $hours = $pastDate->diffInHours($now) % 24;
        $minutes = $pastDate->diffInMinutes($now) % 60;
        $seconds = $pastDate->diffInSeconds($now) % 60;
    } else {
        $years = $weeks = $days = $hours = $minutes = $seconds = 0;
    }

    $countdown = [
        'years' => $years,
        'weeks' => $weeks,
        'days' => $days,
        'hours' => $hours,
        'minutes' => $minutes,
        'seconds' => $seconds,
    ];

    return $countdown;
}

//This function will check the if the given route is a route name or full url
function is_valid_route($routeOrUrl)
{
    if (!empty($routeOrUrl) && (Route::has($routeOrUrl))) {
        return true;
    } else {
        return false;
    }
}

function slugToTitle($slug)
{
    return ucwords(strtolower(str_replace('-', ' ', $slug)));
}
function activatedTime($startTime, $endTime)
{
    $startTime = Carbon::parse($startTime);
    $endTime = Carbon::parse($endTime);

    if ($startTime->eq($endTime)) {
        $endTime = Carbon::now();
        $active = ' - continue';
    } else {
        $active = '';
    }

    $diffInSeconds = $startTime->diffInSeconds($endTime);

    $days = intdiv($diffInSeconds, 86400);
    $diffInSeconds %= 86400;

    $hours = intdiv($diffInSeconds, 3600);
    $diffInSeconds %= 3600;

    $minutes = intdiv($diffInSeconds, 60);
    $seconds = $diffInSeconds % 60;

    $string = '';

    if ($days > 0) {
        $string .= $days . ($days > 1 ? ' days, ' : ' day, ');
    }
    if ($hours > 0) {
        $string .= $hours . ($hours > 1 ? ' hours, ' : ' hour, ');
    }
    if ($minutes > 0) {
        $string .= $minutes . ($minutes > 1 ? ' minutes, ' : ' minute, ');
    }
    if ($seconds > 0) {
        $string .= $seconds . ($seconds > 1 ? ' seconds' : ' second');
    }

    return rtrim($string, ', ') . $active;
}

function getPointName()
{
    return PointSetting::where('key', 'point_name')->first()->value;
}

function translate($text)
{
    $locale = App::getLocale();
    try {
        $translatedText = GoogleTranslate::trans($text, $locale, null, ['verify' => false]);
    } catch (Exception $e) {
        $translatedText = $text;
    }
    return $translatedText;
}
function getEarningPoints($earnings)
{
    return ($earnings->where('activity', 1)->sum('point') - ($earnings->where('activity', 2)->sum('point') + $earnings->where('activity', 4)->sum('point')));
}
function getEarningEqAmounts($earnings)
{
    return ($earnings->where('activity', 1)->sum('eq_amount') - ($earnings->where('activity', 2)->sum('eq_amount') + $earnings->where('activity', 4)->sum('eq_amount')));
}
function getWithdrawPoints($earnings)
{
    return $earnings->where('activity', 2)->sum('point');
}
function getWithdrawEqAmounts($earnings)
{
    return $earnings->where('activity', 2)->sum('eq_amount');
}
function getPendingWithdrawPoints($earnings)
{
    return $earnings->where('activity', 4)->sum('point');
}
function getPendingWithdrawEqAmounts($earnings)
{
    return $earnings->where('activity', 4)->sum('eq_amount');
}
function getPendingEarningPoints($earnings)
{
    return $earnings->where('activity', 3)->sum('point');
}
function getPendingEarningEqAmounts($earnings)
{
    return $earnings->where('activity', 3)->sum('eq_amount');
}
