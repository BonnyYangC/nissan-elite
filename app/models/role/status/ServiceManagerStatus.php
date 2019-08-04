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
        parent::__construct(9000, 13000, 22000, 33000, $yearToDate, 34500);
    }
}