<?php

namespace App\Console\Commands;

trait ImportTrait
{

    function getStrtotime($timeDateStr, $formatOfStr="d/m/Y"){
        // Same as strtotime() but using the format $formatOfStr.
        // Works with PHP version 5.5 and later.
        // On error reading the time string, returns a date that never existed. 3/09/1752 Julian/Gregorian calendar switch.
        $timeStamp = \DateTimeImmutable::createFromFormat($formatOfStr,$timeDateStr);
        if($timeStamp===false){
          // Bad date string or format string.
          return -6858133619; // 3/09/1752
        } else {
          // Date string and format ok.
          return $timeStamp->format("U"); // UNIX timestamp from 1/01/1970,  0:00:00 gmt
        }
      }
}
