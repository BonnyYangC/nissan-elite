<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 12:36 PM
 */

namespace App\models\role\status;


class ServiceManagerStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(9000, 14000, 23000, 33000, $yearToDate, 30000); //set 34500 instead of 40000 to prevent 'commendation' slop over
    }
}