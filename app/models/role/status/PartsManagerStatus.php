<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 12:23 PM
 */

namespace App\models\role\status;


class PartsManagerStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(7000, 13000, 22000, 33000, $yearToDate, 40000);
    }
}