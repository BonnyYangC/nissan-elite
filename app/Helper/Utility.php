<?php

namespace App\Helper;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Utility {
    CONST MONTHS_SHORT = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];
    CONST QUARTERLY_MONTHS_SHORT = ['Jun', 'Sep', 'Dec', 'Mar'];

    /**
     * @param $number
     * @return string
     */
    static function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    /**
     * export file
     *
     * @param [string] $fileName
     * @param [array] $contentData
     * @param [array] $contentMap
     * @return void
     */
    public static function exportToFile($fileName, $contentData, $contentMap) {

        $header = implode(',', array_keys($contentMap));
        $content = $header . PHP_EOL;
        foreach ($contentData as $item) {
            foreach ($contentMap as $key => $column) {
                $content .= is_array($item) ? $item[$column] . ',' : $item->$column . ',';
            }
            $content .= PHP_EOL;
        }

        file_put_contents(storage_path('app/public/'.$fileName),$content);
        return Storage::disk('public')->download($fileName);
    }

    /**
     * validate password
     *
     * @param [string] $newPassword
     * @return void
     */
    public static function validatePassword($newPassword) {
        return preg_match('^[[:graph:]]{4,20}$^', $newPassword);
    }

    /**
     * @param $dateString
     * @return string
     */
    public static function formatPeriod($dateString) {

        // Check the data string, if only 3 digits, means myy
        if(strlen($dateString) === 3){
            $carbon = Carbon::create('20'.substr($dateString,1),substr($dateString,0,1),1);
            return $carbon->format('Y-m-d');
        }
        if(strlen($dateString) === 4){
            $carbon = Carbon::create('20'.substr($dateString,2),substr($dateString,0,2),1);
            return $carbon->format('Y-m-d');
        }
    }

    /**
     * @param $pct
     * @return string
     */
    public static function convert2DigitPct($pct) {
        $ori_pct = trim($pct);
        if (($ori_pct === null) || ($ori_pct === '')) {
            $new_pct = '';
        } else {
            $new_pct = number_format(intval(floatval(str_replace('%','',$ori_pct))*100)/100,2) . '%';
        }
        return $new_pct;
    }

}
