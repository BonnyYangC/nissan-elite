<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 12:00 PM
 */

namespace App\models\role\status;


class FinanceControllerStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(9000, 12000, 16000, 20000, $yearToDate, 30000);
    }
}