<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/8/18
 * Time: 11:18 AM
 */

namespace App\lib\utils;

use League\Csv\Reader;
use Carbon\Carbon;

class CsvTool
{
    /**
     * @param $filePath
     * @return Reader|null
     */
    public static function ReadFile($filePath){
        if(file_exists($filePath)){
            if (!ini_get("auto_detect_line_endings")) {
                ini_set("auto_detect_line_endings", '1');
            }
            return Reader::createFromPath($filePath);
        }
        return null;
    }

    /**
     * Convert date string from csv to Y-m-d format
     *
     * @param $dateString
     * @param string $format
     * @return string
     */
    public static function ConvertDateToYmd($dateString, $format='d/m/yy'){
        $carbon = Carbon::createFromFormat($format,$dateString);
        if($carbon){
            return $carbon->format('Y-m-d');
        }
        $result = date_parse_from_format($format,$dateString);
        if($result){
            $monthString = $result['month']<10 ? '0'.$result['month'] : $result['month'];
            $dayString = $result['day']<10 ? '0'.$result['day'] : $result['day'];
            return $result['year'].'-'.$monthString.'-'.$dayString;
        }
    }
}