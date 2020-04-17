<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 11:38 AM
 */

namespace App\models\role\status;


class StockControllerStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(10000, 14000, 18000, 24000, $yearToDate, 30000);
    }
}