<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 11:01 AM
 */

namespace App\models\role\status;


class ServiceAdviserStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(9000, 14000, 23000, 33000, $yearToDate, 34500); //set 34500 instead of 40000 to prevent 'commendation' slop over
    }
}