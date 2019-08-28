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
        parent::__construct(8000, 12000, 16000, 22000, $yearToDate, 30000);
    }
}