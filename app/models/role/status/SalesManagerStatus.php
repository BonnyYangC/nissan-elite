<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 3:45 PM
 */

namespace App\models\role\status;


class SalesManagerStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(12000, 22000, 27000, 38000, $yearToDate, 50000);
    }
}