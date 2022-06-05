<?php

use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Session as Session;
use DB as DB;

if (!function_exists('isCFValidTimeStamp')) {
    function isCFValidTimeStamp($timestamp)
    {
        if (gettype($timestamp) == "object") {
            return false;
        }

        return ((string)(int)$timestamp === (string)$timestamp)
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= ~PHP_INT_MAX);
    }
} // if (! function_exists('isCFValidTimeStamp')) {

if (!function_exists('createDir')) {
    function createDir(array $directoriesList = [], $mode = 0777)
    {
        foreach ($directoriesList as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, $mode);
            }
        }
    }
} // if (! function_exists('createDir')) {


if (!function_exists('pregSplit')) {
    function pregSplit(string $splitter, string $string_items, bool $skip_empty = true, $to_lower = false): array
    {
        $retArray = [];
        $a        = preg_split(($splitter), $string_items);
        foreach ($a as $next_key => $next_value) {
            if ($skip_empty and (!isset($next_value) or empty($next_value))) {
                continue;
            }
            $retArray[] = ($to_lower ? strtolower(trim($next_value)) : trim($next_value));
        }
        return $retArray;
    }
} // if (! function_exists('pregSplit')) {


if (!function_exists('formatMoney')) {
    function formatMoney($value)
    {
        return number_format($value, 2, ',', '.');
    }
} // if (! function_exists('formatMoney')) {



if (!function_exists('getCFFormattedDate')) {
    function getCFFormattedDate($date, $date_format = 'mysql', $output_format = ''): string
    {
        if (empty($date)) {
            return '';
        }

        $date_carbon_format = config('app.date_carbon_format');
        if ($date_format == 'mysql' /*and !isValidTimeStamp($date)*/) {

            if (strtolower($output_format) == 'pdf_format') { // dd-mm-yyyy
                return Carbon::createFromTimestamp(strtotime($date), Config::get('app.timezone'))->format('d-m-Y');
            }

            $date_format = getDateFormat("astext");
            $date        = Carbon::createFromTimestamp(strtotime($date))->format($date_format);
            return $date;
        }

        if (isCFValidTimeStamp($date)) {
            if (strtolower($output_format) == 'astext') {
                $date_carbon_format_as_text = config('app.date_carbon_format_as_text', '%d %B, %Y');
                return Carbon::createFromTimestamp($date, Config::get('app.timezone'))->formatLocalized($date_carbon_format_as_text);
            }

            if (strtolower($output_format) == 'pickdate') {
                $date_carbon_format_as_pickdate = config('app.pickdate_format_submit');
                return Carbon::createFromTimestamp($date, Config::get('app.timezone'))->format($date_carbon_format_as_pickdate);
            } // if (strtolower($output_format) == 'pickdate') {

            if (strtolower($output_format) == 'pdf_format') { // dd-mm-yyyy
                return Carbon::createFromTimestamp($date, Config::get('app.timezone'))->format('d-m-Y');
            }

            return Carbon::createFromTimestamp($date, Config::get('app.timezone'))->format($date_carbon_format);
        }
        $A = preg_split("/ /", $date);
        if (count($A) == 2) {
            $date = $A[0];
        }
        $a = Carbon::createFromFormat($date_carbon_format, $date);
        $b = $a->format(getCFDateFormat("astext"));

        return $a->format(getCFDateFormat("astext"));
    }
} // getCFFormattedDate

if (!function_exists('getCFFormattedDateTime')) {
    function getCFFormattedDateTime($datetime, $datetime_format = 'mysql', $output_format = ''): string
    {
        if (empty($datetime)) {
            return '';
        }
        if ($datetime_format == 'mysql' and !isValidTimeStamp($datetime)) {
            if ($output_format == 'ago_format') {
                return Carbon::createFromTimestamp(strtotime($datetime))->diffForHumans();
            }
            $datetime_format = getDateTimeFormat("astext");
            $ret             = Carbon::createFromTimestamp(strtotime($datetime))->format($datetime_format);

            return $ret;
        }

        if (isValidTimeStamp($datetime)) {
            //            echo '<pre>-3::'.print_r(-3,true).'</pre><br>';
            $datetime_format = getDateTimeFormat("astext");
            $ret             = Carbon::createFromTimestamp($datetime)->format($datetime_format);
            return $ret;
        }

        return (string)$datetime;
    }
} // getCFFormattedDateTime


if (!function_exists('getDateTimeFormat')) {
    function getDateTimeFormat($format = '')
    {
        if (strtolower($format) == "numbers") {
            return 'Y-m-d H:i';
        }
        if (strtolower($format) == "astext") {
            return 'j F, Y g:i A';
        }

        return 'Y-m-d H:i';
    }
} // if ( ! function_exists('getDateTimeFormat')) {


if (!function_exists('getDateFormat')) {
    function getDateFormat($format = '')
    {
        if (strtolower($format) == "numbers") {
            return 'Y-m-d';
        }
        if (strtolower($format) == "astext") {
            return 'j F, Y';
        }

        return 'Y-m-d';
    }
} // if ( ! function_exists('getDateFormat')) {


if (!function_exists('getVatPercent')) {
    function getVatPercent($consultantProfile, $authCustomerProfile): int
    {
        //        \Log::info(  varDump($consultantProfile->id, ' -10 $consultantProfile->id::') );
        $consultantProfileCountry = $consultantProfile->country;
        //        \Log::info(varDump($consultantProfileCountry, ' -2 $consultantProfileCountry::'));
        $authCustomerProfileCountry = $authCustomerProfile->country;
        //        \Log::info(varDump($authCustomerProfileCountry, ' -2 $authCustomerProfileCountry::'));

        $norway_country_label = config('app.norway_country_label');
        if ($norway_country_label == $consultantProfileCountry or $norway_country_label == $authCustomerProfileCountry) {
            //            \Log::info(varDump($consultantProfile->profession, ' -1 $consultantProfile->profession::'));
            $consultantCategory = Categories::getByCategoryName($consultantProfile->profession)->first();
            if (!empty($consultantCategory->vat)) {
                return $consultantCategory->vat;
            }
        }
        return 0;
    }
} // if ( ! function_exists('getVatPercent')) {


if (!function_exists('calcCommonMissedNotificationsCount')) {
    function calcCommonMissedNotificationsCount(): int
    {
        $retValue            = 0;
        $missedNotifications = Session::get('missedNotifications');
        if (empty($missedNotifications) or !is_array($missedNotifications)) {
            $missedNotifications = [];
        }
        foreach ($missedNotifications as $nextMissedNotification) {
            if (!empty($nextMissedNotification['sender_total'])) {
                $retValue += $nextMissedNotification['sender_total'];
            }
        }

        return $retValue;
    }
} // if ( ! function_exists('calcCommonMissedNotificationsCount')) {


if (!function_exists('varDump')) {
    function varDump($var, $descr = '', bool $return_string = true)
    {
        if (is_null($var)) {
            $output_str = 'NULL :' . (!empty($descr) ? $descr . ' : ' : '') . 'NULL';
            if ($return_string) {
                return $output_str;
            }
            \Log::info($output_str);

            return;
        }
        if (is_scalar($var)) {
            $output_str = 'scalar => (' . gettype($var) . ') :' . (!empty($descr) ? $descr . ' : ' : '') . $var;
            if ($return_string) {
                return $output_str;
            }
            \Log::info($output_str);

            return;
        }

        if (is_array($var)) {
            $output_str = 'Array(' . count($var) . ') :' . (!empty($descr) ? $descr . ' : ' : '') . print_r(
                $var,
                true
            );
            if ($return_string) {
                return $output_str;
            }

            return;
        }

        if (class_basename($var) === 'Request' or class_basename($var) === 'LoginRequest') {
            $request     = request();
            $requestData = $request->all();
            $output_str  = 'Request:' . (!empty($descr) ? $descr . ' : ' : '') . print_r($requestData, true);
            if ($return_string) {
                return $output_str;
            }
            \Log::info($output_str);

            return;
        }

        if (class_basename($var) === 'LengthAwarePaginator' or class_basename($var) === 'Collection') {
            $collectionClassBasename = '';
            if (isset($var[0])) {
                $collectionClassBasename = class_basename($var[0]);
            }
            $output_str = ' Collection(' . count($var->toArray()) . ' of ' . $collectionClassBasename . ') :' . (!empty($descr) ? $descr . ' : ' : '') . print_r(
                $var->toArray(),
                true
            );
            if ($return_string) {
                return $output_str;
            }
            \Log::info($output_str);

            return;
        }

        if (gettype($var) === 'object') {
            if (is_subclass_of($var, 'Illuminate\Database\Eloquent\Model')) {
                $output_str = ' (Model Object of ' . get_class($var) . ') :' . (!empty($descr) ? $descr . ' : ' : '') . print_r(
                    $var/*->getAttributes()*/->toArray(),
                    true
                );
                if ($return_string) {
                    return $output_str;
                }
                \Log::info($output_str);

                return;
            }
            $output_str = ' (Object of ' . get_class($var) . ') :' . (!empty($descr) ? $descr . ' : ' : '') . print_r(
                (array)$var,
                true
            );
            if ($return_string) {
                return $output_str;
            }
            \Log::info($output_str);

            return;
        }
    }
} // if ( ! function_exists('varDump')) {
